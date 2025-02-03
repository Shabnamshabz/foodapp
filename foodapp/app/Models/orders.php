<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class orders extends Model
{use HasApiTokens, HasFactory, Notifiable;
 protected $table='orders';
    protected $fillable=['cust_id','total_price'];
    protected $primaryKey='order_id';
}
