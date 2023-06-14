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
<<<<<<< HEAD
    public static function forDropdown($business_id)
    {
        $all_ct = Catalog::where('business_id', $business_id);
        $all_ct = $all_ct->pluck('name', 'id');

        //Prepend none
       

        return $all_ct;
    }
=======
>>>>>>> 057d6f0509a0904381860dc4403b5e03ce995bfd
}
