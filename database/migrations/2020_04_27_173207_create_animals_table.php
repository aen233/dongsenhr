<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('')->comment('村民名称');
            $table->string('en_name')->default('')->comment('村民英文名称');
            $table->string('jap_name')->default('')->comment('村民日文名称');
            $table->string('picture')->default('')->comment('村民图片');
            $table->integer('amiibo_bag')->default(0)->comment('村民amiibo弹编号');
            $table->integer('amiibo_no')->default(0)->comment('村民amiibo编号');
            $table->date('birthday')->nullable()->comment('生日');
            $table->integer('constellation')->default(0)
                ->comment('星座 1白羊 2金牛 3双子 4巨蟹 5狮子 6处女 7天秤 8天蝎 9射手 10摩羯 11水瓶 12双鱼');
            $table->integer('sex')->default(0)->comment('性别 1男 2女');
            $table->string('character')->default('')
                ->comment('性格 1普通 2元气 3成熟 4大姐姐 5悠闲 6运动 7暴躁 8自恋');
            $table->integer('species')->default(0)->comment('物种分类');
            $table->string('pet_phrase')->default('')->comment('口头禅');
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
        Schema::dropIfExists('animals');
    }
}
