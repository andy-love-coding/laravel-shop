<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;

class CategoriesController extends AdminController
{
    protected $title = '商品类目';

    // 重新了父类的 edit() 方法
    // edit() 直接从父类 Encore\Admin\Controllers\AdminController::edit，复制过来的
    // 唯一区别就是在最后一行调用 form() 方法时多加了一个 true 参数
    public function edit($id,Content $content)
    {
        return $content
            ->title($this->title())
            ->description($this->description['edit']??trans('admin.edit'))
            ->body($this->form(true)->edit($id));
    }

    protected function grid()
    {
        $grid = new Grid(new Category());

        $grid->id('ID')->sortable();
        $grid->name('名称');
        $grid->level('层级');
        $grid->is_directory('是否目录')->display(function($value) {
            return $value ? '是' : '否';
        });
        $grid->path('类目路径');
        $grid->actions(function($actions) {
            $actions->disableView();
        });

        return $grid;
    }

    
    protected function form($isEditing = false)
    {
        $form = new Form(new Category());

        $form->text('name', '类目名称')->rules('required');
        
        // 如果是编辑的情况
        if ($isEditing) {
            // 不允许用户修改「是否目录」和「父目录」字段的值
            // 用 display() 方法来展示值，with() 方法接受一个匿名函数，会把字段值传给匿名函数，并把返回值展示出来
            $form->display('is_directory', '是否目录')->with(function($value) {
                return $value ? '是' : '否';
            });
            // 支持用符号 . 来展示关联关系的字段
            $form->display('parent.name', '父类目');
        } else {
            // 定义一个名为「是否目录」的单选框
            $form->radio('is_directory', '是否目录')
                ->options(['1' => '是', '0' => '否'])
                ->default('0')
                ->rules('required');
            $form->select('parent_id', '父类目')->ajax('/admin/api/categories');
            // ->ajax(xxx) 代表下拉框的值通过 /admin/api/categories 接口搜索获取，Laravel-Admin 会把用户输入的值以 q 参数传给接口，这个接口需要返回的数据格式为分页格式，并且 data 字段的格式为：
            /** 
             * [
             *     ["id" => 1, "text" => "手机配件"],
             *     ["id" => 2, "text" => "耳机"],
             * ]
            */
        }

        return $form;
    }

    // 定义下拉搜索接口
    public function apiIndex(Request $request)
    {
        // 用户输入的值通过 q 参数获取
        $search = $request->input('q');

        /** $result 格式如下
         * current_page: 1
         * data: [{id: 1, name: "手机配件", parent_id: null, is_directory: true, level: 0, path: "-",…},…]
         *   > 0: {id: 1, name: "手机配件", parent_id: null, is_directory: true, level: 0, path: "-",…}
         *   > 1: {id: 24, name: "手机通讯", parent_id: null, is_directory: true, level: 0, path: "-",…}
         * first_page_url: "http://laravel-shop6.0.test/admin/api/categories?page=1"
         * from: 1
         * last_page: 1
         * last_page_url: "http://laravel-shop6.0.test/admin/api/categories?page=1"
         * next_page_url: null
         * path: "http://laravel-shop6.0.test/admin/api/categories"
         * per_page: 15
         * prev_page_url: null
         * to: 2
         * total: 2
        */        
        $result = Category::query()
            ->where('is_directory', true) // 用于这里选择的是父类目，因此需要限定 is_directory 为 true
            ->where('name', 'like', '%'.$search.'%')
            ->paginate();
        
        /** 把查询出来的结果重新组装成 Laravel-Admin 需要的格式，组装前后，仅仅 data 的内容有所改变，如下：
         * current_page: 1
         * data: [{id: 1, text: "手机配件"}, {id: 24, text: "手机通讯"}]
         *   > 0: {id: 1, text: "手机配件"}
         *   > 1: {id: 24, text: "手机通讯"}
         * first_page_url: "http://laravel-shop6.0.test/admin/api/categories?page=1"
         * from: 1
         * last_page: 1
         * last_page_url: "http://laravel-shop6.0.test/admin/api/categories?page=1"
         * next_page_url: null
         * path: "http://laravel-shop6.0.test/admin/api/categories"
         * per_page: 15
         * prev_page_url: null
         * to: 2
         * total: 2
        */
        $result->setCollection($result->getCollection()->map(function(Category $category) {
            return ['id' => $category->id, 'text' => $category->full_name];
        }));
        // 这2个方法需要翻源码才能找到，getCollection 就是获取到这个分页里的数据集合，setCollection 就是替换分页的数据替换
        // 遇到在文档中找不到的方法或类，可以去 Laravel 的 API 中去找：https://laravel.com/api/5.8/Illuminate/Pagination/AbstractPaginator.html#method_setCollection

        return $result;
    }
}
