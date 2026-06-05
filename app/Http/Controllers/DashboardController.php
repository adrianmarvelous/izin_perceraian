<?php

namespace App\Http\Controllers;

use App\Models\IzinPerceraian;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Statistik umum
        $totalPegawai = Pegawai::count();

        // Statistik per OPD (hanya OPD user jika bukan admin)
        if ($user->hasRole('admin')) {
            $pegawaiPerOpd = Pegawai::selectRaw('opd, COUNT(*) as total')
                ->whereNotNull('opd')
                ->where('opd', '!=', '')
                ->groupBy('opd')
                ->orderByDesc('total')
                ->limit(10)
                ->get();

            $statusPeg = Pegawai::selectRaw('status_peg, COUNT(*) as total')
                ->whereNotNull('status_peg')
                ->groupBy('status_peg')
                ->orderByDesc('total')
                ->get();

            $jkStats = Pegawai::selectRaw('jk, COUNT(*) as total')
                ->groupBy('jk')
                ->get();

            $agamaStats = Pegawai::selectRaw('agama, COUNT(*) as total')
                ->whereNotNull('agama')
                ->groupBy('agama')
                ->orderByDesc('total')
                ->get();

            $izinCount = IzinPerceraian::count();
        } else {
            $pegawaiPerOpd = collect();
            $statusPeg = Pegawai::selectRaw('status_peg, COUNT(*) as total')
                ->where('opd', $user->name)
                ->whereNotNull('status_peg')
                ->groupBy('status_peg')
                ->orderByDesc('total')
                ->get();

            $jkStats = Pegawai::selectRaw('jk, COUNT(*) as total')
                ->where('opd', $user->name)
                ->groupBy('jk')
                ->get();

            $agamaStats = Pegawai::selectRaw('agama, COUNT(*) as total')
                ->where('opd', $user->name)
                ->whereNotNull('agama')
                ->groupBy('agama')
                ->orderByDesc('total')
                ->get();

            $totalPegawai = Pegawai::where('opd', $user->name)->count();

            $izinCount = IzinPerceraian::whereHas('pegawai', function ($q) use ($user) {
                $q->where('opd', $user->name);
            })->count();
        }

        // 5 user terbaru
        $latestUsers = User::latest()->limit(5)->get();

        return view('dashboard', compact(
            'totalPegawai',
            'pegawaiPerOpd',
            'statusPeg',
            'jkStats',
            'agamaStats',
            'izinCount',
            'latestUsers'
        ));
    }
}
