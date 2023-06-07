<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    
    protected $casts = [
        'products' => 'json',
    ];
    
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
