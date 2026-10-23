<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Normalize the old default value to the backing value used by Role::Subscriber.
     */
    public function up(): void
    {
        DB::table('users')
            ->where('role', 'Subscriber')
            ->update(['role' => 'user']);

        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->change();
        });
    }

    /**
     * No reverse mapping: `user` is also the current valid backing value.
     */
    public function down(): void
    {
        // Intentionally left empty to avoid changing valid subscriber roles.
    }
};
