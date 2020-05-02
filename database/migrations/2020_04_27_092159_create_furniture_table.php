<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFurnitureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('furniture', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('')->comment('商品名称');
            $table->string('en_name')->default('')->comment('英文名称');
            $table->string('jap_name')->default('')->comment('日文名称');
            $table->integer('big_category')->default(0)->comment('大分类名称 0特别商品 1家具 2服饰物品 3壁纸和地板等');
            $table->integer('category')->default(0)
                ->comment('小分类名称 1活动 2海报 11家具 12小物件 13壁挂物 21上装 22下装 23套装 24头戴物 25饰品 26袜子 27鞋子 28包包 29伞 31壁纸 32地板 33地垫 34化石 35音乐');
            $table->string('picture')->default('')->comment('商品图片');
            $table->string('series')->default('')->comment('系列 铸铁 木制 原木 积木 竹 水果 餐馆 妈妈 toy 古董');
            $table->integer('multi')->default(0)->comment('是否有多规格 1是0否');
            $table->integer('price')->default(0)->comment('价格');
            $table->integer('sold_price')->default(0)->comment('卖出价格');
            $table->integer('non_sale')->default(0)->comment('是否是非卖品 1是0否');
            $table->integer('modifiable')->default(0)->comment('是否可改造 1是0否');
            $table->integer('from')->default(0)->comment('来源  0atm 1diy 2骆驼 3吕游 4狐狸 5妈妈');
            $table->integer('is_material')->default(0)->comment('是否是材料 1是0否');
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
        Schema::dropIfExists('furniture');
    }
}
