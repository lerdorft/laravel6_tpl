<?php

namespace App\Repositories;

class CommonRepository extends BaseRepository
{
    /**
     * json decode
     *
     * @param $data
     * @param $isPrint
     * @return mixed
     */
    public function jsonDecode($data, $isPrint)
    {
        $rt = [];
        if ($data) {
            $rt = json_decode($data, true);
        }

        if ($isPrint) {
            print_r($rt);exit;
        }

        return $this->response($rt);
    }

    /**
     * unserialize
     *
     * @param $data
     * @param $isPrint
     * @return mixed
     */
    public function unserialize($data, $isPrint)
    {
        $rt = [];
        if ($data) {
            $rt = unserialize($data);
        }

        if ($isPrint) {
            print_r($rt);exit;
        }

        return $this->response($rt);
    }
}
