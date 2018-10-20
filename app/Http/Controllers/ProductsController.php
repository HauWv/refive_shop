<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductsController extends Controller
{
    public function index(Request $request){
    	$products = Product::query()->where('on_sale',true)->paginate(16); //paginate(num)指分页取出数据，每页num个（分布按钮在前端调用$products->render()即可）

    	return view('products.index',['products' => $products]);
    }
}
