<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'mysql';

    /**
     * @var string 表名
     */
    protected $table;

    /**
     * @var bool 插入更新时间是否自动更新
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [];
}
