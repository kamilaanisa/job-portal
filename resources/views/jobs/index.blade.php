{{-- Halaman Index Lowongan (Daftar Lowongan) --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Lowongan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(Auth::user()->role === 'admin')
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium text-gray-700 mb-4">Panel Admin</h3>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('jobs.create') }}"
                               class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Tambah Lowongan Baru
                            </a>

                            <a href="{{ route('jobs.template') }}"
                               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Download Template Import
                            </a>
                        </div>
                        
                        <form action="{{ route('jobs.import') }}" method="POST" enctype="multipart/form-data" class="mt-6 border-t pt-6">
                            @csrf
                            <label class="block text-sm font-medium text-gray-700">Import Lowongan dari Excel</label>
                            <div class="mt-1 flex items-center gap-2">
                                <input type="file" name="file" required class="text-sm text-gray-700 file:mr-2 file:py-1 file:px-2 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500">
                                    Import
                                </button>
                            </div>
                            @error('file')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </form>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-700 mb-4">
                        Kelola lowongan kerja yang tersedia.
                    </h3>
                    
                    <div class="space-y-4">
                        @forelse ($jobs as $job)
                            <div class="border p-4 rounded-lg flex justify-between items-center">
                                <div>
                                    <h4 class="text-xl font-semibold text-indigo-600">{{ $job->title }}</h4>
                                    <p class="text-sm text-gray-600">{{ $job->company ?? 'N/A' }} - {{ $job->location ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-800 font-medium mt-1">
                                        Gaji: Rp {{ number_format($job->salary ?? 0, 0, ',', '.') }}
                                    </p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('jobs.show', $job->id) }}" class="inline-flex items-center px-3 py-1 border border-transparent rounded-md shadow-sm text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                                        Lihat Detail
                                    </a>

                                    @if(Auth::user()->role === 'admin')
                                        <a href="{{ route('applications.index', $job->id) }}" class="inline-flex items-center px-3 py-1 border border-gray-300 rounded-md shadow-sm text-xs font-medium text-gray-700 bg-yellow-100 hover:bg-yellow-200">
                                            Lihat Pelamar
                                        </a>

                                        <a href="{{ route('jobs.edit', $job->id) }}" class="inline-flex items-center px-3 py-1 border border-gray-300 rounded-md shadow-sm text-xs font-medium text-gray-700 bg-white hover:bg-gray-50">
                                            Edit
                                        </a>
                                        <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus lowongan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1 border border-transparent rounded-md shadow-sm text-xs font-medium text-white bg-red-600 hover:bg-red-700">
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500">
                                Belum ada lowongan yang tersedia.
                                @if(Auth::user()->role === 'admin')
                                    Silakan tambahkan lowongan baru.
                                @endif
                            </p>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $jobs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
```eof