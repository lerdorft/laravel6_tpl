<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitmqConsumer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:consume';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'rabbit mq consumer';

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
        //建立连接
        $connection = new AMQPStreamConnection(
            '121.5.22.144',
            5672,
            'ems',
            '123',
            '/ems'
        );

        //创建通道
        $channel = $connection->channel();

        // 设置消费者（Consumer）客户端同时只处理一条队列
        // 这样是告诉RabbitMQ，再同一时刻，不要发送超过1条消息给一个消费者（Consumer），
        // 直到它已经处理了上一条消息并且作出了响应。这样，RabbitMQ就会把消息分发给下一个空闲的消费者（Consumer）。
        $channel->basic_qos(
            0,
            1,
            false
        );

        // 同样是创建路由和队列，以及绑定路由队列，注意要跟publisher的一致
        // 这里其实可以不用，但是为了防止队列没有被创建所以做的容错处理
        $channel->queue_declare(
            'hello',
            false,
            true,
            false,
            false
        );

//      $channel->exchange_declare(
//          'vckai_exchange',
//          AMQPExchangeType::DIRECT,
//          false,
//          false,
//          false
//      );

//      $channel->queue_bind(
//          'hello',
//          'vckai_exchange'
//      );

        // 消息处理的逻辑回调函数
        $callback = function ($msg) {
            echo " [x] Received ", $msg->body, "\n";

            // 手动确认ack，确保消息已经处理
//          $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
//          if ($msg->body === 'quit') {
//              $msg->delivery_info['channel']->basic_cancel($msg->delivery_info['consumer_tag']);
//          }
        };

        /**
         * queue: hello               // 被消费的队列名称
         * consumer_tag: consumer_tag // 消费者客户端身份标识，用于区分多个客户端
         * no_local: false            // 这个功能属于AMQP的标准，但是RabbitMQ并没有做实现
         * no_ack: true               // 收到消息后，是否不需要回复确认即被认为被消费
         * exclusive: false           // 是否排他，即这个队列只能由一个消费者消费。适用于任务不允许进行并发处理的情况下
         * nowait: false              // 不返回执行结果，但是如果排他开启的话，则必须需要等待结果的，如果两个一起开就会报错
         * callback: $callback        // 回调逻辑处理函数
         */
        $channel->basic_consume(
            'hello',
            '',
            false,
            true,
            false,
            false,
            $callback
        );

        // 程序运行完成后关闭链接
        $shutdown = function ($channel, $connection) {
            $channel->close();
            $connection->close();
        };

        register_shutdown_function($shutdown, $channel, $connection);

        // 阻塞队列监听事件
        while (count($channel->callbacks)) {
            $channel->wait();
        }
    }
}
