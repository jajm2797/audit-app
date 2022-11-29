<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClosedFindsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('closed_finds', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('find_id');
            $table->text('comment');
            $table->timestamps();

            $table->foreign('find_id')
                ->references('id')
                ->on('finds')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('closed_finds');
    }
}
