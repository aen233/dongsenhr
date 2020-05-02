<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_relations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->default(0)->comment('用户id');
            $table->string('item_type')->default('')
                ->comment('Animal Diy Fossil Music Furniture SubFurniture DayEvent UserRelation');
            $table->bigInteger('item_id')->default(0)->comment('物品id');
            $table->string('item_name')->default('')->comment('物品名称');
            $table->string('item_picture')->default('')->comment('物品图片');
            $table->integer('item_price')->default(0)->comment('物品价格');
            $table->string('series')->default('')
                ->comment('系列名称 铸铁 木制 原木 积木 竹 水果 餐馆 妈妈 toy 古董');
            $table->string('character')->default('')
                ->comment('性格 1普通 2元气 3成熟 4大姐姐 5悠闲 6运动 7暴躁 8自恋');
            $table->integer('status')->default(0)
                ->comment('状态：0未拥有 1已拥有 2想要 3是已离去（小动物）4仅摸过（atm有） 5化石diy有多可分享');
            $table->integer('num')->default(0)->comment('数量（如果多，多几个）');
            $table->integer('check')->default(0)->comment('被送状态 1被选中');
            $table->bigInteger('object_user')->default(0)->comment('送与对象');
            $table->integer('object_type')->default(0)->comment('送与类型  1to 2from');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_relations');
    }
}
