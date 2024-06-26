<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
//            $table->string('product');
//            $table->foreignId('category_id')->nullable()->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->decimal('total_price')->nullable();
//            $table->string('quantity');
            $table->dateTime('doc_date')->nullable();
//            $table->string('image')->nullable();
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
        Schema::dropIfExists('purchases');
    }
}
