<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommitteeMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('committee_member', function (Blueprint $table) {
            $table->integer('committee');
            $table->foreign('committee')->references('id')->on('committee')->onDelete('cascade');
            $table->integer('member');
            $table->foreign('member')->references('id')->on('member')->onDelete('cascade');
            $table->primary(array('committee','member'));
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
        Schema::dropIfExists('committee_member');
    }
}
