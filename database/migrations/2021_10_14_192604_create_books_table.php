<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('first_cover');
            $table->date('publication_date');
            $table->string('description');
            $table->string('author');
            $table->string('genre');
            $table->bigInteger('user_id')->unsigned()->nullable();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->boolean('confirmed')->nullable();
            $table->timestamp('borrowDate')->nullable();
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
        Schema::dropIfExists('books');
    }
}
