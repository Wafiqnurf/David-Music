<?php
namespace App\Http\Controllers;

use App\Models\Course;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * Note: Jangan gunakan middleware auth di constructor
     * karena homepage harus bisa diakses tanpa login
     */
    public function __construct()
    {
        // Hapus atau comment line ini jika ada:
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard/homepage.
     */
    public function index()
    {
        try {
            // Ambil courses yang aktif untuk ditampilkan di homepage
            $courses = Course::where('is_active', true)->take(6)->get();
        } catch (\Exception $e) {
            // Jika terjadi error atau tabel belum ada, berikan collection kosong
            $courses = collect([]);
        }

        // Pastikan $courses selalu ada, meskipun kosong
        return view('home', compact('courses'));
    }
}
