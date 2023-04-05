<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->unsignedInteger('category_id')->index();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedInteger('quantity');
            $table->decimal('price', 8, 2)->nullable();
            $table->decimal('sale_price', 8, 2)->nullable();
            $table->boolean('is_active')->default(1);
            $table->boolean('featured')->default(0);
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
        Schema::dropIfExists('products');
    }
}
