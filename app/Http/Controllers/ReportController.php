<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use App\Models\Schedule;
use App\Exports\BorrowersExport;
use App\Exports\SchedulesExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function borrowersPdf()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            $borrowers = Borrower::with('room')->get();
        } elseif ($user->role === 'sarpras') {
            $borrowers = Borrower::whereHas('room', function ($query) {
                $query->where('category_id', 1);
            })->with('room')->get();
        } else {
            $borrowers = Borrower::whereHas('room', function ($query) use ($user) {
                $query->where('category_id', $user->category_id);
            })->with('room')->get();
        }

        $pdf = Pdf::loadView('reports.borrowers', compact('borrowers'));
        return $pdf->download('laporan-peminjam-' . now()->format('Y-m-d') . '.pdf');
    }

    public function borrowersExcel()
    {
        return Excel::download(new BorrowersExport, 'laporan-peminjam-' . now()->format('Y-m-d') . '.xlsx');
    }

    public function schedulesPdf()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            $schedules = Schedule::with('room')->get();
        } else {
            $schedules = Schedule::whereHas('room', function ($query) use ($user) {
                $query->where('category_id', $user->category_id);
            })->with('room')->get();
        }

        $pdf = Pdf::loadView('reports.schedules', compact('schedules'));
        return $pdf->download('laporan-jadwal-' . now()->format('Y-m-d') . '.pdf');
    }

    public function schedulesExcel()
    {
        return Excel::download(new SchedulesExport, 'laporan-jadwal-' . now()->format('Y-m-d') . '.xlsx');
    }
}
