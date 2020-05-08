<?php

namespace App\Http\Controllers;

use App\Exceptions\Error;
use App\Models\User;
use EasyWeChat\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class LoginController extends BaseController
{
    /**
     * 非必须登录
     *
     * @var bool
     */
    protected $requireLogin = false;

    /**
     * @param Request $request
     * @return array
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws Error
     */
    public function index(Request $request)
    {
        $config = config('mini.config');
        $app    = Factory::miniProgram($config);
        $code   = $request->code ?? '';
        $result = $app->auth->session($code);
        // 授权返回结果错误
        if (empty($result['openid']) || empty($result['session_key'])) {
            Log::error('微信授权数据错误:' . var_export($result, true));
            throw new Error(1000004, '微信授权数据错误');
        }
        // 如果不存在该用户，则写入
        $user = User::query()->where('openid', $result['openid'])->first();

        if (empty($user)) {
            $user = User::query()->create($result);
            Log::info('登录写入用户 openId: ' . $result['openid']);
        }
        $token = Crypt::encrypt(json_encode($result));

        return [
            'user'  => $user,
            'token' => $token
        ];
    }
}
