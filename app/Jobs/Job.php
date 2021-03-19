<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

abstract class Job implements ShouldQueue
{
    /*
    |--------------------------------------------------------------------------
    | Queueable Jobs
    |--------------------------------------------------------------------------
    |
    | This job base class provides a central location to place any logic that
    | is shared across all of your jobs. The trait included with the class
    | provides access to the "queueOn" and "delay" queue helper methods.
    |
    */

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * 任务失败的处理机制
     *
     * @param \Exception $e
     */
    public function failed(\Exception $e)
    {
        $className = static::class;
        Log::info(
            'Job execute exception, class:' . $className .
            ',message:' . $e->getTraceAsString()
        );

        //邮件通知
        $errorReceiver = config('mail.error_receiver');
        $env = App::environment() == 'production' ? '线上' : '测试';
        $messageContent = '【' . $env . '】Job执行异常，请及时处理！' . PHP_EOL . PHP_EOL .
            '异常类: ' . $className . PHP_EOL .
            '异常信息: ' . $e->getMessage() . PHP_EOL .
            '异常信息链路: ' . PHP_EOL . $e->getTraceAsString();

        Mail::raw($messageContent, function ($message) use ($errorReceiver) {
            $message->subject('Job执行异常！');
            $message->to($errorReceiver);
        });
    }
}
