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
        Schema::create('fooditems', function (Blueprint $table) {
             $table->bigIncrements('item_id');
            $table->UnsignedBigInteger('categ_id');
            $table->string('item_name', 255); // Product name
            $table->decimal('item_price', 10, 2); // Product price
            $table->string('item_image'); // Product image path
            $table->timestamps();

        $table->foreign('categ_id')
              ->references('category_id')
              ->on('categories')
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
        Schema::dropIfExists('fooditems');
    }
};
