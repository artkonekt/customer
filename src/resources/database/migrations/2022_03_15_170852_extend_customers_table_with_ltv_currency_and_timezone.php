<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExtendCustomersTableWithLtvCurrencyAndTimezone extends Migration
{
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('timezone')->nullable()->after('registration_nr');
            $table->string('currency', 3)->nullable()->after('registration_nr');
            $table->decimal('ltv', 15, 4)->default(0)->after('is_active')->comment('Customer Lifetime Value');
        });
    }

    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('timezone');
            $table->dropColumn('currency');
            $table->dropColumn('ltv');
        });
    }
}
