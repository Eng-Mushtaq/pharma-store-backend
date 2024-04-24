<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
class Product extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'category_id','price','name','name_2','exp_date',
        'discount','description',
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function getExpDateAttribute()
{
    return Carbon::parse($this->attributes['exp_date'])->format('Y-m-d');
}
}
