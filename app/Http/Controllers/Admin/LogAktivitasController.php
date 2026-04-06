<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
    public function index(Request $request)
    {
        $logs = LogAktivitas::with('user')
                    ->orderBy('created_at', 'desc')
                    ->paginate(20);
        
        return view('admin.log-aktivitas.index', compact('logs'));
    }
    
    public function destroy($id)
    {
        $log = LogAktivitas::findOrFail($id);
        $log->delete();
        
        return redirect()->route('admin.log-aktivitas.index')
            ->with('success', 'Log berhasil dihapus');
    }
}