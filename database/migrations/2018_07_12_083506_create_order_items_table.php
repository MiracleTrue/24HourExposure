<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

            $table->unsignedInteger('gift_id');
            $table->foreign('gift_id')->references('id')->on('gifts')->onDelete('cascade');

            $table->unsignedInteger('number')->comment('数量');

            $table->decimal('item_price')->comment('金额');
            $table->text('snapshot')->comment('JSON格式商品快照');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
