<?php

namespace App\Http\Controllers\Demo;

use App\Http\Controllers\Controller;
use App\Repositories\CommonRepository;
use App\Http\Requests\BaseRequest;

class CommonController extends Controller
{
    /**
     * @var CommonRepository
     */
    protected $commonRep;

    /**
     * CommonController constructor.
     *
     * @param CommonRepository $commonRep
     */
    public function __construct(CommonRepository $commonRep)
    {
        $this->commonRep = $commonRep;
    }

    /**
     * json decode
     *
     * @param BaseRequest $request
     * @return string
     */
    public function jsonDecode(BaseRequest $request)
    {
        return $this->commonRep->jsonDecode($request->input('data'), $request->input('is_print', 0));
    }

    /**
     * string unserialize
     *
     * @param BaseRequest $request
     * @return string
     */
    public function unserialize(BaseRequest $request)
    {
        return $this->commonRep->unserialize($request->input('data'), $request->input('is_print', 0));
    }
}
