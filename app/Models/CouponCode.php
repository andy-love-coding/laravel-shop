<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Encore\Admin\traits\DefaultDatetimeFormat;
use Illuminate\Support\Str;

class CouponCode extends Model
{
    use DefaultDatetimeFormat;
    // 用常量的方式定义支持的优惠券类型
    const TYPE_FIXED = 'fixed';
    const TYPE_PERCENT = 'percent';

    public static $typeMap = [
        self::TYPE_FIXED => '固定金额',
        self::TYPE_PERCENT => '比例',
    ];

    protected $fillable = [
        'name',
        'code',
        'type',
        'value',
        'total',
        'used',
        'min_amount',
        'not_before',
        'not_after',
        'enabled',
    ];
    protected $casts = [
        'enabled' => 'boolean',
    ];
    // 指定这两个字段是日期类型
    protected $dates = ['not_before', 'not_after',];

    protected $appends = ['description'];

    public function getDescriptionAttribute()
    {
        $str = '';

        if ($this->min_amount >0) {
            $str = '满'.$this->min_amount;
        }
        if ($this->type === self::TYPE_PERCENT) {
            return $str .'优惠'.str_replace('.00', '', $this->value).'%';
        }

        return $str.'减'.str_replace('.00', '', $this->value);
    }

    public static function findAvailableCode($length = 16)
    {
        do {
            // 生成一个指定长度的随机字符串，并转成大写
            $code = strtoupper(Str::random($length));
        // 如果生产的码一件存在就继续循环生成，知道生成一个全新的优惠码
        } while(self::query()->where('code', $code)->exists());

        return $code;
    }
}
