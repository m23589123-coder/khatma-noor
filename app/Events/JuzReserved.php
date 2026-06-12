<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

// استخدام ShouldBroadcastNow عشان الإشعار يوصل فوراً من غير تأخير
class JuzReserved implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $juzNumber;
    public $readerName;

    public function __construct($juzNumber, $readerName)
    {
        $this->juzNumber = $juzNumber;
        $this->readerName = $readerName;
    }

    public function broadcastOn()
    {
        // اسم القناة اللي هنذيع عليها
        return new Channel('khatma-live');
    }

    public function broadcastAs()
    {
        // اسم الحدث اللي الجافاسكريبت هيسمعه
        return 'juz-reserved';
    }
}
