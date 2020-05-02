<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiyMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diy_materials', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('diy_id')->default(0)->comment('diy id');
            $table->bigInteger('material_id')->default(0)->comment('材料id');
            $table->string('material_name')->default('')->comment('材料名称');
            $table->integer('number')->default(0)->comment('材料数量');
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
        Schema::dropIfExists('diy_materials');
    }
}
