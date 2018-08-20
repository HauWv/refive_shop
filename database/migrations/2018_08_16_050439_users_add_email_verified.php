<?php

//这个文件是用php artisan make:migration users_add_email_verified --table=users生成的
//作用是在users表里生成users_add_email_verified字段

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersAddEmailVerified extends Migration
{
    /**
     * up()是定义php artisan migrate，即迁移操作
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //定义字段属性、默认值、位置
            $table->boolean('email_verified')->default(false)->after('remember_token');
        });
    }

    /**
     * down()是定义php artisan migrate:rollback，即回滚操作
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('email_verified');
        });
    }
}
