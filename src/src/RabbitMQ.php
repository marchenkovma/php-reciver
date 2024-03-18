<?php

declare(strict_types=1);

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQ
{
    private AMQPStreamConnection $connection;
    private AMQPChannel $channel;

    public function __construct()
    {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        $host = $_ENV['RABBITMQ_HOST'];
        $port = $_ENV['RABBITMQ_PORT'];
        $username = $_ENV['RABBITMQ_USERNAME'];
        $password = $_ENV['RABBITMQ_PASSWORD'];

        $connection = new AMQPStreamConnection($host, $port, $username, $password);
        $this->channel = $connection->channel();

        $queueName = $_ENV['RABBITMQ_QUEUE_NAME'];
        $this->channel->queue_declare($queueName, false, true, false, false);
    }

    public function send(string $message): void
    {
        $amqpMessage = new AMQPMessage($message);
        $this->channel->basic_publish('', $_ENV['RABBITMQ_QUEUE_NAME'], $amqpMessage);
    }

    public function receive(): ?string
    {
        $message = $this->channel->basic_get($_ENV['RABBITMQ_QUEUE_NAME'], true);

        if ($message === null) {
            return null;
        }

        $this->channel->basic_ack($message->delivery_tag);

        return $message->body;
    }

    public function close(): void
    {
        $this->channel->close();
        $this->connection->close();
    }
}


require 'vendor/autoload.php';

$rabbitmq = new RabbitMQ();

$rabbitmq->send('Hello, world!');

$message = $rabbitmq->receive();

echo $message . PHP_EOL;

$rabbitmq->close();
