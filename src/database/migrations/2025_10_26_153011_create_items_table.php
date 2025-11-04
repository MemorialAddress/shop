<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('item_name');
            $table->string('brand_name')->nullable();
            $table->unsignedInteger('price');
            $table->string('item_describe',255);
            $table->string('category1');
            $table->string('category2')->nullable();
            $table->string('category3')->nullable();
            $table->string('category4')->nullable();
            $table->string('category5')->nullable();
            $table->string('category6')->nullable();
            $table->string('category7')->nullable();
            $table->string('category8')->nullable();
            $table->string('category9')->nullable();
            $table->string('category10')->nullable();
            $table->string('category11')->nullable();
            $table->string('category12')->nullable();
            $table->string('category13')->nullable();
            $table->string('category14')->nullable();
            $table->string('condition');
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
        Schema::dropIfExists('items');
    }
}
