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
        Schema::table('transactions', function (Blueprint $table) {
            $table->enum('type', ['deposit', 'withdrawn'])->after('id_transaction')->default('deposit');
            $table->string('key', 100)->after('type')->nullable();
            $table->enum('key_type', ['document', 'phoneNumber', 'randomKey', 'email', 'paymentCode'])->after('key')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('key');
            $table->dropColumn('key_type');
        });
    }
};
