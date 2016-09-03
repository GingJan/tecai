<?php

namespace tecai\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class RoleValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => ['required', 'unique','max:255'],
            'display_name' => ['sometimes','required','max:255'],
            'description' => ['sometimes','max:255'],
            'created_at' => ['required'],
            'updated_at' => ['required'],
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'sometimes|unique:roles,name',//somtimes和required一起使用？
//            'name' => ['sometimes','required','unique:roles,name']//somtimes和required一起使用？
            'display_name' => ['sometimes','required','max:255'],
            'description' => ['sometimes','max:255'],
            'updated_at' => ['required'],
        ],
   ];

    protected $messages = [//自定义错误提示消息
        'required' => 'The :attribute field is required..(custom)',
        'unique' => 'The :attribute has existed...(custom)',
        'max' => 'Ooops! The :attribute too long',
    ];

    protected $attributes = [//自定义属性（属性与字段映射）
        'db_field' => 'your-custom-attr(client can see)',
    ];
}
