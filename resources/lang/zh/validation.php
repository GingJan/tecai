<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attribute 必须为yes，no，1，true.',
    'active_url'           => ':attribute 不是一个合法的url.',
    'after'                => ':attribute 日期必须在 :date 日期之后.',
    'alpha'                => ':attribute 只能包含有字母.',
    'alpha_dash'           => ':attribute 只能包含有字母，数字，下划线_，破折号-.',
    'alpha_num'            => ':attribute 只能包含字母和数字.',
    'array'                => ':attribute 必须是数组.',
    'before'               => ':attribute 日期必选在 :date. 日期之前',
    'between'              => [
        'numeric' => ':attribute 必须在 :min 到 :max 之间.',
        'file'    => ':attribute 大小必须在 :min 到 :max KB之间.',
        'string'  => ':attribute 长度必须为 :min 到 :max 字符.',
        'array'   => ':attribute 只能有 :min 到 :max 个.',
    ],
    'boolean'              => ':attribute 的值只能为true 或 false.',
    'confirmed'            => ':attribute 字段的值与 :attribute _confirmation的值不一致.',
    'date'                 => ':attribute 不是有效的日期.',
    'date_format'          => ':attribute 的格式与 :format 的格式不一致.',
    'different'            => ':attribute 和 :other 的必须不相同.',
    'digits'               => ':attribute 必须为数字且只能为 :digits 个数字.',
    'digits_between'       => ':attribute 数字个数要在 :min 到 :max 个之间.',
    'email'                => ':attribute 不是一个合法的邮箱格式.',
    'exists'               => ':attribute 的值不存在.',
    'filled'               => ':attribute 的值不能为空.',
    'image'                => ':attribute 必须是一张图片.',
    'in'                   => ':attribute 的值不在指定的列表内.',
    'integer'              => ':attribute 必须是整型.',
    'ip'                   => ':attribute 必须是有效的IP地址.',
    'json'                 => ':attribute 不是一个合法的JSON字符串.',
    'max'                  => [
        'numeric' => ':attribute 的值不可大于 :max.',
        'file'    => ':attribute 文件大小不可大于 :max KB.',
        'string'  => ':attribute 字符串长度不可大于 :max 个字符.',
        'array'   => ':attribute 不可超过 :max 项.',
    ],
    'mimes'                => ':attribute 文件的MIME类型必须是: :values.',
    'min'                  => [
        'numeric' => 'The :attribute must be at least :min.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => 'The :attribute must be at least :min characters.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'numeric'              => 'The :attribute must be a number.',
    'regex'                => 'The :attribute format is invalid.',
    'required'             => 'The :attribute field is required.',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => ':attribute 已被使用.',
    'url'                  => 'The :attribute format is invalid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
