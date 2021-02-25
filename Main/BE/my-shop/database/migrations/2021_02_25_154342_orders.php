<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Orders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('customer_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->datetime('order_date')->nullable();
            $table->boolean('deliver_status')->default(0);
            $table->datetime('deliver_date')->nullable();
            $table->decimal('total_price');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign("customer_id")->references("id")->on("customers");
            $table->foreign("user_id")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
