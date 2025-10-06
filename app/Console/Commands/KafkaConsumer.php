<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use RdKafka\Consumer;
use RdKafka\TopicConf;
use Src\category\infrastructure\events\CreatedCategory;
use Src\category\infrastructure\events\DeletedCategory;
use Src\category\infrastructure\events\UpdatedCategory;
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

        $securityProtocol = getenv('KAFKA_SECURITY_PROTOCOL');
        $saslMechanism   = getenv('KAFKA_SASL_MECHANISM');
        $saslUsername    = getenv('KAFKA_SASL_USERNAME');
        $saslPassword    = getenv('KAFKA_SASL_PASSWORD');

        $mediator = app(MediatorEventInterface::class);

        if ($securityProtocol && $saslMechanism && $saslUsername && $saslPassword) {
            $conf->set('security.protocol', $securityProtocol);
            $conf->set('sasl.mechanisms', $saslMechanism);
            $conf->set('sasl.username', $saslUsername);
            $conf->set('sasl.password', $saslPassword);
        }

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
                        $payload = json_decode($message->payload, true);

                        if($payload['event'] == 'category.created') {
                            $data = $payload["payload"];
                            $mediator->dispatch(
                                new CreatedCategory(
                                    $data['id'],
                                    $data['slug'],
                                    $data['name'],
                                    $data['parent']
                                )
                            );
                        }

                        if($payload['event'] == 'category.deleted') {
                            $data = $payload["payload"];
                            $mediator->dispatch(
                                new DeletedCategory(
                                    $data['id'],
                                )
                            );
                        }

                        if($payload['event'] == 'category.updated') {
                            $data = $payload["payload"];
                            $mediator->dispatch(
                                new UpdatedCategory(
                                    $data['id'],
                                    $data['slug'],
                                    $data['name'],
                                    $data['parent'],
                                )
                            );
                        }

                        if($payload['event'] == 'product.created') {
                            $data = $payload["payload"];
                            $mediator->dispatch(
                                new CreatedProduct(
                                    $data['id'],
                                    $data['slug'],
                                    $data['name'],
                                    $data['description'],
                                    $data['quantity'],
                                    $data['amount'],
                                    $data['currency'],
                                    $data['category_slug']
                                )
                            );
                        }

                        if($payload['event'] == 'product.deleted') {
                            $data = $payload["payload"];
                            $mediator->dispatch(
                                new DeletedProduct(
                                    $data['id'],
                                )
                            );
                        }

                        if($payload['event'] == 'product.updated') {
                            $data = $payload["payload"];
                            $mediator->dispatch(
                                new UpdatedProduct(
                                    $data['id'],
                                    $data['slug'],
                                    $data['name'],
                                    $data['description'],
                                    $data['quantity'],
                                    $data['amount'],
                                    $data['currency'],
                                    $data['category_slug']
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

