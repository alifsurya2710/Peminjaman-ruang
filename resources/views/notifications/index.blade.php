@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="relative overflow-hidden p-8 rounded-[2.5rem] bg-gradient-to-br from-slate-900 to-slate-800 text-white shadow-2xl shadow-slate-200">
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-primary-500/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-48 h-48 bg-rose-500/10 rounded-full blur-3xl"></div>
        
        <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight mb-2 flex items-center gap-3">
                    <span class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-md border border-white/10">
                        <i class="fas fa-bell text-primary-400"></i>
                    </span>
                    Notifikasi
                </h1>
                <p class="text-slate-400 font-medium max-w-md">
                    Pantau semua aktivitas, permintaan reset password, dan pembaruan sistem dalam satu tempat yang terorganisir.
                </p>
            </div>
            
            @if(Auth::user()->unreadNotifications->count() > 0)
                <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                    @csrf
                    <button type="submit" class="group flex items-center gap-3 px-6 py-3 bg-white/10 hover:bg-white/20 border border-white/10 text-white rounded-2xl transition-all duration-300 font-bold text-sm backdrop-blur-md">
                        <i class="fas fa-check-double text-primary-400 group-hover:scale-110 transition-transform"></i>
                        Tandai Semua Sudah Dibaca
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Notification List -->
    <div class="grid gap-4">
        @if($notifications->isEmpty())
            <div class="bg-white/60 backdrop-blur-xl rounded-[2.5rem] border border-slate-100 shadow-sm p-16 text-center">
                <div class="w-24 h-24 bg-slate-50 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-inner ring-4 ring-slate-50">
                    <i class="fas fa-bell-slash text-slate-300 text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Hening Sekali di Sini...</h3>
                <p class="text-slate-500 max-w-xs mx-auto">
                    Belum ada notifikasi baru untuk Anda. Kami akan memberitahu jika ada sesuatu yang penting!
                </p>
            </div>
        @else
            @foreach($notifications as $notification)
                <div class="group relative bg-white/80 backdrop-blur-xl rounded-[2rem] border border-slate-100 p-6 transition-all duration-300 hover:shadow-xl hover:shadow-slate-200/50 hover:border-primary-100 hover:-translate-y-1 {{ $notification->read_at ? 'opacity-80' : 'ring-2 ring-primary-50' }}">
                    <div class="flex flex-col md:flex-row gap-6">
                        <!-- Icon Column -->
                        <div class="flex-shrink-0">
                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center shadow-lg transition-transform duration-500 group-hover:rotate-6 {{ $notification->read_at ? 'bg-slate-100 text-slate-400 shadow-slate-100' : 'bg-gradient-to-br from-primary-500 to-primary-600 text-white shadow-primary-200' }}">
                                @if($notification->data['type'] === 'password_reset')
                                    <i class="fas fa-key text-xl"></i>
                                @else
                                    <i class="fas fa-info-circle text-xl"></i>
                                @endif
                            </div>
                        </div>

                        <!-- Content Column -->
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center justify-between gap-3 mb-2">
                                <div class="flex items-center gap-3">
                                    <h4 class="text-lg font-bold text-slate-800">
                                        {{ $notification->data['type'] === 'password_reset' ? 'Permintaan Reset Password' : 'Pemberitahuan Sistem' }}
                                    </h4>
                                    @if(!$notification->read_at)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-primary-100 text-primary-700 uppercase tracking-wider animate-pulse">
                                            Baru
                                        </span>
                                    @endif
                                </div>
                                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest bg-slate-50 px-3 py-1 rounded-full border border-slate-100">
                                    <i class="far fa-clock mr-1"></i>
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>
                            </div>

                            <p class="text-slate-600 leading-relaxed mb-6">
                                {{ $notification->data['message'] }}
                            </p>

                            <div class="flex flex-wrap items-center gap-3">
                                @if($notification->data['type'] === 'password_reset')
                                    <a href="{{ $notification->data['action_url'] }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition-all shadow-lg shadow-primary-100 font-bold text-sm">
                                        <i class="fas fa-shield-alt"></i>
                                        Reset Password Sekarang
                                    </a>
                                @endif

                                @if(!$notification->read_at)
                                    <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 transition-all font-bold text-sm shadow-sm flex items-center gap-2">
                                            <i class="fas fa-check text-primary-500"></i>
                                            Tandai Selesai
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" onsubmit="return confirm('Hapus notifikasi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-5 py-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-100 transition-all font-bold text-sm flex items-center gap-2 group/delete">
                                        <i class="fas fa-trash-alt group-hover/delete:shake"></i>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Status Indicator -->
                        @if(!$notification->read_at)
                            <div class="absolute top-6 right-6 hidden md:block">
                                <div class="relative flex h-3 w-3">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-primary-500 shadow-sm shadow-primary-200"></span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
            
            @if($notifications->hasPages())
                <div class="mt-8 p-6 bg-white/40 backdrop-blur-md rounded-[2rem] border border-slate-100">
                    {{ $notifications->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
