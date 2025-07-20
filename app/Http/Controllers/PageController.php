<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // <<< PASTIKAN INI DIIMPOR

class PageController extends Controller
{
    /**
     * Menampilkan halaman 'Myday' dengan task hari ini.
     */
    public function myday()
    {
        // Mengambil task untuk user yang sedang login dengan due_date hari ini.
        // Eager load the 'mylist' relationship.
        // Catatan: myday.blade.php Anda saat ini menggunakan AJAX untuk fetch tasks,
        // jadi data 'tasks' yang dilewatkan di sini mungkin hanya untuk inisialisasi awal
        // atau jika Anda ingin menggunakannya sebagai fallback.
        $tasks = Auth::user()->tasks()
            ->with('mylist') // <<< EAGER LOAD RELASI MYLIST
            ->whereDate('due_date', today())
            ->latest() // Urutkan berdasarkan yang terbaru
            ->get();

        return view('myday', compact('tasks'));
    }

    /**
     * Menampilkan halaman 'All My Tasks' dengan task yang dikategorikan.
     */
    public function allmytasks()
    {
        $user = Auth::user();
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();

        // Ambil task untuk 'Today'
        $todayTasks = $user->tasks()
            ->with('mylist') // <<< EAGER LOAD RELASI MYLIST
            ->whereDate('due_date', $today)
            ->latest()
            ->get();

        // Ambil task untuk 'Tomorrow'
        $tomorrowTasks = $user->tasks()
            ->with('mylist') // <<< EAGER LOAD RELASI MYLIST
            ->whereDate('due_date', $tomorrow)
            ->latest()
            ->get();

        // Ambil task untuk 'Upcoming' (setelah besok)
        $upcomingTasks = $user->tasks()
            ->with('mylist') // <<< EAGER LOAD RELASI MYLIST
            ->whereDate('due_date', '>', $tomorrow)
            ->latest()
            ->get();

        // Dapatkan task terbaru dari task hari ini untuk detail panel
        // Mengambil task pertama dari koleksi todayTasks yang sudah diurutkan terbaru
        $latestTask = $todayTasks->first(); 

        return view('allmytasks', compact('todayTasks', 'tomorrowTasks', 'upcomingTasks', 'latestTask'));
    }
}
