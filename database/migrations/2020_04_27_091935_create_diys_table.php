<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diys', function (Blueprint $table) {
            $table->id();
            $table->integer('type')->default(0)
                ->comment('类别：1工具 2家具 3小物件 4壁挂物 5墙壁地板地垫 6装备 7其他 8季节手册');
            $table->string('series')->default('')
                ->comment('系列 铸铁 木制 原木 积木 竹 水果');
            $table->string('activity')->default('')
                ->comment('活动：樱花  复活蛋');
            $table->string('name')->default('')->comment('名称');
            $table->string('en_name')->default('')->comment('英文名称');
            $table->string('jap_name')->default('')->comment('日文名称');
            $table->string('picture')->default('')->comment('图片');
            $table->integer('price')->default(0)->comment('价格');
            $table->string('character')->default('')
                ->comment('相关性格 性格 1普通 2元气 3成熟 4大姐姐 5悠闲 6运动 7暴躁 8自恋');
            $table->string('unlock_condition')->default('')->comment('解锁条件');
            $table->integer('size_length')->default(0)->comment('占地大小 长');
            $table->integer('size_width')->default(0)->comment('占地大小 宽');
            $table->bigInteger('helper_id')->default(0)->comment('填信息的小伙伴');

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
        Schema::dropIfExists('diys');
    }
}
