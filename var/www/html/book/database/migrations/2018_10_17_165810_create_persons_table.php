<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tytul')->nullable();
            $table->string('imie')->nullable();
            $table->string('nazwisko')->nullable();
            $table->string('status')->nullable();
            $table->string('email')->nullable();
            $table->string('telefon', 32)->nullable();
            $table->string('pomieszczenie', 32)->nullable();
            $table->string('grupa')->nullable();
            $table->string('sekret')->nullable();
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
        Schema::dropIfExists('persons');
    }
}
