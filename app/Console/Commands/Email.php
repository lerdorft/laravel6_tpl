<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;

class Email extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email';

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
//        Config::set('mail.from', array('address' => '654321@163.com', 'name' => '发件人'));
//        Config::set('mail.username', '发件人');
//        Config::set('mail.password', '33133');
//
//       $rt = filter_var('chensonghua@scrmtech.com', FILTER_VALIDATE_EMAIL);

        $env = App::environment() == 'production' ? '线上' : '测试';
        $messageContent = '【' . $env . '】Job执行异常，请及时处理！' . PHP_EOL . PHP_EOL .
            '异常类: ' . PHP_EOL .
            '异常信息: ' . PHP_EOL .
            '异常信息链路: ' . PHP_EOL;

        Mail::raw($messageContent, function ($message) {
            $message->subject('Job执行异常！');
            $message->to(['chensonghua@scrmtech.com']);
        });

        $this->line('hello world');
    }
}
