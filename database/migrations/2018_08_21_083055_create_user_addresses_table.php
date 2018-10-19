<?php

//用于创建user_address_table
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAddressesTable extends Migration
{
    //定义生成的字段
    public function up()
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            //默认主键
            $table->increments('id');

            //user_id为外键（即在其他表中是主键），需要进一步设置外键的属性
            $table->unsignedInteger('user_id');
            //为user_id设置外键属性（与哪个表的哪个主键关联）；onDelete('cascade')表示users表中删除时，外键进行联级操作（还有onUpdate（'noaction'/'setnull'/'setdefault'))
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');


            $table->string('province');
            $table->string('city');
            $table->string('district');
            $table->string('address');
            $table->unsignedInteger('zip');
            $table->string('contact_name');
            $table->string('contact_phone');
            $table->dateTime('last_used_at')->nullable();
            $table->timestamps();
        });
    }

    //定义回滚操作
    public function down()
    {
        Schema::dropIfExists('user_addresses');
    }
}
