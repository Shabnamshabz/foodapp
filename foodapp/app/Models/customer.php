<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class customer extends Model
{ use HasApiTokens, HasFactory, Notifiable;
    protected $table='customers';
    protected $fillable=['customer_name','customer_email','customer_pass','customer_phno'];
    protected $primaryKey='customer_id';
    protected $hidden =['created_at','updated_at'];
    
}
