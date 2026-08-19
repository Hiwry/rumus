<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('quotes')) {
            Schema::table('quotes', function (Blueprint $table) {
                if (!Schema::hasColumn('quotes', 'converted_to_order_id')) {
                    $table->foreignId('converted_to_order_id')->nullable()->constrained('orders')->nullOnDelete();
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('quotes')) {
            Schema::table('quotes', function (Blueprint $table) {
                if (Schema::hasColumn('quotes', 'converted_to_order_id')) {
                    $table->dropForeign(['converted_to_order_id']);
                    $table->dropColumn('converted_to_order_id');
                }
            });
        }
    }
};
