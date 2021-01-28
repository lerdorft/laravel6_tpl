<?php
/**
 * 全局公共方法
 *
 * composer dump-autoload -o
 */

if (!function_exists('jsonEncode')) {
    /**
     * 生成json格式数据
     *
     * @author tianxiaocheng
     * @param array|object $data
     * @return string|false
     */
    function jsonEncode($data)
    {
        return json_encode(
            $data,
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );

        //JSON_UNESCAPED_LINE_TERMINATORS
    }
}
