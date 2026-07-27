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
        Schema::table('products', function (Blueprint $table) {

            $table->unsignedBigInteger('brand_id');
            $table->string('name');
            $table->string('product_code', 12)->unique(); // e.g. 01-0001
            $table->string('ChassisNumber')->nullable();
            $table->string('EngineNumber')->nullable();
            $table->string('Color')->nullable();
            $table->string('Year')->nullable();
            $table->integer('Purchaseprice')->default(0);
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

            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['brand_id']);
            $table->dropColumn([
                'brand_id',
                'name',
                'product_code',
                'ChassisNumber',
                'EngineNumber',
                'Color',
                'Year',
                'Purchaseprice',
                'CC',
                'WD',
                'Transmission',
                'PickupYard',
                'Supplier',
                'ODOMeter',
                'Score',
                'AuctionGrade',
                'InvoiceNumber',
                'Status',
                'Remarks',
            ]);
        });
    }
};
