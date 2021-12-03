<?php

namespace App\Repositories;

class DemoRepository extends BaseRepository
{
    /**
     * demo test
     *
     * @param int $id
     * @return string
     */
    public function test($id)
    {
        //转换
        $id = jsonEncode(['id' => $id]);

        return $this->response(['receive_id' => $id]);
    }

    /**
     * 发送邮件
     *
     * @param $params
     * @return mixed
     */
    public function sendEmail($params)
    {
        return $this->response($params);
    }
}
