<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('brand_id');
            $table->string('name');
            $table->string('product_code', 12)->unique(); // e.g. 01-0001
            $table->string('ChassisNumber')->nullable();
            $table->string('EngineNumber')->nullable();
            $table->string('Color')->nullable();
            $table->string('Year')->nullable();
            $table->decimal('Purchaseprice', 10, 2)->default(0);
            $table->integer('CC')->nullable();
            $table->string('WD')->nullable();
            $table->string('Transmission')->nullable();
            $table->string('PickupYard')->nullable();
            $table->string('Supplier')->nullable();
            $table->string('ODOMeter')->nullable();
            $table->string('Score')->nullable();
            $table->string('AuctionGrade')->nullable();
            $table->string('InvoiceNumber')->nullable();
            $table->tinyInteger('Status')->default(0)->comment('1: Actual, 0: General')->nullable();
            $table->text('Remarks')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
