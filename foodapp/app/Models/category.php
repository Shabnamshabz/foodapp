<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class category extends Model

{ 
   use HasApiTokens, HasFactory, Notifiable;

 protected $table='categories';
   protected $fillable=['category_name','category_image'];
   protected $primaryKey='category_id';
    
}
