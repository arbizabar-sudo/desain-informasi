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
        // Add columns only if they do not already exist (helps when tests run against in-memory sqlite or re-run migrations)
        if (!Schema::hasColumn('users', 'headline')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('headline')->nullable()->after('cover_image');
            });
        }
        if (!Schema::hasColumn('users', 'institution')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('institution')->nullable()->after('headline');
            });
        }
        if (!Schema::hasColumn('users', 'location')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('location')->nullable()->after('institution');
            });
        }
        if (!Schema::hasColumn('users', 'url')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('url')->nullable()->after('location');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['headline', 'institution', 'location', 'url']);
        });
    }
};
