<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDayEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $date = date("Y-m-d");
        Schema::create('day_events', function (Blueprint $table) use($date) {
            // 事件类型 11有妹妹 12有流星雨 13有骆驼 14有薛革 15有狐狸  16有然然
            // 21大头菜价早 22大头菜价午 23周日大头菜卖价
            // 32商店限定  33裁缝店好物推荐  34kk音乐 35高价收购物品
            // 41有diy补课
            // 51今日最想要  52今日可以送
            // 61小动物要走 62小动物可接
            $table->id();
            $table->date('date')->default($date)->comment('当前日期');
            $table->bigInteger('user_id')->default(0)->comment('用户ID');
            $table->integer('type')->default(0)
                ->comment('事件类型 11有妹妹 12有流星雨 13有骆驼 14有薛革 15有狐狸  16有然然 21大头菜价早 22大头菜价午 23周日大头菜卖价 32商店限定  33裁缝店好物推荐  34kk音乐  35高价收购物品  41有diy补课 51今日最想要  52今日可以送 61小动物要走 62小动物可接');
            $table->bigInteger('item_id')->default(0)->comment('diy id，物品id');
            $table->string('item_name')->default('')->comment('diy名称，物品名称');
            $table->bigInteger('sub_item_id')->default(0)->comment('物品规格id');
            $table->string('sub_item_name')->default('')->comment('物品规格名称');
            $table->string('picture')->default('')->comment('上传图片');
            $table->integer('price')->default(0)->comment('物品价格、大头菜价格');
            $table->integer('am_price')->default(0)->comment('大头菜价早');
            $table->integer('pm_price')->default(0)->comment('大头菜价午');
            $table->integer('animal_id')->default(0)->comment('村民id');
            $table->integer('status')->default(0)->comment('是否已结束 1是0否');
            $table->string('remark')->default('')->comment('备注');
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
        Schema::dropIfExists('day_events');
    }
}
