<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
