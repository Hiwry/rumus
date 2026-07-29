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
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->string('quote_number')->index();
            $table->date('quote_date')->nullable();
            $table->string('client_name')->nullable();
            $table->string('client_contact')->nullable();
            $table->string('client_email')->nullable();
            $table->string('client_address')->nullable();
            $table->string('referent')->nullable();
            $table->string('seller_name')->nullable();
            $table->string('seller_whatsapp')->nullable();
            $table->string('delivery_time')->nullable();
            $table->string('validity')->nullable();
            $table->text('observations')->nullable();
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->json('items')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_cnpj')->nullable();
            $table->string('company_ie')->nullable();
            $table->string('company_address')->nullable();
            $table->string('company_phone')->nullable();
            $table->string('signer_name')->nullable();
            $table->string('signer_role')->nullable();
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
