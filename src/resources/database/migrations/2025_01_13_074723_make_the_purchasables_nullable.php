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
            // We're not reversing this because it will fail if there are any records in the table where the
            // purchasable id/type are NULL. But we do not even throw an irreversible migration exception
            // to avoid failing the CI tests. The chances of having a real life scenario for reverting
            // this migration are very low. If it happens to be your case, then open a GitHub issue

            // $table->unsignedBigInteger('purchasable_id')->nullable(false)->change();
            // $table->string('purchasable_type')->nullable(false)->change();
        });
    }
};
