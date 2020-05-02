<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFossilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fossils', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('')->comment('化石名称');
            $table->string('en_name')->default('')->comment('英文名称');
            $table->string('jap_name')->default('')->comment('日文名称');
            $table->string('picture')->default('')->comment('化石图片');
            $table->integer('price')->default(0)->comment('价格');
            $table->string('location')->default('')->comment('化石位置  第几个房间');
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
        Schema::dropIfExists('fossils');
    }
}
