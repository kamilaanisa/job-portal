<?php

namespace App\Http\Controllers;

// UBAH: Gunakan Model JobVacancy
use App\Models\JobVacancy;
use Illuminate\Http\Request;
use App\Exports\JobsTemplateExport;
use App\Imports\JobsImport;
use Maatwebsite\Excel\Facades\Excel;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // UBAH: Ambil data dari JobVacancy
        $jobs = JobVacancy::latest()->paginate(10);
        return view('jobs.index', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }
        return view('jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|numeric',
        ]);

        // UBAH: Buat data di JobVacancy
        JobVacancy::create($validated);
        return redirect()->route('jobs.index')->with('success', 'Lowongan baru berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id) // UBAH: Gunakan $id
    {
        // UBAH: Cari manual
        $job = JobVacancy::findOrFail($id);
        return view('jobs.show', compact('job'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id) // UBAH: Gunakan $id
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }
        // UBAH: Cari manual
        $job = JobVacancy::findOrFail($id);
        return view('jobs.edit', compact('job'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) // UBAH: Gunakan $id
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        // UBAH: Cari manual
        $job = JobVacancy::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|numeric',
        ]);

        $job->update($validated);
        return redirect()->route('jobs.index')->with('success', 'Lowongan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
     public function destroy($id) // UBAH: Gunakan $id
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }
        
        // UBAH: Cari manual
        $job = JobVacancy::findOrFail($id);
        $job->delete();
        return redirect()->route('jobs.index')->with('success', 'Lowongan berhasil dihapus.');
    }

    /**
     * Import data lowongan.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        Excel::import(new JobsImport, $request->file('file'));

        return back()->with('success', 'Data lowongan berhasil diimport!');
    }

    /**
     * Download template Excel untuk import.
     */
    public function downloadTemplate()
    {
        return Excel::download(new JobsTemplateExport, 'jobs_template.xlsx');
    }
}