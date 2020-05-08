<?php

namespace App\Http\Controllers;

use App\Models\DayEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DayEventController extends BaseController
{
    /**
     * @param Request $request
     * @return array
     */
    public function create(Request $request)
    {
        //事件类型
        // 11有妹妹 12有流星雨 13有骆驼 14有薛革 15有狐狸  16有然然
        // 21大头菜价早 22大头菜价午 23周日大头菜卖价
        // 32商店限定  33裁缝店好物推荐  34高价收购物品
        // 41有diy补课
        // 51今日最想要  52今日可以送
        // 61小动物要走 62小动物可接
        Validator::make($request->all(), [
            'event.*.type'        => 'required|integer',
            'event.*.item_id'     => 'integer',
            'event.*.sub_item_id' => 'integer',
            'event.*.price'       => 'integer|required_if:event.*.type,23',
            'event.*.am_price'    => 'integer|required_if:event.*.type,21',
            'event.*.pm_price'    => 'integer|required_if:event.*.type,22',
            'event.*.animal_id'   => 'integer|required_if:event.*.type,41,61,62',
            'event.*.status'      => 'integer',
        ], [
            'event.*.type.integer'         => 'type请填整型',
            'event.*.am_price.required_if' => '请填写上午大头菜卖价哦',
            'event.*.pm_price.required_if' => '请填写下午大头菜卖价哦',
            'event.*.price.required_if'    => '请填写大头菜买价哦',
        ])->validate();

        $events = $request->input('event', []);
        foreach ($events as &$event) {
            $event['user_id']    = $this->userId;
            $event['created_at'] = now();
        }

        DayEvent::query()->insert($events);
        return [];
    }

    public function index(Request $request)
    {
        $params = $request->all();
        $where  = [];
        if ($params['type'] ?? 0) {
            $where['type'] = $params['type'];
        }
        return DayEvent::query()->where($where)->paginate();
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
