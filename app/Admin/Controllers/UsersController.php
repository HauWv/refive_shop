<?php
//代码全部自动生成好，只需要对CRUD方法进行编辑即可
namespace App\Admin\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class UsersController extends Controller
{
    use HasResourceActions;

    /**
     * index的样式设置.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            //标题
            ->header('用户列表')
            //标题补充
            ->description('')
            //正文内容
            ->body($this->grid());
    }


    /**
     * 列表生成器.
     *
     * @return Grid
     */
    protected function grid()
    {
        //自动生成，表示数据来源
        $grid = new Grid(new User);
//----------------列表内容控制-----------------------
        //每列显示的字段与显示名
        $grid->id('ID')->sortable();    //创建一列名为ID,内容来自id字段，并且可以点击排序（sortable())
        $grid->name('用户名');     //创建一列名为用户名，内容来自name字段
        $grid->email('邮箱');
        $grid->email_verified('已验证邮箱')->display(function($value){   //将bool值给$value,然后空对应否，非空对应是
            return $value ? '是':'否';
        });
        $grid->created_at('注册时间');

//-----------------按钮控制-----------------------
        //用来控制标题页处的按钮
        $grid->disableCreateButton();//关闭创建按钮
        //用来控制每一条数据后的按钮
        $grid->actions(function($actions){
            //不在每一行后面展示查看按钮
            $actions->disableView();
            //不在每一行后面展示删除按钮
            $actions->disableDelete();
            //不在每一行后面展示编辑按钮
            $actions->disableEdit();
        });
        //用来控制其他按钮（这里定义了一个批量删除）
        $grid->tools(function($tools){
            $tools->batch(function($batch){
                $batch->disableDelete();
            });
        });

        return $grid;
    }

}
