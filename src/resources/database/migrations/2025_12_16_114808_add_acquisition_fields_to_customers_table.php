<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('acquired_via')->nullable();
            $table->json('acquisition_details')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('acquired_via');
        });
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('acquisition_details');
        });
    }
};
