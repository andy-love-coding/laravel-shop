<?php

namespace App\Admin\Controllers;

use Encore\Admin\Layout\Content;

use App\Models\Order;
use App\Models\Product;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Grid;

class OrdersController extends AdminController
{

    protected $title = '订单';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order());

        // 只展示已支付的订单，并且默认按支付时间倒序排列
        $grid->model()->whereNotNull('paid_at')->orderBy('paid_at', 'desc');

        $grid->no('订单流水号');
        // 展示关联关系字段时，使用 column 方法
        $grid->column('user.name', '买家');
        $grid->total_amount('总金额')->sortable();
        $grid->paid_at('支付时间')->sortable();
        $grid->ship_status('物流')->display(function($value) {
            return Order::$shipStatusMap[$value];
        });
        $grid->refund_status('退款状态')->display(function($value) {
            return Order::$refundStatusMap[$value];
        });
        // 禁用创建按钮，后台不需要创建订单
        $grid->disableCreateButton();
        $grid->actions(function ($actions) {
            // 禁用删除和编辑
            $actions->disableDelete();
            $actions->disableEdit();
        });
        $grid->tools(function($tools) {
            // 禁用批量删除按钮
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
        });

        return $grid;
    }
    public function show($id, Content $content)
    {
        
        return $content->header('查看订单')
                       ->body(view('admin.orders.show', ['order' => Order::find($id)]));
    }

}
