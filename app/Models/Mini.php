<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mini extends Model
{
    use SoftDeletes;
    protected $guarded = [];
}
