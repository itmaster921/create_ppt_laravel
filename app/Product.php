<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['productName','description'];

    public function getUsername(){
    	return User::where('id',$this->userId)->first();
    }
}
