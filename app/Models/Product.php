<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable  = ['id', 'name', 'stock','price', 'description'];
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function supplies()
    {
        return $this->hasMany(Supply::class);
    }

}
