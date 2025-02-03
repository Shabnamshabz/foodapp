<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
Use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class carttabledata extends Model
{  protected $table='carttabledatas';
    protected $fillable=['item_id','cust_id','quantity','totalprice'];
    protected $primaryKey='cart_id';
    use HasApiTokens, HasFactory, Notifiable;
    
}
