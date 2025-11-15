<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // [LATIHAN 6]
use App\Exports\ApplicationsExport;     // [LATIHAN 7]
use Maatwebsite\Excel\Facades\Excel;    // [LATIHAN 7]
use App\Models\JobVacancy; 

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $jobId)
    {
        // Ambil aplikasi berdasarkan lowongan tertentu
        $applications = Application::with('user', 'job')
                                    ->where('job_id', $jobId)
                                    ->latest()
                                    ->paginate(10); // Tambahkan paginate

        return view('applications.index', compact('applications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $jobId)
    {
        // Hanya user biasa
        if (auth()->user()->role === 'admin') {
            abort(403);
        }

        $request->validate([
            'cv' => 'required|mimes:pdf|max:2048',
        ]);

        // Cek apakah user sudah melamar
        $existingApplication = Application::where('user_id', auth()->id())
                                        ->where('job_id', $jobId)
                                        ->exists();

        if ($existingApplication) {
            return back()->with('error', 'Anda sudah melamar di lowongan ini.');
        }

        $cvPath = $request->file('cv')->store('cvs','public');

        Application::create([
            'user_id' => auth()->id(),
            'job_id' => $jobId,
            'cv' => $cvPath,
            'status' => 'Pending' // Sesuai Latihan 1
        ]);

        return redirect()->route('jobs.index')->with('success', 'Lamaran berhasil dikirim!');
    }

// ... existing code ...
    public function show(string $id)
    {
        //
    }

// ... existing code ...
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * [LATIHAN 1 & 5] Menerima/Menolak lamaran
     */
    public function update(Request $request, Application $application)
    {
        // Hanya admin
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:Accepted,Rejected'
        ]);

        $application->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status lamaran diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        // Hanya admin
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        // Hapus file CV dari storage
        if (Storage::disk('public')->exists($application->cv)) {
            Storage::disk('public')->delete($application->cv);
        }

        $application->delete();
        return back()->with('success', 'Lamaran berhasil dihapus.');
    }

    /**
     * [LATIHAN 7] Export data pelamar per lowongan.
     */
    public function export($jobId)
    {
        // Ambil data job untuk nama file
        // [PERBAIKAN] Ganti \App\Models\Job menjadi JobVacancy
        $job = JobVacancy::findOrFail($jobId);
        $fileName = 'pelamar_' . str_replace(' ', '_', $job->title) . '.xlsx';

        return Excel::download(new ApplicationsExport($jobId), $fileName);
    }

    /**
     * [LATIHAN 6] Download CV pelamar.
     */
    public function downloadCV(Application $application)
    {
        // Pastikan admin atau user ybs
        if (auth()->user()->role !== 'admin' && auth()->id() !== $application->user_id) {
            abort(403);
        }

        // Pastikan file ada
        if (!Storage::disk('public')->exists($application->cv)) {
            abort(404, 'File CV tidak ditemukan.');
        }

        // Gunakan Storage::download untuk memaksa download
        return Storage::disk('public')->download($application->cv);
    }
}