<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // SQLite doesn't support ALTER COLUMN, so we recreate the table
        Schema::table('equipments', function (Blueprint $table) {
            $table->renameColumn('status', 'status_old');
        });

        Schema::table('equipments', function (Blueprint $table) {
            $table->string('status')->default('available')->after('category');
        });

        // Copy data
        DB::table('equipments')->update([
            'status' => DB::raw('status_old'),
        ]);

        Schema::table('equipments', function (Blueprint $table) {
            $table->dropColumn('status_old');
        });
    }

    public function down(): void
    {
        // No rollback needed — string column accepts all values
    }
};
