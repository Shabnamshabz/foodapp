<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('paymentid'); // AUTO_INCREMENT PRIMARY KEY
    $table->string('cust_id');         // Customer ID
    $table->decimal('Totalprice');    // Total price
    $table->string('cardnumber');     // Card number
    $table->string('expirydate');     // Expiry date
    $table->string('securitycode');            // CVV as a string
    $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
