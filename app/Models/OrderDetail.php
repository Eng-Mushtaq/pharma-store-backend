<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected  $guarded=[];
    protected $with='product';
    public  function  order(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Order::class,);
    }
    public  function  product()
    {
        return $this->belongsTo(Product::class);
    }

}
