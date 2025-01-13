<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('customer_purchases', function (Blueprint $table) {
            $table->unsignedBigInteger('purchasable_id')->nullable()->change();
            $table->string('purchasable_type')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('customer_purchases', function (Blueprint $table) {
            $table->unsignedBigInteger('purchasable_id')->nullable(false)->change();
            $table->string('purchasable_type')->nullable(false)->change();
        });
    }
};
