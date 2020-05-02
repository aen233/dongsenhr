<?php

namespace App\Models;

class UserRelation extends Mini
{
    //
    public function scopeRelationByUserId($query, $userId, $type = '', $status = 0)
    {
        return $query->where('user_id', $userId)
            ->when($type, function ($query, $type) {
                return $query->where('item_type', $type);
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            });
    }

    public function scopeRelationByItemAndUser($query, $itemId, $userId, $type, $status = 0)
    {
        return $query->where('user_id', $userId)
            ->where('item_id', $itemId)
            ->where('item_type', $type)
            ->where('status', $status);
    }

    public function scopeRelationByItemId($query, $itemId, $type, $status = 0)
    {
        return $query->where('item_id', $itemId)
            ->where('item_type', $type)
            ->where('status', $status);
    }
}
