<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Exceptions\InvalidRequestException;

class ProductsController extends Controller
{
    public function index(Request $request){
    //创建一个查询构造器
    	$builder = Product::query()->where('on_sale',true);
    	//判断是否提交search数据，如果有就赋值给$search
    	if($search = $request->input('search','')){
    		$like = '%'.$search.'%';
    		//模糊搜索商品标题、详情、SKU标题与描述
    		$builder->where(function($query)use($like){
    			$query->where('title','like',$like)
    			->orWhere('description','like',$like)
    			->orWhereHas('skus',function($query) use ($like){
    				$query->where('title','like',$like)
    				->orWhere('description','like',$like);
    			});
    		});
    	}
    	//是否有提交order,有的话就赋值给$order
    	if($order = $request->input('order','')){
    		//是否以_asc或者_desc结尾
    		if(preg_match('/^(.+)_(asc|desc)$/',$order,$m)){
    			//如果字符串的开头是这3个字符串之一，说明是一个合法的排序值
    			if(in_array($m[1],['price','sold_count','rating'])){
    				//根据传入的排序值来构造参数
    				$builder->orderBy($m[1],$m[2]);
    			}
    		}
    	}
    	$products = $builder->paginate(16); //paginate(num)指分页取出数据，每页num个（分布按钮在前端调用$products->render()即可）

    	return view('products.index',['products' => $products]);
    }
    public function show(Product $product, Request $request){
    	//判断商品是否已经上架，如果没有则抛出异常
    	if(!$product->on_sale){
    		throw new InvalidRequestException('商品未上架');
    	}
    	return view('products.show',['product'=>$product]);
    }
}
