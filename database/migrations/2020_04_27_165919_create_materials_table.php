<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('material_name')->default('')->comment('材料名称');
            $table->string('picture')->default('')->comment('商品图片');
            $table->integer('price')->default(0)->comment('价格');
            $table->string('series')->default('')
                ->comment('系列 铸铁 木制 原木 积木 竹 水果');
            $table->string('from')->default('')->comment('获取途径');
            $table->string('remark')->default('')->comment('备注');
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
        Schema::dropIfExists('materials');
    }
}
