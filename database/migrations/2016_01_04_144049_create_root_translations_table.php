<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRootTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('root_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('root', 24)->collate('utf8_general_ci');
            $table->string('translation', 63);
            $table->timestamps();

            $table->unique(['root', 'translation']);

            $table->foreign('root')->references('root')->on('roots');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('root_translations');
    }
}
