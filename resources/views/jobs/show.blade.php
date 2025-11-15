{{-- Halaman Detail Lowongan --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Lowongan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Pesan Error/Sukses -->
                    @if (session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <!-- Informasi Lowongan -->
                    <h3 class="text-2xl font-semibold text-indigo-700">{{ $job->title }}</h3>
                    <p class="text-md text-gray-700 mt-1">{{ $job->company }}</p>
                    <p class="text-sm text-gray-500">{{ $job->location }}</p>
                    <p class="text-lg text-gray-800 font-medium mt-2">
                        Gaji: Rp {{ number_format($job->salary, 0, ',', '.') }}
                    </p>

                    <div class="mt-6 border-t pt-6">
                        <h4 class="text-lg font-medium">Deskripsi Pekerjaan</h4>
                        <div class="mt-2 text-gray-700">
                            {!! nl2br(e($job->description)) !!}
                        </div>
                    </div>

                    <!-- [LATIHAN 3] Form Lamaran (Hanya untuk User) -->
                    @if(Auth::user()->role !== 'admin')
                        <div class="mt-6 border-t pt-6">
                            <h4 class="text-lg font-medium">Lamar Pekerjaan Ini</h4>
                            
                            <form action="{{ route('apply.store', $job->id) }}" method="POST" enctype="multipart/form-data" class="mt-4">
                                @csrf
                                <label for="cv" class="block text-sm font-medium text-gray-700">Upload CV Anda (PDF, maks 2MB)</label>
                                <div class="mt-1 flex items-center gap-2">
                                    <input type="file" name="cv" id="cv" required class="text-sm text-gray-700 file:mr-2 file:py-1 file:px-2 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                    
                                    <button type="submit" 
                                            class="ml-2 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                        Kirim Lamaran
                                    </button>
                                </div>
                                @error('cv')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </form>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>