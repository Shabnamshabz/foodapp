<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class fooditems extends Model
{   
    use HasApiTokens, HasFactory, Notifiable;
    protected $table='fooditems';
    protected $fillable=['categ_id','item_name','item_price','item_image'];
    protected $primaryKey='item_id';
    
}
