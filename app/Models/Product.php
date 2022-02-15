<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;



class Product extends Model
{
    use HasApiTokens, HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'categorie_id',
        'name',
        'price',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
