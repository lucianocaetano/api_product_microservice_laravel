<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use RdKafka\Producer;
use RdKafka\ProducerTopic;

class KafkaProducer
{
    use RefreshDatabase;

    private static self|null $instance = null;
    private array $config;
    private Producer $producer;
    private ProducerTopic $topic;

    private function __construct()
    {
        $this->config = [
            'bootstrap.servers' => getenv('KAFKA_HOST'),
            'topic' => 'inventory',
            "security.protocol" => getenv('KAFKA_SECURITY_PROTOCOL'),
            'sasl.mechanisms' => getenv('KAFKA_SASL_MECHANISM'),
            'sasl.username' => getenv('KAFKA_SASL_USERNAME'),
            'sasl.password' => getenv('KAFKA_SASL_PASSWORD'),
        ];

        $config_kafka = new \RdKafka\Conf();

        $securityProtocol = $this->config['security.protocol'];
        $saslMechanism   = $this->config['sasl.mechanisms'];
        $saslUsername    = $this->config['sasl.username'];
        $saslPassword    = $this->config['sasl.password'];

        if ($securityProtocol && $saslMechanism && $saslUsername && $saslPassword) {
            $config_kafka->set('security.protocol', $securityProtocol);
            $config_kafka->set('sasl.mechanisms', $saslMechanism);
            $config_kafka->set('sasl.username', $saslUsername);
            $config_kafka->set('sasl.password', $saslPassword);
        }

        $config_kafka->set('bootstrap.servers', $this->config['bootstrap.servers']);
        $this->producer = new Producer($config_kafka);
        $this->topic = $this->producer->newTopic($this->config['topic']);
    }

    public function produce(string $eventName, array $payload): void
    {
        $this->topic->produce(-1, 0, json_encode([
            'event' => $eventName,
            'payload' => $payload
        ]));

        $this->producer->flush(10000);
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
