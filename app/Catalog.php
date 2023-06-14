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
    public static function forDropdown($business_id)
    {
        $all_ct = Catalog::where('business_id', $business_id);
        $all_ct = $all_ct->pluck('name', 'id');

        //Prepend none
       

        return $all_ct;
    }
}
