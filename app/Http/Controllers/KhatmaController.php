<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Events\JuzReserved;

class KhatmaController extends Controller
{
    public function index()
    {
        $juzs = DB::table('juzs')->orderBy('juz_number', 'asc')->get();
        $khatmaStats = DB::table('khatmas')->first();
        $totalCompleted = $khatmaStats ? $khatmaStats->total_completed : 0;
        $doaas = DB::table('doaas')->orderBy('created_at', 'desc')->take(20)->get();

        return view('khatma.index', compact('juzs', 'totalCompleted', 'doaas'));
    }

    public function reserve(Request $request, $id)
    {
        $juz = DB::table('juzs')->where('id', $id)->first();
        if (!$juz) abort(404);

        $readerName = $request->input('reader_name') ?: 'فاعل خير';

        DB::table('juzs')->where('id', $id)->update([
            'status' => 'reserved',
            'reader_name' => $readerName,
            'reserved_at' => now(),
        ]);

        // إطلاق الإشعار المباشر لكل الناس اللي فاتحة الموقع في نفس اللحظة
        event(new JuzReserved($juz->juz_number, $readerName));

        return redirect()->route('khatma.read', $id)->with('success', 'تم حجز الجزء بنجاح، تقبل الله منك.');
    }

    public function read($id)
    {
        $juz = DB::table('juzs')->where('id', $id)->first();
        if (!$juz) abort(404);

        $surahs = cache()->remember("juz_{$id}_data", 86400, function () use ($juz) {
            $surahs = [];
            try {
                $response = Http::withoutVerifying()
                    ->timeout(30)
                    ->retry(3, 100)
                    ->get("https://api.alquran.cloud/v1/juz/{$juz->juz_number}/quran-uthmani");

                if ($response->successful()) {
                    $data = $response->json()['data']['ayahs'] ?? [];
                    foreach ($data as $ayah) {
                        $surahId = $ayah['surah']['number'];
                        if (!isset($surahs[$surahId])) {
                            $surahs[$surahId] = [
                                'name' => $ayah['surah']['name'],
                                'number' => $surahId,
                                'ayahs' => []
                            ];
                        }
                        $surahs[$surahId]['ayahs'][] = $ayah;
                    }
                } else {
                    Log::error("Khatma Read Error: Failed to fetch API - " . $response->status());
                }
            } catch (\Exception $e) {
                Log::error("Khatma Read Exception: " . $e->getMessage());
            }
            return $surahs;
        });

        return view('khatma.read', compact('juz', 'surahs'));
    }

    public function complete($id)
    {
        DB::table('juzs')->where('id', $id)->update(['status' => 'completed']);
        DB::table('juzs')->where('id', $id)->increment('read_count');

        $completedCount = DB::table('juzs')->where('status', 'completed')->count();
        if ($completedCount >= 30) {
            DB::table('khatmas')->increment('total_completed');
            DB::table('juzs')->update([
                'status' => 'available',
                'reader_name' => null,
                'reserved_at' => null,
            ]);
            return redirect()->route('khatma.index')->with('success', 'الله أكبر! تمت الختمة كاملة.');
        }
        return redirect()->route('khatma.index')->with('success', 'تمت القراءة بنجاح، تقبل الله منك.');
    }

    public function storeDoaa(Request $request)
    {
        $request->validate(['message' => 'required|max:500']);

        DB::table('doaas')->insert([
            'author_name' => $request->input('author_name') ?: 'فاعل خير',
            'message' => $request->input('message'),
            'created_at' => now(),
            'updated_at' => now(),
            'amen_count' => 0
        ]);

        return redirect()->back()->with('success', 'تمت إضافة دعائك بنجاح.');
    }

    public function amenDoaa($id)
    {
        DB::table('doaas')->where('id', $id)->increment('amen_count');
        return redirect()->back();
    }
}
