<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('artworks') && !Schema::hasColumn('artworks', 'share_count')) {
            Schema::table('artworks', function (Blueprint $table) {
                $table->unsignedInteger('share_count')->default(0);
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('artworks') && Schema::hasColumn('artworks', 'share_count')) {
            Schema::table('artworks', function (Blueprint $table) {
                $table->dropColumn('share_count');
            });
        }
    }
};
