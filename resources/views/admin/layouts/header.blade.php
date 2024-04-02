<header class="header-main">
    <section class="sidebar-header bg-gray">
        <section class="d-flex justify-content-between flex-md-row-reverse px-2">
            <span id="sidebar-toggle-show" class="d-inline d-md-none pointer"><i class="fas fa-toggle-off"></i></span>
            <span id="sidebar-toggle-hide" class="d-none d-md-inline pointer"><i class="fas fa-toggle-on"></i></span>
            <span><a href="{{ route('home.index') }}" target="_blank"><img class="logo"
                        src="{{ asset('admin-assets/images/kalanetlogo.png') }}" width="120" alt=""></a></span>
            <span class="d-md-none" id="menu-toggle"><i class="fas fa-ellipsis-h"></i></span>
        </section>
    </section>
    <section class="body-header" id="body-header">
        <section class="d-flex justify-content-between">
            <section>
                <span class="mr-5">
                    <span id="search-area" class="search-area d-none">
                        <i id="search-area-hide" class="fas fa-times pointer"></i>
                        <input id="search-input" type="text" class="search-input">
                        <i class="fas fa-search pointer"></i>
                    </span>
                    <i id="search-toggle" class="fas fa-search p-1 d-none d-md-inline pointer"></i>
                </span>

                <span id="full-screen" class="pointer p-1 d-none d-md-inline mr-5">
                    <i id="screen-compress" class="fas fa-compress d-none"></i>
                    <i id="screen-expand" class="fas fa-expand "></i>
                </span>
            </section>
            <section>
                <span class="ml-2 ml-md-4 position-relative">
                    <span id="header-notification-toggle" class="pointer">
                        <i class="far fa-bell"></i><sup class="badge badge-danger">{{ $messages->count() }}</sup>
                    </span>
                    <section id="header-notification" class="header-notifictation rounded">
                        <section class="d-flex justify-content-between">
                            <span class="px-2">
                                تیکت ها
                            </span>
                            <span class="px-2">
                                @if ($messages->count() > 0)
                                    <span class="badge badge-danger">جدید</span>
                                @endif
                            </span>
                        </section>

                        @forelse ($messages as $message)
                            <ul class="list-group rounded px-0">
                                <a href="{{ route('admin.ticket.messages', $message->ticket) }}"
                                    class="text-decoration-none">
                                    <li class="list-group-item list-group-item-action">
                                        <section class="media">
                                            @if ($message->user->profile_path)
                                                <img class="notification-img"
                                                    src="{{ asset($message->user->profile_path) }}" alt="avatar">
                                            @endif
                                            <section class="media-body pr-1">
                                                <h5 class="notification-user">{{ $message->user->name ?? '-' }}</h5>
                                                <p class="notification-text">
                                                    {{ Str::limit($message->message, 20, '...') }}
                                                </p>
                                                <p class="notification-time">{{ getAgo($message->created_at) }}</p>
                                            </section>
                                        </section>
                                    </li>
                                </a>
                            </ul>
                        @empty
                            <div class="alert alert-success mx-2 text-center" role="alert">
                               <small><strong>لیست تیکت ها خالی است</strong></small>
                            </div>
                        @endforelse
                    </section>
                </span>
                {{-- <span class="ml-2 ml-md-4 position-relative">
                    <span id="header-comment-toggle" class="pointer">
                        <i class="far fa-comment-alt">
                            <sup class="badge badge-danger">
                                5
                            </sup>
                        </i>
                    </span>

                    <section id="header-comment" class="header-comment">

                        <section class="border-bottom px-4">
                            <input type="text" class="form-control form-control-sm my-4" placeholder="جستجو ...">
                        </section>

                        <section class="header-comment-wrapper">
                            <ul class="list-group rounded px-0">

                                <li class="list-group-item list-groupt-item-action">
                                    <section class="media">
                                        <img src="{{ asset('admin-assets/images/avatar-2.jpg') }}" alt="avatar"
                                            class="notification-img">
                                        <section class="media-body pr-1">
                                            <section class="d-flex justify-content-between">
                                                <h5 class="comment-user">حبیب الله پورمحمدی</h5>
                                                <span><i
                                                        class="fas fa-circle text-success comment-user-status"></i></span>
                                            </section>
                                        </section>
                                    </section>
                                </li>
                            </ul>
                        </section>

                    </section>

                </span> --}}
                <span class="ml-3 ml-md-5 position-relative">
                    <span id="header-profile-toggle" class="pointer">
                        @if (auth()->user()->profile_path)
                            <img class="header-avatar" src="{{ asset(auth()->user()->profile_path ?? '') }}"
                                alt="">
                        @endif
                        <span class="header-username">{{ auth()->user()->name ?? '' }}</span>
                        <i class="fas fa-angle-down"></i>
                    </span>
                    <section id="header-profile" class="header-profile rounded">
                        <section class="list-group rounded">
                            <a href="{{ route('home.profile.myProfile.index') }}"
                                class="list-group-item list-group-item-action header-profile-link">
                                <i class="fas fa-cog"></i>تنظیمات
                            </a>
                            {{-- <a href="#" class="list-group-item list-group-item-action header-profile-link">
                                <i class="fas fa-user"></i>کاربر
                            </a> --}}
                            {{-- <a href="#" class="list-group-item list-group-item-action header-profile-link">
                                <i class="far fa-envelope"></i>پیام ها
                            </a> --}}
                            {{-- <a href="#" class="list-group-item list-group-item-action header-profile-link">
                                <i class="fas fa-lock"></i>قفل صفحه
                            </a> --}}
                            <a href="{{ route('home.auth.logout') }}"
                                class="list-group-item list-group-item-action header-profile-link">
                                <i class="fas fa-sign-out-alt"></i>خروج
                            </a>
                        </section>
                    </section>
                </span>
            </section>
        </section>
    </section>
</header>
