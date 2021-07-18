<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitmqPublisher extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'rabbit mq publisher';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $connection = new AMQPStreamConnection(
            '121.5.22.144',
            5672,
            'ems',
            '123',
            '/ems'
        );

        $channel = $connection->channel();

        /**
         * 创建队列(Queue)
         * name: hello         // 队列名称
         * passive: false      // 如果设置true存在则返回OK，否则就报错。设置false存在返回OK，不存在则自动创建
         * durable: true       // 是否持久化，设置false是存放到内存中的，RabbitMQ重启后会丢失
         * exclusive: false    // 是否排他，指定该选项为true则队列只对当前连接有效，连接断开后自动删除
         *  auto_delete: false // 是否自动删除，当最后一个消费者断开连接之后队列是否自动被删除
         */
        $channel->queue_declare(
            'hello',
            false,
            true,
            false,
            false
        );

        /**
         * 创建交换机(Exchange)
         * name: vckai_exchange// 交换机名称
         * type: direct        // 交换机类型，分别为direct/fanout/topic，参考另外文章的Exchange Type说明。
         * passive: false      // 如果设置true存在则返回OK，否则就报错。设置false存在返回OK，不存在则自动创建
         * durable: false      // 是否持久化，设置false是存放到内存中的，RabbitMQ重启后会丢失
         * auto_delete: false  // 是否自动删除，当最后一个消费者断开连接之后队列是否自动被删除
         */
//      $channel->exchange_declare(
//          'vckai_exchange',
//          AMQPExchangeType::DIRECT,
//          false,
//          false,
//          false
//      );

        /**
         * 创建AMQP消息类型
         * delivery_mode 消息是否持久化
         * AMQPMessage::DELIVERY_MODE_NON_PERSISTENT  不持久化
         * AMQPMessage::DELIVERY_MODE_PERSISTENT      持久化
         */
        $msg = new AMQPMessage('Hello World!');

        /**
         * 发送消息
         * msg: $msg                // AMQP消息内容
         * exchange: vckai_exchange // 交换机名称
         * queue: hello             // 队列名称
         */
        $channel->basic_publish($msg, '', 'hello');

        /**
         * 关闭
         */
        $channel->close();
        $connection->close();

        $this->line('done');
    }
}
