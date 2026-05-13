@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Notifikasi</h1>
            <p class="text-slate-500 text-sm">Kelola permintaan reset password dan pemberitahuan sistem lainnya.</p>
        </div>
        @if(Auth::user()->unreadNotifications->count() > 0)
            <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 transition-all font-medium text-sm shadow-sm">
                    <i class="fas fa-check-double text-primary-500"></i>
                    Tandai Semua Sudah Dibaca
                </button>
            </form>
        @endif
    </div>

    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
        @if($notifications->isEmpty())
            <div class="p-12 text-center">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-bell-slash text-slate-300 text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-800">Belum ada notifikasi</h3>
                <p class="text-slate-500">Semua permintaan akan muncul di sini.</p>
            </div>
        @else
            <div class="divide-y divide-slate-100">
                @foreach($notifications as $notification)
                    <div class="p-6 transition-colors hover:bg-slate-50/50 flex items-start gap-4 {{ $notification->read_at ? 'opacity-75' : '' }}">
                        <div class="flex-shrink-0 w-12 h-12 rounded-2xl {{ $notification->read_at ? 'bg-slate-100 text-slate-400' : 'bg-primary-50 text-primary-600 shadow-sm shadow-primary-100' }} flex items-center justify-center">
                            @if($notification->data['type'] ?? '' === 'password_reset')
                                <i class="fas fa-key text-lg"></i>
                            @else
                                <i class="fas fa-bell text-lg"></i>
                            @endif
                        </div>
                        
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <p class="font-bold text-slate-800 truncate">
                                    {{ $notification->data['type'] === 'password_reset' ? 'Permintaan Reset Password' : 'Pemberitahuan Sistem' }}
                                </p>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest whitespace-nowrap">
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <p class="text-slate-600 text-sm mb-4 leading-relaxed">
                                {{ $notification->data['message'] }}
                            </p>
                            
                            <div class="flex items-center gap-3">
                                @if($notification->data['type'] === 'password_reset')
                                    <a href="{{ $notification->data['action_url'] }}" class="text-xs font-bold px-3 py-1.5 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                                        Reset Password Sekarang
                                    </a>
                                @endif
                                
                                @if(!$notification->read_at)
                                    <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-xs font-bold text-primary-600 hover:text-primary-700">
                                            Tandai Sudah Dibaca
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" onsubmit="return confirm('Hapus notifikasi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-bold text-rose-500 hover:text-rose-600">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        @if(!$notification->read_at)
                            <div class="flex-shrink-0">
                                <div class="w-2 h-2 bg-primary-600 rounded-full"></div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            
            @if($notifications->hasPages())
                <div class="p-6 border-t border-slate-100 bg-slate-50/50">
                    {{ $notifications->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
