<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id','category_id',
        'total_price','quantity','doc_date',
        'image'
    ];

    public function supplier(){
        return $this->belongsTo(User::class,'supplier_id','id');
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function purchaseProduct(){
        return $this->hasOne(Product::class);
    }
}
