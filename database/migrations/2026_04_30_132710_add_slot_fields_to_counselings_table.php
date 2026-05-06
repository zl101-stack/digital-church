<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('counselings', function (Blueprint $table) {
            // true = ini adalah slot jadwal yang dibuat admin/superadmin
            // false = ini adalah booking yang sudah diambil user
            $table->boolean('is_slot')->default(false)->after('duration');

            // user_id yang melakukan booking (berbeda dari user_id pemilik slot)
            $table->foreignId('booked_by')->nullable()->after('is_slot');

            // catatan dari user saat booking
            $table->text('booking_note')->nullable()->after('booked_by');
        });
    }

    public function down(): void
    {
        Schema::table('counselings', function (Blueprint $table) {
            $table->dropColumn(['is_slot', 'booked_by', 'booking_note']);
        });
    }
};
