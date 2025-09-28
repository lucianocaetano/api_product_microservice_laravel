<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use RdKafka\Consumer;
use RdKafka\TopicConf;
use Src\product\infrastructure\events\CreatedProduct;
use Src\product\infrastructure\events\DeletedProduct;
use Src\product\infrastructure\events\UpdatedProduct;
use Src\shared\infrastructure\mediator\MediatorEventInterface;

class KafkaConsumer extends Command
{
    protected $signature = 'kafka:consume';

    public function handle()
    {
        $conf = new \RdKafka\Conf();
        $conf->set('group.id', 'my-consumer-group');

        $consumer = new Consumer($conf);
        $consumer->addBrokers(env('KAFKA_HOST'));

        $topicConf = new TopicConf();
        $topicConf->set('auto.commit.interval.ms', '100');

        $topic = $consumer->newTopic('inventory', $topicConf);

        $topic->consumeStart(0, -2);

        while (true) {
            $message = $topic->consume(0, 1000);
            if ($message) {
                switch ($message->err) {
                    case 0:
                        $mediator = app(MediatorEventInterface::class);

                        $payload = json_decode($message->payload, true);

                        if($payload['event'] == 'product.created') {
                            $payload = $payload["payload"];
                            $mediator->dispatch(
                                new CreatedProduct(
                                    $payload['id'],
                                    $payload['slug'],
                                    $payload['name'],
                                    $payload['description'],
                                    $payload['quantity'],
                                    $payload['amount'],
                                    $payload['currency'],
                                    $payload['category_id']
                                )
                            );
                        }

                        if($payload['event'] == 'product.deleted') {
                            $payload = $payload["payload"];
                            $mediator->dispatch(
                                new DeletedProduct(
                                    $payload['id'],
                                )
                            );
                        }

                        if($payload['event'] == 'product.updated') {
                            $payload = $payload["payload"];
                            $mediator->dispatch(
                                new UpdatedProduct(
                                    $payload['id'],
                                    $payload['slug'],
                                    $payload['name'],
                                    $payload['description'],
                                    $payload['quantity'],
                                    $payload['amount'],
                                    $payload['currency'],
                                    $payload['category_id']
                                )
                            );
                        }
                        break;
                    case -191:
                        break;
                    default:
                        $this->error($message->errstr());
                        break;
                }
            }
        }
    }
}

