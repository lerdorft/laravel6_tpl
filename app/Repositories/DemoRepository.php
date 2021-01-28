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
}
