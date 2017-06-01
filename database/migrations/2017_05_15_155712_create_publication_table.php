<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('publication', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('committee');
            $table->foreign('committee')->references('id')->on('committee')->onDelete('set null');
            $table->string('title',255);
            $table->text('content');
            $table->date('publication_date');
            $table->integer('status');
            $table->foreign('status')->references('id')->on('publication_status')->onDelete('set null');
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
        Schema::dropIfExists('publication');
    }
}
