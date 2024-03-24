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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->constrained('clients');
            $table->foreignId('client_address_id')->nullable()->constrained('client_addresses');
            $table->foreignId('product_id')->nullable()->constrained('products');
            $table->string('requestNumber');
            $table->date('dueDate');
            $table->decimal('amount', 10, 2);
            $table->decimal('shippingAmount', 10, 2)->nullable();
            $table->decimal('discountAmount', 10, 2)->nullable();
            $table->string('usernameCheckout')->nullable();
            $table->string('callbackUrl')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
