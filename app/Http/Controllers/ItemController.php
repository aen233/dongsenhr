<?php

namespace App\Http\Controllers;

use App\Models\UserRelation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ItemController extends MiniController
{
    protected $itemType = '';
    protected $model = '';

    public function __construct()
    {
        $this->itemType = ucfirst(Str::camel(request()->item_type));
        $this->model    = "App\Models\\" . $this->itemType;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function create(Request $request)
    {
        $params = $request->all();

        $params['helper_id'] = $this->userId;

        $item = $this->model::query()->create($params);
        return $item;
    }

    public function index(Request $request)
    {
        // animal  按名称、状态、星座、生日、性格、物种搜索
        // 化石、音乐  按名称、状态搜索
        // diy  按名称、状态、类别、系列、材料、相关性格、占地大小搜索
        // 家具  按名称、状态、大类别、小类别、系列、来源、是否是材料、占地大小搜索
        $params = $request->only(['name', 'status']);
        $where = [];
        switch ($this->itemType) {
            case 'Animal':
                 $where = $request->only(['character', 'species', 'amiibo_bag', 'amiibo_no']);
                break;
            case 'Diy':
                // todo 需要单独处理按照材料搜索 material_id
                $where = $request->only(['type', 'series','character']);
                break;
            case 'Furniture':
                $params = $request->only(['big_category', 'category', 'series', 'from', 'is_material']);
                break;
            default:
                $params = $request->all();
        }

        if ($params['name'] ?? '') {
            $where[] = ['name', 'like', '%' . $params['name'] . '%'];
        }

        // 状态：全部 0未拥有 1已拥有 2想要 3是已离去（小动物）4仅摸过（atm有） 5有多可分享（化石diy）
        $userhasItemIds   = UserRelation::query()->relationByUserId($this->userId, $this->itemType, 1)->pluck('item_id')->all();
        $userWantsItemIds = UserRelation::query()->relationByUserId($this->userId, $this->itemType, 2)->pluck('item_id')->all();
        if ('Animal' == $this->itemType) {
            $usedLiveItemIds = UserRelation::query()->relationByUserId($this->userId, $this->itemType, 3)->pluck('item_id')->all();
        }
        if (!in_array($this->itemType, ['Animal', 'Diy'])) {
            $userMosItemIds = UserRelation::query()->relationByUserId($this->userId, $this->itemType, 4)->pluck('item_id')->all();
        }
        if (in_array($this->itemType, ['Diy', 'Fossil'])) {
            $canShareItemIds = UserRelation::query()->relationByUserId($this->userId, $this->itemType, 5)->pluck('item_id')->all();
        }


        $searchItemIds = [];
        if ($params['status'] ?? 0) {
            // 状态：全部 0未拥有 1已拥有 2想要 3是已离去（小动物）4仅摸过（atm有） 5有多可分享（化石diy） 6我标记过的 7我没标记过的
            switch ($params['status']) {
                case 1:
                    $searchItemIds = $userhasItemIds;
                    break;
                case 2:
                    $searchItemIds = $userWantsItemIds;
                    break;
                case 3:
                    $searchItemIds = $usedLiveItemIds ?? [];
                    break;
                case 4:
                    $searchItemIds = $userMosItemIds ?? [];
                    break;
                case 5:
                    $searchItemIds = $canShareItemIds ?? [];
                    break;
                case 6:
                case 7:
                    $searchItemIds = UserRelation::query()->relationByUserId($this->userId, $this->itemType)->pluck('item_id')->all();
                    break;
                default:
                    $searchItemIds = [];
            }
        }
        // 状态：全部 0未拥有 1已拥有 2想要 3是已离去（小动物）4仅摸过（atm有） 5有多可分享（化石diy） 6我标记过的 7我没标记过的
        $list = $this->model::query()
            ->where($where)
            ->when($params['status'] ?? 0, function ($query) use ($params, $searchItemIds) {
                if (7 <> $params['status']) {
                    return $query->whereIn('id', $searchItemIds);
                } else {
                    return $query->whereNotIn('id', $searchItemIds);
                }
            })
            ->paginate();

        foreach ($list as &$item) {
            $item['user_has']   = in_array($item->id, $userhasItemIds) ? 1 : 0;
            $item['user_wants'] = in_array($item->id, $userWantsItemIds) ? 1 : 0;
            if ('Animal' == $this->itemType) {
                $item['used_live'] = in_array($item->id, $usedLiveItemIds ?? []) ? 1 : 0;
            }
            if (!in_array($this->itemType, ['Animal', 'Diy'])) {
                $item['user_mos'] = in_array($item->id, $userMosItemIds ?? []) ? 1 : 0;
            }
            if (in_array($this->itemType, ['Diy', 'Fossil'])) {
                $item['can_share'] = in_array($item->id, $canShareItemIds ?? []) ? 1 : 0;
            }
        }

        return $list;
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        $params = $request->all();

        $params['helper_id'] = $this->userId;

        $item = $this->model::query()->where('id', $params['id'])->update($params);
        return $item;
    }

    public function detail(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);
        $params = $request->all();
        $item   = $this->model::query()->find($params['id']);

        // 状态：0未拥有 1已拥有 2想要 3是已离去（小动物）4仅摸过（atm有） 5化石diy有多可分享
        $item['user_has']   = UserRelation::query()->relationByItemAndUser($this->userId, $item->id, $this->itemType, 1)->count();
        $item['user_wants'] = UserRelation::query()->relationByItemAndUser($this->userId, $item->id, $this->itemType, 2)->count();
        if ('Animal' == $this->itemType) {
            $item['used_live'] = UserRelation::query()->relationByItemAndUser($this->userId, $item->id, $this->itemType, 3)->count();
        }
        if (!in_array($this->itemType, ['Animal', 'Diy'])) {
            $item['user_mos'] = UserRelation::query()->relationByItemAndUser($this->userId, $item->id, $this->itemType, 4)->count();
        }
        if (in_array($this->itemType, ['Diy', 'Fossil'])) {
            $item['can_share'] = UserRelation::query()->relationByItemAndUser($this->userId, $item->id, $this->itemType, 5)->count();
        }


        $item['who_has']   = $this->findUsersByRelation($item->id, $this->itemType, 1);
        $item['who_wants'] = $this->findUsersByRelation($item->id, $this->itemType, 2);
        if ('Animal' == $this->itemType) {
            $item['who_used_has'] = $this->findUsersByRelation($item->id, $this->itemType, 3);
        }
        if (!in_array($this->itemType, ['Animal', 'Diy'])) {
            $item['who_mos'] = $this->findUsersByRelation($item->id, $this->itemType, 4);
        }
        if (in_array($this->itemType, ['Diy', 'Fossil'])) {
            $item['who_can_share'] = $this->findUsersByRelation($item->id, $this->itemType, 5);
        }


        return $item;
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);
        $params              = $request->all();
        $params['helper_id'] = $this->userId;

        $item = $this->model::query()->find($params['id']);
        $item->delete();
        return [];
    }

    protected function findUsersByRelation($itemId, $itemType, $status)
    {
        $list = UserRelation::query()->relationByItemId($itemId, $itemType, $status) - with('user')->take(10);
        return $list;
    }
}
