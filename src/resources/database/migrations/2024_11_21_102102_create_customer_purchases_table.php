<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customer_purchases', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id')->unsigned();
            $table->date('purchase_date')->nullable();
            $table->decimal('purchase_value')->nullable();
            $table->char('currency', 3)->nullable();
            $table->morphs('purchasable');
            $table->timestamps();

            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_purchases');
    }
};
