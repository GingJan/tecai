<?php

if(! function_exists('array_allow')) {
    /**
     * 过滤允许字段如：
     * 允许name=xxx&salary=xxx&time=xxx
     * 输入name=xxx&salary=xxx&age=xxx
     * 过滤后name=xxx&salary=xxx
     * @param array $allowed 允许的字段
     * @param array $haystack 输入的字段
     * @return array $res 返回过滤后，允许的字段
     */
    function array_allow($allowed, $haystack) {
        $allowed = array_flip($allowed);
        return array_intersect_key($haystack, $allowed);
    }
}

if(! function_exists('array_unallow')) {
    /**
     * @param array $unallowed 不允许的字段
     * @param array $haystack 输入的字段
     * @return array $res 返回清除不允许字段后的数组
     */
    function array_unallow($unallowed, $haystack) {
        $unallowed = array_flip($unallowed);
        return array_diff_key($haystack, $unallowed);
    }
}