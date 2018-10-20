<?php

use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    //利用工厂文件，具体怎样创造数据
    public function run()
    {
        //创建30个商品
        $products = factory(\App\Models\Product::class,30)->create();
        foreach($products as $product){
        	//为每个商品创建3个sku
        	$skus = factory(\App\Models\ProductSku::class,3)->create(['product_id'=>$product->id]);
        	//找出最低价的sku，设置为商品价格
        	$product->update(['price'=>$skus->min('price')]);
        }
    }
}
