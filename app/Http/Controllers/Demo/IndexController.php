<?php

namespace App\Http\Controllers\Demo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Demo\IndexRequest;
use App\Http\Requests\Demo\EmailSendRequest;
use App\Repositories\DemoRepository;

class IndexController extends Controller
{
    /**
     * @var DemoRepository
     */
    protected $demoRep;

    /**
     * IndexController constructor.
     *
     * @param DemoRepository $demoRep
     */
    public function __construct(DemoRepository $demoRep)
    {
        $this->demoRep = $demoRep;
    }

    /**
     * demo
     *
     * @param IndexRequest $request
     * @return string
     */
    public function index(IndexRequest $request)
    {
        return $this->demoRep->test($request->get('id', 0));
    }

    /**
     * 发送邮件
     *
     * @param EmailSendRequest $request
     * @return string
     */
    public function emailSend(EmailSendRequest $request)
    {
        return $this->demoRep->sendEmail($request->post());
    }
}
