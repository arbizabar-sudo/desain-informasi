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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'headline')) {
                $table->string('headline')->nullable()->after('bio');
            }
            if (!Schema::hasColumn('users', 'institution')) {
                $table->string('institution')->nullable()->after('headline');
            }
            if (!Schema::hasColumn('users', 'location')) {
                $table->string('location')->nullable()->after('institution');
            }
            if (!Schema::hasColumn('users', 'website')) {
                $table->string('website')->nullable()->after('location');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'website')) {
                $table->dropColumn('website');
            }
            if (Schema::hasColumn('users', 'location')) {
                $table->dropColumn('location');
            }
            if (Schema::hasColumn('users', 'institution')) {
                $table->dropColumn('institution');
            }
            if (Schema::hasColumn('users', 'headline')) {
                $table->dropColumn('headline');
            }
        });
    }
};
