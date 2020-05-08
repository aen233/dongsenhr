<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('name')->default('')->comment('昵称');
            $table->Integer('island_no')->default(0)->comment('岛编号');
            $table->string('island_name')->default('')->comment('岛名');
            $table->string('island_location')->default('')->comment('南北半球');
            $table->string('fruit')->default('')->comment('水果');
            $table->date('birthday')->nullable()->comment('生日');
            $table->date('island_date')->nullable()->comment('上岛日期');
            $table->Integer('is_open')->default(0)->comment('是否打开 0否 1好友门 2最佳好友门 3好友密码门 4任意密码门');
            $table->string('island_password', 10)->default('')->comment('上岛密码');

            $table->string('union_id', 80)->default('')->index()->comment('用户统一id');
            $table->string('openid', 80)->default('')->index()->comment('用户识别id');
            $table->string('session_key', 80)->default('')->comment('微信登陆session_key');

            $table->string('avatarUrl')->default('')->comment('微信头像');
            $table->string('city')->default('')->comment('微信城市');
            $table->string('country')->default('')->comment('微信国家');
            $table->string('gender')->default('')->comment('微信性别');
            $table->string('language')->default('')->comment('微信语言');
            $table->string('nickName')->default('')->comment('微信昵称');
            $table->string('province')->default('')->comment('微信省份');

            $table->bigInteger('sw_id')->default(0)->index()->comment('任天堂id');
            $table->string('sw_name')->default('')->index()->comment('任天堂昵称');


            $table->string('email')->default('')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->default('');
            $table->Integer('is_admin')->default(0)->comment('是否是管理员  1是 0否');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
