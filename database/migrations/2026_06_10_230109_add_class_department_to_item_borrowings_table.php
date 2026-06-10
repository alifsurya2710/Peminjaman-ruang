<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('item_borrowings', function (Blueprint $table) {
            $table->string('class_name')->nullable()->after('borrower_name');
            $table->string('department')->nullable()->after('class_name');
        });
    }

    public function down(): void
    {
        Schema::table('item_borrowings', function (Blueprint $table) {
            $table->dropColumn(['class_name', 'department']);
        });
    }
};
