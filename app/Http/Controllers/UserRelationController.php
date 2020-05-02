<?php

namespace App\Http\Controllers;

use App\Models\UserRelation;
use Illuminate\Http\Request;

class UserRelationController extends MiniController
{
    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function create(Request $request)
    {
        $params = $request->all();

        $class = "App\Models\\" . $params['item_type'];

        $item = $class::query()->find($params['item_id']);

        if(is_null($item)){
            abort(400, '您标记的物品不存在哦');
        }

        $params['user_id'] = $this->userId;
        $params['item_name'] = $item->name??'';
        $params['item_price'] = $item->price??'';
        $params['item_picture'] = $item->picture??'';
        $params['series'] = $item->series??'';
        $params['character'] = $item->character??'';

        $userRelation = UserRelation::query()->create($params);
        return $userRelation;
    }

    public function index(Request $request)
    {
        $params = $request->all();
        $where  = [
            'user_id'=>$this->userId
        ];
        if ($params['item_type'] ?? '') {
            $where['item_type'] = $params['item_type'];
        }
        if ($params['status'] ?? 0) {
            $where['status'] = $params['status'];
        }
        $userRelations = UserRelation::query()
            ->where($where)
            ->orderBy('item_type','asc')
            ->latest()
            ->paginate();
        return $userRelations;
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        $params = $request->all();

        $userRelation = UserRelation::query()->where('id', $params['id'])->update($params);
        return $userRelation;
    }

    public function detail(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);
        $params       = $request->all();
        $userRelation = UserRelation::query()->find($params['id']);
        return $userRelation;
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);
        $params = $request->all();

        $userRelation = UserRelation::query()->find($params['id']);
        $userRelation->delete();
        return [];
    }
}
