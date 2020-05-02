<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubFurnitureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_furniture', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ori_id')->default(0)->comment('家具id');
            $table->integer('ori_type')->default(0)->comment('类型  1商品多规格 2diy多改造');
            $table->string('name')->default('')->comment('规格名称');
            $table->string('picture')->default('')->comment('商品图片');
            $table->integer('price')->default(0)->comment('价格');
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
        Schema::dropIfExists('sub_furniture');
    }
}
