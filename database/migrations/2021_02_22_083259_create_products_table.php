<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_pegawai')->unsigned();            
            $table->bigInteger('nik');
            $table->string('nama');
            $table->string('pekerjaan');
            $table->string('alamat');
            $table->bigInteger('nohp');
            $table->string('keperluan')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();

            $table->foreign('id_pegawai')->references('id')
            ->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
