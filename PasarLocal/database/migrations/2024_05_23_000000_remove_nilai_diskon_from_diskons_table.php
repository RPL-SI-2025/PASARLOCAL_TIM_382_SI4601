<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('diskons', function (Blueprint $table) {
            $table->dropColumn('nilai_diskon');
        });
    }

    public function down(): void
    {
        Schema::table('diskons', function (Blueprint $table) {
            $table->decimal('nilai_diskon', 10, 2)->nullable();
        });
    }
}; 