<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMainTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        //Lookup table for type of note
        Schema::create('note_types', function (Blueprint $table) {
            $table->id('id_note_type');
            $table->longText('name');
        });

        Schema::create('folders', function (Blueprint $table) {
            $table->id('id_folder');
            $table->longText('name');
            $table->unsignedBigInteger('id_user');
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('users');

        });

        Schema::create('notes', function (Blueprint $table) {
            $table->id('id_note');
            $table->longText('name');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_folder')->nullable(true); //in the instructions it said "notes can be organized into folders" I took this as they could be but are not necessarily always in folders, that's why I made the field nullable. I understand that when creating new notes without folders the field will need to be specifically declared as null
            $table->tinyInteger('public')->default(0); //if this is set to 1, then the note is public, user needs to opt in to his note being public, by default it will be private
            $table->unsignedBigInteger('id_note_type');
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('users');
            $table->foreign('id_folder')->references('id_folder')->on('folders');
            $table->foreign('id_note_type')->references('id_note_type')->on('note_types');
        });

        Schema::create('note_bodies', function (Blueprint $table) {
            $table->id('id_note_body');
            $table->unsignedBigInteger('id_note');
            $table->longText('text');
            $table->timestamps();

            $table->foreign('id_note')->references('id_note')->on('notes');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('note_types');
        Schema::dropIfExists('notes_bodies');
        Schema::dropIfExists('notes');
        Schema::dropIfExists('folders');

    }
}
