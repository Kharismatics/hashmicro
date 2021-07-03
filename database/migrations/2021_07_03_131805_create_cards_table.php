<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->date('date_create');
            $table->string('name');
            $table->bigInteger('minimal')->nullable($value = true);
            $table->bigInteger('maximal')->nullable($value = true);
            $table->boolean('istrue');
            $table->enum('ability', ['easy', 'medium', 'hard']);
            $table->bigInteger('created_by')->nullable($value = true);
            $table->bigInteger('updated_by')->nullable($value = true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cards');
    }
}
