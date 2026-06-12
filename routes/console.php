<?php

use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\DB;

// هذه المهمة ستعمل كل ساعة لمراجعة الأجزاء المحجوزة
Schedule::call(function () {
    DB::table('juzs')
        ->where('status', 'reserved')
        ->where('reserved_at', '<', now()->subHours(24))
        ->update([
            'status' => 'available',
            'reader_name' => null,
            'reserved_at' => null,
        ]);
})->hourly();
