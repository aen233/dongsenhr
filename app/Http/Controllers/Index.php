<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use EasyWeChat\Factory;

class Index extends BaseController
{
    /**
     * @param Request $request
     * @return array
     * @throws \EasyWeChat\Kernel\Exceptions\DecryptException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function __invoke(Request $request)
    {
        $config = [
            'app_id'        => 'wx9a5752574512d5bc',
            'secret'        => '3a81dc03d2c34fa5c8fb988ddaa646ed',

            // 下面为可选项
            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',

            'log' => [
                'level' => 'debug',
                'file'  => __DIR__ . '/wechat.log',
            ],
        ];

        $app  = Factory::miniProgram($config);
        $code = $request->code ?? '';

        $data = $app->auth->session($code);

        $session=$data['session_key'];
        $iv = 'N0rr+8U/1lZjPMpbWyJozQ==';
        $encryptedData = "2hdB2FxhgFPN6eDeSwCl7GJVNIg1IVDGn5iCflkfUqoxLBSRC++Ckvzw61MrCWKTfp1PUq1SH2azK31ttDxg6DZgM3ta1gG8ut36vLsDp8zeakXK3R25K1fDhyZm7tQIFlEGFTWNwSUi72rYEVF0ezc1XFIjspx2pb+j2isKV5313WrY+IXR4CoysEvpKvJ3WRux44c3Pb9m48lrVx2kwRhzXMrw6+a36vdqO0uW6cySgkYzuPYklLJc/hdKUGU14A1YCvGxHnUCdYxOBjjkccpGG0VmU5nV54MNyCBZvu4pqlCbz0J7nFVVtWVneZ0OimoK7+HVMBwK9cAL92XIfIMVlQ941rnPj0DSSbO5osSZx3DV3M2dlrWqm+N13LBxp/4Ux4uZ7HcPwJVKYDqN33ETC9fpzcDghouFvvw9cPxc5fXQhB2RO3iru+iNMp9maxVHh/3/aL4Jnp5srI1YxCtXuIjZOgIiCD6BoVDJ5PM=";
        $decryptedData = $app->encryptor->decryptData($session, $iv, $encryptedData);
        return $decryptedData;

    }
}
