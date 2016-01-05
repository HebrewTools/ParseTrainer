<?php
/**
 * HebrewParseTrainer - practice Hebrew verbs
 * Copyright (C) 2015  Camil Staps <info@camilstaps.nl>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

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
            $table->enum('gender', ['m', 'f', 'c']);
            $table->enum('number', ['s', 'p']);
            $table->timestamps();

            $table->unique(['verb', 'root', 'stem', 'tense', 'person', 'gender', 'number']);

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
