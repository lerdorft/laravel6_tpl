<?php
namespace App\Supports;

use Symfony\Component\HttpFoundation\Response as FoundationResponse;
use App\Common\ErrCode;

trait ApiResponse
{
    /**
     * @var int
     */
    protected $httpCode = FoundationResponse::HTTP_OK;

    /**
     * @var int
     */
    protected $businessCode = 0;

    /**
     * @var string
     */
    protected $businessMsg = '';

    /**
     * @param int $code
     * @return $this
     */
    public function setCode($code)
    {
        $this->businessCode = $code;

        if (isset(ErrCode::ERR_MSG[$code])) {
            $this->businessMsg = ErrCode::ERR_MSG[$code];
        }

        return $this;
    }

    /**
     * 返回正常业务数据
     *
     * @param mixed $data
     * @param string $message
     * @return mixed
     */
    public function response($data = [], $message = '')
    {
        $common = [
            'code' => $this->businessCode,
            'msg' => $message ? $message : $this->businessMsg,
        ];

        $data = array_merge($common, ['data' => $data]);

        return response()->json($data, $this->httpCode);
    }

    /**
     * 返回提示信息
     *
     * @param string $message
     * @return mixed
     */
    public function message($message = null)
    {
        $common = [
            'code' => $this->businessCode,
            'msg' => is_null($message) ? $this->businessMsg : $message,
            'data' => []
        ];

        return response()->json($common, $this->httpCode);
    }
}
