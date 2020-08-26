<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use App\Models\Category;
use App\Models\Product;
use Encore\Admin\Grid;
use Encore\Admin\Form;

// 定义一个抽象类（抽象类用于抽象提炼类的公共属性和方法，继承接口需要全部实现其方法，而继承抽象类则不必）
abstract class CommonProductsController extends AdminController
{
    // 定义一个抽象方法，返回当前管理的商品类型（抽象方法是必须在继承的子类中实现的，其他方法则不是必须的）
    abstract public function getProductType(); // 交由子类去实现

    protected function grid()
    {
        $grid = new Grid(new Product());

        // 筛选出当前类型的商品，默认 ID 倒序排列
        $grid->model()->where('type', $this->getProductType())->orderBy('id', 'desc');
        // 调用自定义方法
        $this->customGrid($grid);

        $grid->actions(function($actions) {
            $actions->disableView();
            $actions->disableDelete();
        });
        $grid->tools(function($tools) {
            $tools->batch(function($batch) {
                $batch->disableDelete();
            });
        });

        return $grid;
    }

    // 定义一个抽象方法，各个类型的控制器将实现本方法，来定义类别应该展示哪些字段
    abstract protected function customGrid(Grid $grid);

    protected function form()
    {
        $form = new Form(new Product());
        // 在表单页面中添加一个名为 type 的隐藏字段，值为当前商品类型
        $form->hidden('type')->value($this->getProductType());
        $form->text('title', '商品名称')->rules('required');
        $form->select('category_id', '类目')->options(function($id) {
            $category = Category::find($id);
            if ($category) {
                return [$category->id => $category->name];
            }
        })->ajax('/admin/api/categories/?is_directory=0');
        $form->image('image', '封面图片')->rules('required|image');
        $form->quill('description', '商品描述')->rules('required');
        $form->radio('on_sale')->options(['1' => '是', '0' => '否'])->default('0');

        // 调用自定义方法
        $this->customForm($form);

        $form->hasMany('skus', '商品 SKU', function(Form\NestedForm $form) {
            $form->text('title', 'SKU 名称')->rules('required');
            $form->text('description', 'SKU 描述')->rules('required');
            $form->text('price', '价格')->rules('required|numeric|min:0.01');
            $form->text('stock', '剩余库存')->rules('required|numeric|min:0');
        });
        $form->saving(function(Form $form) {
            $form->model()->price = collect($form->input('skus'))->where(Form::REMOVE_FLAG_NAME, 0)->min('price') ?: 0;
        });

        return $form;
    }

    // 定义一个抽象方法，各个类型的控制器将实现本方法，来定义表单应该有哪些额外的字段
    abstract protected function customForm(Form $form);
}