<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MSalesOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_sales_order', function (Blueprint $table) {
            $table->id();
            $table->string('kode_order');
            $table->unsignedBigInteger('id_customer');
            $table->foreign('id_customer')->references('id')->on('m_customer');
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
        Schema::drop('m_sales_order');
    }
}
