            <nav class="navbar">
                <a href="#" class="sidebar-toggler">
                <i icon-name="menu"></i>
                </a>
                <div class="navbar-content">
                    <form class="search-form" style="display: none!important;">
                        <div class="input-group">
                            <div class="input-group-text">
                                <i icon-name="search"></i>
                            </div>
                            <input type="text" class="form-control" id="navbarForm" placeholder="Search here...">
                        </div>
                    </form>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <?php
                            $localeMapper = [
                                'en' => 'gb',
                                'zh' => 'cn',
                            ];
                            ?>
                            <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="flag-icon flag-icon-{{ $localeMapper[App::getLocale()] }} mt-1" title="{{ $localeMapper[App::getLocale()] }}"></i> <span class="ms-1 me-1 d-none d-md-inline-block">{{ Config::get('languages')[App::getLocale()] }}</span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="languageDropdown">
@foreach ( Config::get( 'languages' ) as $lang => $language )
@if ( $lang != App::getLocale() )
                            <a href="{{ Helper::baseAdminUrl() }}/lang/{{ $lang }}" class="dropdown-item py-2"><i class="flag-icon flag-icon-{{ $localeMapper[$lang] }}" title="us" id="us"></i> <span class="ms-1"> {{ $language }} </span></a>
@endif
@endforeach
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="wd-30 ht-30 rounded-circle" src="https://eu.ui-avatars.com/api/?name={{ auth()->user()->name }}&size=30" alt="profile">
                            </a>
                            <div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
                                <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
                                    <div class="mb-3">
                                        <img class="wd-80 ht-80 rounded-circle" src="https://eu.ui-avatars.com/api/?name={{ auth()->user()->name }}&size=80" alt="">
                                    </div>
                                    <div class="text-center">
                                        <p class="tx-16 fw-bolder">{{ auth()->user()->name }}</p>
                                        <p class="tx-12 text-muted">{{ auth()->user()->email }}</p>
                                    </div>
                                </div>
                                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST">
                                    @csrf
                                </form>
                                <ul class="list-unstyled p-1">
                                    <li class="dropdown-item py-2" onclick="event.preventDefault(); document.getElementById( 'logout-form' ).submit();">
                                        <a href="{{ route('admin.logout') }}" class="text-body ms-0">
                                        <i class="me-2 icon-md" icon-name="log-out"></i>
                                        <span>{{ __( 'template.logout' ) }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>