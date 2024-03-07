<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
//            $table->foreignId('customer_id')->nullable()->constrained()->onDelete('cascade');
  $table->unsignedBigInteger('customer_id')->nullable();
//            $table->decimal('total_price')->nullable();
////            $table->string('quantity');
//            $table->dateTime('doc_date')->nullable();
//            $table->foreignId('customer_id')->nullable()->constrained()->onDelete('cascade');
            $table->decimal('total');
            $table->dateTime('doc_date');
            $table->softDeletes();
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
        Schema::dropIfExists('sales');
    }
}
