<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMusicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('musics', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('')->comment('音乐名称');
            $table->string('en_name')->default('')->comment('英文名称');
            $table->string('jap_name')->default('')->comment('日文名称');
            $table->string('picture')->default('')->comment('音乐封面');
            $table->integer('price')->default(0)->comment('价格');
            $table->integer('non_sale')->default(0)->comment('是否是非卖品 1是0否');
            $table->integer('music_no')->default(0)->comment('标号');
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
        Schema::dropIfExists('musics');
    }
}
