<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // 1. إنشاء جدول الختمات
        Schema::create('khatmas', function (Blueprint $table) {
            $table->id();
            $table->integer('total_completed')->default(0);
            $table->timestamps();
        });

        // 2. إنشاء جدول الأجزاء (شامل عداد القراءة)
        Schema::create('juzs', function (Blueprint $table) {
            $table->id();
            $table->integer('juz_number');
            $table->string('status')->default('available');
            $table->string('reader_name')->nullable();
            $table->integer('read_count')->default(0); // عداد القراءة
            $table->timestamp('reserved_at')->nullable();
            $table->timestamps();
        });

        // 3. إنشاء جدول الأدعية (شامل عداد آمين)
        Schema::create('doaas', function (Blueprint $table) {
            $table->id();
            $table->string('author_name')->default('فاعل خير');
            $table->text('message');
            $table->integer('amen_count')->default(0); // عداد آمين
            $table->timestamps();
        });

        // --------------------------------------------------
        // إدخال البيانات الأساسية تلقائياً (عشان متتعبش)
        // --------------------------------------------------

        DB::table('khatmas')->insert([
            'total_completed' => 0,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $juzsData = [];
        for ($i = 1; $i <= 30; $i++) {
            $juzsData[] = [
                'juz_number' => $i,
                'status' => 'available',
                'reader_name' => null,
                'read_count' => 0,
                'reserved_at' => null,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        DB::table('juzs')->insert($juzsData);
    }

    public function down()
    {
        Schema::dropIfExists('doaas');
        Schema::dropIfExists('juzs');
        Schema::dropIfExists('khatmas');
    }
};
