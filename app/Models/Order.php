<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\Cast;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory;
    protected  $guarded=[];
//   protected $casts=['created_at'=>'Y-m-d'];
public function getCreatedAtAttribute()
{
    return Carbon::parse($this->attributes['created_at'])->format('Y-m-d');
}
    protected $with='details';
    public  function  user()
    {
        return $this->belongsTo(User::class);
    }
    public  function  details(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderDetail::class,'order_id','id');
    }
}
