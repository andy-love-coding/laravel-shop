<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSku extends Model
{
    protected $fillable = ['title', 'description', 'price', 'stock'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function decreaseStock($amount)
    {
        if ($amount < 0) {
            throw new InternalException('减库存不可小于0');
        }

        // 执行：$sku->decreaseStock(8)，其对应sql如下：
        // update `product_skus` set `stock` = `stock` - 8, `product_skus`.`updated_at` = '2020-08-17 04:38:15' where `id` = 95 and `stock` >= '8'

        // $this 代表本 model，表示数据表的一行，但如果 $this 加上了 where 条件，就变成查询构建器了，就不表示这一行了，如果仍需要指向本行，需加上 where('id', $this->id)

        // 本例如果不加 where('id', $this->id) 的话，那么就会减去所有 `stock` >= '8' 的库存，对应的sql如下：
        // update `product_skus` set `stock` = `stock` - 8, `product_skus`.`updated_at` = '2020-08-17 04:38:15' where stock` >= '8'
        return $this->where('id', $this->id)->where('stock', '>=', $amount)->decrement('stock', $amount);
    }

    public function addStock($amount)
    {
        if ($amount < 0) {
            throw new InternalException('加库存不可小于0');
        }
        // 执行：$sku->addStock(3)，其对应sql如下：
        // update `product_skus` set `stock` = `stock` + 3, `product_skus`.`updated_at` = '2020-08-17 04:51:28' where `id` = 95
        // 此时 increment() 动作是在 $this（model实例 ，代表这一行） 上完成的。      
        $this->increment('stock', $amount);
    }
}
