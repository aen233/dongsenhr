<?php

namespace App\Http\Controllers;

use App\Exceptions\Error;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class BaseController extends Controller
{
    /**
     * 是否必须登录
     *
     * @var bool
     */
    protected $requireLogin = true;

    /**
     * 当前登录的用户ID
     *
     * @var null
     */
    protected $userId = null;

    /**
     * 当前登录的用户openId
     *
     * @var null
     */
    protected $openId = null;

    /**
     * sessionKey
     *
     * @var null
     */
    protected $sessionKey = null;

    /**
     * 当前登录的用户信息
     *
     * @var null
     */
    protected $user = null;

    /**
     * BaseController constructor.
     *
     * @throws \Exception
     */
    public function __construct()
    {
        // 非必须登录，该属性会绕过身份鉴权，请谨慎
        if (!$this->requireLogin) {
            return true;
        }

        $token = request()->header('Token');

        if (empty($token)) {
            Log::error('ERROR:无效的用户身份 Token 丢失，Token:' . $token);
            throw new Error(200001, '无效的用户身份');
        }

        try {
            $token = Crypt::decrypt($token);
            $token = json_decode($token, true);
        } catch (\Exception $exception) {
            Log::error('token:' . var_export($token, true));
            Log::error('ERROR:110003:token解密错误');
            throw new Error(110003, 'token解密错误');
        }

        $this->openId     = $token['openId'];
        $this->sessionKey = $token['sessionKey'];

        Log::debug('token:' . var_export($token, true));


        Log::info('open_id:' . $this->openId);
        $user = User::query()->where('open_id', $this->openId)->first();

        // 如果用户不存在，先写入，再查询，避免清数据导致的身份失效
        if (empty($user)) {
            $user = User::query()->create([
                    'open_id'     => $this->openId,
                    'session_key' => $this->sessionKey
                ]);
        }

        $this->user   = $user;
        $this->userId = $user['id'];
        request()->attributes->add([
            'user'       => $this->user,
            'userId'     => $this->userId,
            'openId'     => $this->openId,
            'sessionKey' => $this->sessionKey
        ]);
        return true;
    }
}
