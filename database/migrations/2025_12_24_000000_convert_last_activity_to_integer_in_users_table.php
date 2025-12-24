<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'last_activity')) {
            // Convert DATETIME -> INT safely by using MySQL functions
            // 1) convert existing datetime values to unix timestamp
            DB::statement("UPDATE `users` SET `last_activity` = UNIX_TIMESTAMP(`last_activity`) WHERE `last_activity` IS NOT NULL AND `last_activity` != ''");
            // 2) alter column type
            DB::statement("ALTER TABLE `users` MODIFY `last_activity` INT(11) NULL");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'last_activity')) {
            // Convert INT -> DATETIME
            DB::statement("UPDATE `users` SET `last_activity` = FROM_UNIXTIME(`last_activity`) WHERE `last_activity` IS NOT NULL AND `last_activity` != ''");
            DB::statement("ALTER TABLE `users` MODIFY `last_activity` DATETIME NULL");
        }
    }
};
