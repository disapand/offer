<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('papers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(1)->comment('用户ID');
            $table->integer('custom_id')->comment('客户ID');
            $table->string('paperId')->comment('报价单编号');
            $table->string('paperTime')->comment('报价时间');
            $table->string('paperList')->comment('报价条目');
            $table->string('discount')->default('1')->comment('折扣');
            $table->string('shouldPay')->comment('合计金额');
            $table->string('transformPrice')->default(0)->comment('交通费');
            $table->softDeletes();
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
        Schema::dropIfExists('papers');
    }
}
