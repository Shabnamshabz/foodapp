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
        Schema::create('carttabledatas', function (Blueprint $table) {
             $table->bigIncrements('cart_id');
            $table->UnsignedBigInteger('item_id');
            $table->UnsignedBigInteger('cust_id');
            $table->string('quantity',100);
             $table->string('totalprice',10,2);
             $table->timestamps();

            $table->foreign('item_id')
                   ->references('item_id')
                   ->on('fooditems')
                   ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carttabledatas');
    }
};
