<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    //可操作字段
    protected $fillable = [
    	'title','description','image','on_sale',
    	'rating','sold_count','review_count','price'
    ];

    protected $casts = [
    	'on_sale' => 'boolean',	//数据库中无布尔值，需要在这里转换成布尔
    ];

    //构建联查功能（只要存在外键，肯定有此方法）
    public function skus(){
    	return $this->hasMany(ProductSku::class);
    }

    //创建一个虚拟的image_url字段，用于转换img字段内容为绝对路径
    public function getImageUrlAttribute(){
        //如果img的值本身就是完整的url，就直接返回url
        if(Str::startsWith($this->attributes['image'],['http://','https://'])){
            return $this->attributes['image'];
        }
        //将img改为完整路径的方法：
        return \Storage::disk('public')->url($this->attributes['image']);}
}
