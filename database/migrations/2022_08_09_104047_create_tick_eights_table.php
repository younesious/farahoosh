<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tick_eights', function (Blueprint $table) {
            $table->id();
            $table->string('word');
            $table->string('answer');
            $table->boolean('hidden')->default(true);
            $table->integer('true')->default(0);
            $table->integer('false')->default(0);
            $table->string('group');
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
        Schema::dropIfExists('tick_eights');
    }
};
