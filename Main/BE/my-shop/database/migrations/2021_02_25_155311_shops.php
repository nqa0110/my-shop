<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Shops extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned(); //会社ID
            $table->string('name',255)->nullable(); //店舗名
            $table->string('city',255)->nullable(); //市町村
            $table->string('area',255)->nullable(); //町域
            $table->string('address',255)->nullable(); //番地
            $table->string('tel',10)->nullable(); //電話番号
            $table->string('email',255)->nullable(); //E-mail
            $table->softDeletes(); //削除日付
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
        Schema::dropIfExists('shops');
    }
}
