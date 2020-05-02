<?php

namespace App\Http\Controllers;

use App\Models\User;
use EasyWeChat\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends MiniController
{
    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function create(Request $request)
    {
        $config = config('mini.config');
        $app  = Factory::miniProgram($config);
        $code = $request->code ?? '';
        $result = $app->auth->session($code);
        // 授权返回结果错误
        if (empty($result['openid']) || empty($result['session_key'])) {
            Log::error('微信授权数据错误:' . var_export($result, true));
            abort(400);
        }
        // 如果不存在该用户，则写入
        $user = User::query()->where('open_id' ,$result['openid'])->first();

        if (empty($user)) {
            $user = User::query()->create(
                [
                    'open_id'       => $result['openid'],
                    'session_key' => $result['session_key']
                ]
            );
            Log::info('登录写入用户 openId: ' . $result['openid']);
        }

        return $user;
    }

    public function index(Request $request)
    {

    }

    public function update(Request $request)
    {

    }

    public function detail(Request $request)
    {

    }

    public function delete(Request $request)
    {

    }
}
