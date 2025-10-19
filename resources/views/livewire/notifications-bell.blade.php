<li class="nav-item dropdown nav-item-box">
    <a href="javascript:void(0);" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
        <span wire:ignore>
            <i data-feather="bell"></i>
        </span>
        @if($unreadCount > 0)
            <span class="badge rounded-pill">{{ $unreadCount }}</span>
        @endif
    </a>
    <div class="dropdown-menu notifications">
        <div class="topnav-dropdown-header">
            <span class="notification-title">Notifications</span>
            <a href="javascript:void(0)" wire:click.prevent="clearAll" class="clear-noti"> Marquer tout comme lu </a>
        </div>
        <div class="noti-content">
            <ul class="notification-list">
                @forelse ($notifications as $notification)
                    <li class="notification-message {{ is_null($notification->read_at) ? 'notification-unread' : '' }}">
                        <a href="#" wire:click.prevent="markAsRead('{{ $notification->id }}')">
                            <div class="media d-flex">
                                <span class="avatar flex-shrink-0">
                                    {{-- Idéalement, une icône en fonction du type de notif --}}
                                    <i class="fa fa-box-open fa-2x text-warning"></i>
                                </span>
                                <div class="media-body flex-grow-1">
                                    {{-- On accède aux données stockées en BDD --}}
                                    <p class="noti-details">
                                        <span class="noti-title">{{ $notification->data['message'] }}</span>
                                    </p>
                                    <p class="noti-time">
                                        <span class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
                                    </p>
                                </div>
                            </div>
                        </a>
                    </li>
                @empty
                    <li class="notification-message">
                        <div class="media d-flex">
                            <div class="media-body flex-grow-1">
                                <p class="text-center text-muted p-3">Aucune nouvelle notification</p>
                            </div>
                        </div>
                    </li>
                @endforelse
            </ul>
        </div>
        <div class="topnav-dropdown-footer">
            <a href="#">Voir toutes les notifications</a>
        </div>
    </div>
</li>