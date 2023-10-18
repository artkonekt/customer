<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->unsignedBigInteger('default_billing_address_id')->nullable();
            $table->unsignedBigInteger('default_shipping_address_id')->nullable();

            $table->foreign('default_billing_address_id')->references('id')->on('addresses')->nullOnDelete();
            $table->foreign('default_shipping_address_id')->references('id')->on('addresses')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropForeign('customers_default_billing_address_id_foreign');
            $table->dropForeign('customers_default_shipping_address_id_foreign');

            $table->dropColumn('default_billing_address_id');
            $table->dropColumn('default_shipping_address_id');
        });
    }
};
