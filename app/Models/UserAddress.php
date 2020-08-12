<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $fillable = [
        'province',
        'city',
        'distinct',
        'address',
        'zip',
        'contact_name',
        'contact_phone',
        'last_used_at'
    ];
    protected $dates = ['last_used_at'];

    // 创建了一个访问器
    public function getFullAddressAttributes()
    {
        return "{$this->province}{$this->city}{$this->district}{$this->address}";
    }
}
