<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
    protected $table='payments';
    protected $fillable=['cust_id','Totalprice','cardnumber','expirydate','securitycode'];
    protected $primaryKey='paymentid';

    use HasFactory;
}
