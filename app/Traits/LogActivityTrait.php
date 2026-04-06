<?php

namespace App\Traits;

use App\Models\LogAktivitas;

trait LogActivityTrait
{
    public function logActivity($aktivitas, $tabelTerkait)
    {
        LogAktivitas::create([
            'user_id' => auth()->id(),
            'aktivitas' => $aktivitas,
            'tabel_terkait' => $tabelTerkait,
        ]);
    }
}