<?php

namespace App\Admin\Controllers;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ProductsController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('商品列表')
            ->description('')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed   $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed   $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('编辑商品')
            ->description('')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('创建商品')
            ->description('')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Product);

        $grid->id('Id')->sortable();
        $grid->title('商品名称');
        $grid->on_sale('已上架')->display(function($value){return $value?'是':'否';});
        $grid->price('价格');
        $grid->rating('评分');
        $grid->sold_count('销量');
        $grid->review_count('评论数');
        $grid->created_at('创建时间');
        $grid->updated_at('更新时间');

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed   $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Product::findOrFail($id));

        $show->id('Id');
        $show->title('Title');
        $show->description('Description');
        $show->image('Image');
        $show->on_sale('On sale');
        $show->rating('Rating');
        $show->sold_count('Sold count');
        $show->review_count('Review count');
        $show->price('Price');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * 可视化编辑界面,将编辑、验证、储存(store()在ModelForm里定义,路由仍填ProductsController@store)
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Product);
        //创建一个输入框，输入商品名称；rules()为数据验证规则
        $form->text('title', '商品名称')->rules('required');
        //创建图片上传器
        $form->image('image', '封面图片')->rules('required|image');
        //创建一个富文本编辑器
        $form->editor('description', '商品描述')->rules('required');
        //创建单选框
        $form->radio('on_sale', '上架')->options(['1'=>'是','0'=>'否'])->default(0);
        //添加一对多关联模型，直接编辑SKU
        $form->hasMany('skus','添加SKU',function(Form\NestedForm $form){
            $form->text('title','SKU名称')->rules('required');
            $form->text('description','SKU描述')->rules('required');
            $form->text('price','单价')->rules('required|numeric|min:0.01');
            $form->text('stock','剩余库存')->rules('required|integer|min:0');
        });
        //定义事件回调，当模型saving()时回调匿名函数function(Form $form){}，将SKU的最低价保存为product表里的price
        $form->saving(function(Form $form){
            //利用$form取出price字段，设定值为
            $form->model()->price = collect($form->input('skus'))->where(Form::REMOVE_FLAG_NAME,0)->min('price')?:0;
        });
        return $form;
    }
}
