<?php
namespace App\Supports;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class Http
{
    /**
     * get请求方法
     *
     * @param string $url
     * @param array $params
     * @param array $header
     * @return array
     */
    public static function get($url, $params, $header = [])
    {
        $options = [
            'query' => $params
        ];

        if ($header) {
            $options['headers'] = $header;
        }

        try {
            $response = (new Client())->get($url, $options);
            $data = [
                'success' => true,
                'data' => json_decode($response->getBody(), true),
            ];
            Log::info(
                'Http get request, url:' . $url . ',' .
                'options:' . jsonEncode($options) . ', ' .
                'data:' . jsonEncode($data)
            );
        } catch (GuzzleException $e) {
            $data = [
                'success' => false,
                'msg' => $e->getMessage(),
            ];
            Log::error(
                'Http get request error, params:' . jsonEncode($params) . ',' .
                'msg:' . $e->getMessage()
            );
        }

        return $data;
    }

    /**
     * post请求方法
     *
     * @param string $url
     * @param array $params
     * @param array $header
     * @return array
     */
    public static function post($url, array $params, $header = [])
    {
        $options = [
            'form_params' => $params
        ];

        if ($header) {
            $options['headers'] = $header;
        }

        try {
            $response = (new Client())->post($url, $options);
            $data = [
                'success' => true,
                'data' => json_decode($response->getBody(), true),
            ];
            Log::info(
                'Http post request, url:' . $url . ',' .
                'options:' . jsonEncode($options) . ', ' .
                'data:' . jsonEncode($data)
            );
        } catch (GuzzleException $e) {
            $data = [
                'success' => false,
                'msg' => $e->getMessage(),
            ];
            Log::error(
                'Http post request error, params:' . jsonEncode($params) . ',' .
                'msg:' . $e->getMessage()
            );
        }

        return $data;
    }
}
