<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    
    protected $fillable=[
        'section_name', 
        'description',
        'Created_by',
    ];

    //section hasMany products

    public function products(){

        return $this->hasMany('App\Models\Product');
    }

   //section hasMany invoices 
   public function invoices(){
       
       return $this->hasMany('App\Models\Invoice');
   }
}
