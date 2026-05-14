@extends('layouts.app')

@section('title', 'Denah Sekolah')

@section('content')
    <div class="space-y-8">
        <!-- Header Section -->
        <div class="relative overflow-hidden p-8 rounded-[2.5rem] bg-gradient-to-br from-slate-900 to-slate-800 text-white shadow-2xl shadow-slate-200">
            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-primary-500/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-48 h-48 bg-blue-500/10 rounded-full blur-3xl"></div>
            
            <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h1 class="text-3xl font-extrabold tracking-tight mb-2 flex items-center gap-3">
                        <span class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-md border border-white/10">
                            <i class="fas fa-map text-primary-400"></i>
                        </span>
                        Denah Sekolah
                    </h1>
                    <p class="text-slate-400 font-medium max-w-md">
                        Visualisasi tata letak gedung dan ruangan di SMKN 1 Katapang untuk memudahkan navigasi.
                    </p>
                </div>
                
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('floor-plans.create') }}" class="group flex items-center gap-3 px-6 py-3 bg-primary-600 hover:bg-primary-500 text-white rounded-2xl transition-all duration-300 font-bold text-sm shadow-lg shadow-primary-900/20">
                        <i class="fas fa-plus group-hover:rotate-90 transition-transform"></i>
                        Tambah Denah
                    </a>
                @endif
            </div>
        </div>


    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-3 animate-in fade-in duration-500">
            <i class="fas fa-check-circle text-emerald-500"></i>
            <p class="text-sm font-bold text-emerald-700">{{ session('success') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($floorPlans as $plan)
            <div class="group bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden hover:shadow-2xl hover:shadow-slate-200/50 transition-all duration-500 hover:-translate-y-2">
                <!-- Image/PDF Container -->
                <div class="relative h-64 overflow-hidden bg-slate-100 flex items-center justify-center">
                    @php $extension = pathinfo($plan->image, PATHINFO_EXTENSION); @endphp
                    
                    @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png']))
                        <img src="{{ asset('storage/' . $plan->image) }}" alt="{{ $plan->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    @else
                        <!-- PDF Icon -->
                        <div class="flex flex-col items-center justify-center text-rose-500">
                            <i class="fas fa-file-pdf text-6xl mb-2"></i>
                            <span class="text-xs font-bold uppercase tracking-widest text-slate-400">Dokumen PDF</span>
                        </div>
                    @endif
                    
                    <!-- Overlay Actions -->
                    <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-3">
                        <a href="{{ asset('storage/' . $plan->image) }}" target="_blank" class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center text-white hover:bg-white/40 transition-all">
                            <i class="{{ in_array(strtolower($extension), ['jpg', 'jpeg', 'png']) ? 'fas fa-expand' : 'fas fa-eye' }}"></i>
                        </a>
                        <a href="{{ route('floor-plans.download', $plan) }}" class="w-12 h-12 rounded-2xl bg-primary-600 flex items-center justify-center text-white hover:bg-primary-700 transition-all shadow-lg shadow-primary-500/20">
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                </div>

                <!-- Info -->
                <div class="p-8">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-xl font-bold text-slate-800 tracking-tight">{{ $plan->title }}</h3>
                        <div class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">
                            {{ $plan->created_at->diffForHumans() }}
                        </div>
                    </div>
                    
                    @if($plan->description)
                        <p class="text-slate-500 text-sm leading-relaxed mb-6 line-clamp-2">{{ $plan->description }}</p>
                    @endif

                    @if(Auth::user()->role === 'admin')
                        <div class="flex items-center gap-2 pt-4 border-t border-slate-50">
                            <a href="{{ route('floor-plans.edit', $plan) }}" class="flex-1 px-4 py-2 bg-amber-50 text-amber-600 font-bold text-xs rounded-xl hover:bg-amber-100 transition-all text-center">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <form action="{{ route('floor-plans.destroy', $plan) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full px-4 py-2 bg-rose-50 text-rose-600 font-bold text-xs rounded-xl hover:bg-rose-100 transition-all" onclick="return confirm('Yakin ingin menghapus denah ini?')">
                                    <i class="fas fa-trash mr-1"></i> Hapus
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 bg-white rounded-[3rem] border border-slate-100 border-dashed flex flex-col items-center justify-center text-center px-6">
                <div class="w-24 h-24 rounded-full bg-slate-50 text-slate-200 flex items-center justify-center mb-6">
                    <i class="fas fa-map-marked-alt text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 mb-2">Belum Ada Denah</h3>
                <p class="text-slate-500 max-w-sm">Denah sekolah belum ditambahkan oleh administrator.</p>
                
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('floor-plans.create') }}" class="mt-8 px-8 py-3 bg-primary-600 text-white font-bold rounded-2xl hover:bg-primary-700 transition-all shadow-lg shadow-primary-200">
                        Tambah Denah Pertama
                    </a>
                @endif
            </div>
        @endforelse
        </div>
    </div>
@endsection

