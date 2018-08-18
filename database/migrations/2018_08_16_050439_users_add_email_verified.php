<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersAddEmailVerified extends Migration
{
    /**
     * Run the migrations.
     * up()是定义php artisan migrate，即迁移操作
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('email_verified')->default(false)->after('remember_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     * down()是定义php artisan migrate:rollback，即回滚操作
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('email_verified');
        });
    }
}
