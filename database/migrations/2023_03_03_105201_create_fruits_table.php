<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFruitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fruits', function (Blueprint $table) {
            $table->id();
            $table->string('genus');
            $table->string('name')->index();
            $table->string('order');
            $table->float('carbohydrates');
            $table->float('protein');
            $table->float('fat');
            $table->float('calories');
            $table->float('sugar');
            $table->foreignId('fruit_family_id')->index()->constrained()->cascadeOnDelete();
            $table->boolean('is_favorited')->default(false);
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
        Schema::dropIfExists('fruits');
    }
}
