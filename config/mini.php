<?php

return [
    'config' => [
        'app_id'        => 'wx9a5752574512d5bc',
        'secret'        => '3a81dc03d2c34fa5c8fb988ddaa646ed',

        // 下面为可选项
        // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
        'response_type' => 'array',

        'log' => [
            'level' => 'debug',
            'file'  => storage_path('wechat.log')
        ],
    ]

];
