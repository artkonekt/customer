<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('customer_purchases', function (Blueprint $table) {
            $table->renameColumn('purchase_date', 'date');
        });

        Schema::table('customer_purchases', function (Blueprint $table) {
            $table->renameColumn('purchase_value', 'value');
        });
    }

    public function down(): void
    {
        Schema::table('customer_purchases', function (Blueprint $table) {
            $table->renameColumn('date', 'purchase_date');
        });

        Schema::table('customer_purchases', function (Blueprint $table) {
            $table->renameColumn('value', 'purchase_value');
        });
    }
};
