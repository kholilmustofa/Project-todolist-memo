<?php

namespace App\Http\Controllers;

use App\Models\Mylist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MylistController extends Controller
{
    /**
     * Display a listing of the user's lists.
     * Menampilkan daftar list milik pengguna.
     */
    public function index()
    {
        // Ambil semua daftar milik user yang sedang login, diurutkan berdasarkan nama
        $mylists = Auth::user()->mylists()->orderBy('name')->get();
        return response()->json($mylists);
    }

    /**
     * Store a newly created list in storage.
     * Menyimpan list baru yang dibuat.
     */
    public function store(Request $request)
    {
        $request->validate([
            // Nama list harus ada, berupa string, maksimal 255 karakter,
            // dan unik untuk user_id yang sama (tidak boleh ada nama list yang sama untuk satu user)
            'name' => 'required|string|max:255|unique:mylists,name,NULL,id,user_id,' . Auth::id(),
        ]);

        // Buat list baru dan kaitkan dengan user yang sedang login
        $mylist = Auth::user()->mylists()->create([
            'name' => $request->name,
        ]);

        // Kembalikan respons JSON dengan list yang baru dibuat
        return response()->json($mylist, 201);
    }

    // Anda bisa menambahkan metode update dan destroy di sini nanti jika diperlukan
}
