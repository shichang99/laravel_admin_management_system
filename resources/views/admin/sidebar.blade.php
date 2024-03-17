        <nav class="sidebar">
            <div class="sidebar-header">
                <a href="#" class="sidebar-brand">
                @if ( 1 == 2 )
                Noble<span>UI</span>
                @endif
                {{ Helper::websiteName() }}
                </a>
                <div class="sidebar-toggler not-active">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
            <div class="sidebar-body">
                <ul class="nav">
                    <li class="nav-item {{ $controller == 'DashboardController' ? 'active' : '' }}">
                        <a href="{{ Helper::baseAdminUrl() }}/dashboard" class="nav-link">
                        <i class="link-icon" icon-name="box"></i>
                        <span class="link-title">{{ __( 'template.dashboard' ) }}</span>
                        </a>
                    </li>
                    @if(Gate::allows( [ 'view announcements' ] ))
                    <li class="nav-item {{ $controller == 'AnnouncementController' ? 'active' : '' }}">
                        <a href="{{ Helper::baseAdminUrl() }}/announcements" class="nav-link">
                        <i class="link-icon" icon-name="megaphone"></i>
                        <span class="link-title">{{ __( 'template.announcements' ) }}</span>
                        </a>
                    </li>
                    @endif
                
                    @if(Gate::allows( [ 'view admins' ] ))
                    <li class="nav-item nav-category">{{ __( 'template.administrator' ) }}</li>
                    <li class="nav-item {{ $controller == 'AdministratorController' ? 'active' : '' }}">
                        <a class="nav-link {{ $controller == 'AdministratorController' ? 'collapsed' : '' }}" data-bs-toggle="collapse" href="#admins" role="button" aria-expanded="{{ $controller == 'AdministratorController' ? 'true' : 'false' }}" aria-controls="admins">
                        <i class="link-icon" icon-name="user"></i>
                        <span class="link-title">{{ __( 'template.administrators' ) }}</span>
                        <i class="link-arrow" icon-name="chevron-down"></i>
                        </a>
                        <div class="collapse {{ $controller == 'AdministratorController' ? 'show' : '' }}" id="admins">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="{{ Helper::baseAdminUrl() }}/administrators" class="nav-link {{ $controller == 'AdministratorController' ? $action == 'index' ? 'active' : '' : '' }}">{{ __( 'template.listing' ) }}</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ Helper::baseAdminUrl() }}/administrators/admin-logs" class="nav-link {{ $controller == 'AdministratorController' ? $action == 'admin-log' ? 'active' : '' : '' }}">{{ __( 'template.admin_logs' ) }}</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @endif
                    @canany ( [ 'view members' ] )
                    <li class="nav-item nav-category">{{ __( 'template.user' ) }}</li>
                    <li class="nav-item {{ $controller == 'MemberController' ? 'active' : '' }}">
                        <a class="nav-link {{ $controller == 'MemberController' ? 'collapsed' : '' }}" data-bs-toggle="collapse" href="#members" role="button" aria-expanded="{{ $controller == 'MemberController' ? 'true' : 'false' }}" aria-controls="members">
                        <i class="link-icon" icon-name="users"></i>
                        <span class="link-title">{{ __( 'template.members' ) }}</span>
                        <i class="link-arrow" icon-name="chevron-down"></i>
                        </a>
                        <div class="collapse {{ $controller == 'MemberController' ? 'show' : '' }}" id="members">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="{{ Helper::baseAdminUrl() }}/members" class="nav-link {{ $controller == 'MemberController' ? $action == 'index' ? 'active' : '' : '' }}">{{ __( 'template.listing' ) }}</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ Helper::baseAdminUrl() }}/members/register" class="nav-link {{ $controller == 'MemberController' ? $action == 'register' ? 'active' : '' : '' }}">{{ __( 'template.register' ) }}</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ Helper::baseAdminUrl() }}/members/groups" class="nav-link {{ $controller == 'MemberController' ? $action == 'group' ? 'active' : '' : '' }}">{{ __( 'template.groups' ) }}</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @endcanany
                    @canany ( [ 'view wallets' ] )
                    <li class="nav-item nav-category">{{ __( 'template.financial' ) }}</li>
                    <li class="nav-item {{ $controller == 'WalletController' ? 'active' : '' }}">
                        <a class="nav-link {{ $controller == 'WalletController' ? 'collapsed' : '' }}" data-bs-toggle="collapse" href="#wallets" role="button" aria-expanded="{{ $controller == 'WalletController' ? 'true' : 'false' }}" aria-controls="wallets">
                        <i class="link-icon" icon-name="users"></i>
                        <span class="link-title">{{ __( 'template.wallets' ) }}</span>
                        <i class="link-arrow" icon-name="chevron-down"></i>
                        </a>
                        <div class="collapse {{ $controller == 'WalletController' ? 'show' : '' }}" id="wallets">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="{{ Helper::baseAdminUrl() }}/wallets" class="nav-link {{ $controller == 'WalletController' ? $action == 'index' ? 'active' : '' : '' }}">{{ __( 'template.listing' ) }}</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ Helper::baseAdminUrl() }}/wallets/statements" class="nav-link {{ $controller == 'WalletController' ? $action == 'statement' ? 'active' : '' : '' }}">{{ __( 'template.statements' ) }}</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ Helper::baseAdminUrl() }}/topups" class="nav-link {{ $controller == 'WalletController' ? $action == 'topup' ? 'active' : '' : '' }}">{{ __( 'template.topups' ) }}</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ Helper::baseAdminUrl() }}/withdrawals" class="nav-link {{ $controller == 'WalletController' ? $action == 'withdrawal' ? 'active' : '' : '' }}">{{ __( 'template.withdrawals' ) }}</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @endcanany

                    <li class="nav-item nav-category">{{ __( 'template.operations' ) }}</li>
                    @if(Gate::allows ( [ 'view company_banks' ] ))
                    <li class="nav-item {{ $controller == 'CompanyBankController' ? 'active' : '' }}">
                        <a href="{{ Helper::baseAdminUrl() }}/company-banks" class="nav-link">
                        <i class="link-icon" icon-name="landmark"></i>
                        <span class="link-title">{{ __( 'template.company_banks' ) }}</span>
                        </a>
                    </li>
                    @endif
                    @if(Gate::allows ( [ 'view settings' ] ))
                    <li class="nav-item {{ $controller == 'SettingController' ? 'active' : '' }}">
                        <a href="{{ Helper::baseAdminUrl() }}/settings" class="nav-link">
                        <i class="link-icon" icon-name="settings"></i>
                        <span class="link-title">{{ __( 'template.settings' ) }}</span>
                        </a>
                    </li>
                    @endif
                    @if(Gate::allows ( [ 'view maintenances' ] ))
                    <li class="nav-item {{ $controller == 'MaintenanceController' ? 'active' : '' }}">
                        <a href="{{ Helper::baseAdminUrl() }}/maintenances" class="nav-link">
                        <i class="link-icon" icon-name="settings-2"></i>
                        <span class="link-title">{{ __( 'template.maintenances' ) }}</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </nav>