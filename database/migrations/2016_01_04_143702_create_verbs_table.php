<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVerbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verbs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('verb', 24)->collate('utf8_general_ci');
            $table->string('root', 24)->collate('utf8_general_ci');
            $table->string('stem', 24);
            $table->string('tense', 24);
            $table->enum('person', [1,2,3])->nullable();
            $table->enum('gender', ['m', 'f']);
            $table->enum('number', ['s', 'p']);
            $table->timestamps();

            $table->unique(['verb', 'root', 'stem', 'tense', 'gender', 'number']);

            $table->foreign('root')->references('root')->on('roots');
            $table->foreign('stem')->references('name')->on('stems');
            $table->foreign('tense')->references('name')->on('tenses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('verbs');
    }
}
