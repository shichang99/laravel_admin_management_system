<?php echo view( 'member/header', [ 'header' => @$header ] );?>

    <!-- Web Navigation -->
    @if ( @$templateStyle )
    <div class="{{ $templateStyle }} relative member-page-temp">
    @else
    <div class="bg-default relative member-page-temp">
    @endif
        <!-- Left -->
        <?php echo view( 'member/elements/site_nav', [ 'data' => @$data, 'sidebarBold' => @$sidebarBold ] ); ?>
        

        <!-- Right -->
        <div class="relative member-page-content">
            
            <!-- Top Navigation Bar ( Web ) -->
            <nav class="onlyweb web--top-navi">
                <div class="flex-items-center">
                    <div class="w-[30%]">

                    </div>
                    <div class="w-[40%] text-center">
                        <div class="page-header">{{ $title }}</div>
                    </div>
                    <div class="w-[30%]">
                        <div class="w-[100%] flex-items-center">

                            <div class="ml-auto flex-items-center site-btn" style="border-right: solid 1px #fff;">
                                <i class="icon-icon10 mr-[0.312rem] ico-page"></i>
                                <span class="usernames">{{Auth::user()->name}}</span>
                            </div>

                            <div class="flex-items-center site-btn" data-toggle="modal" data-target="#language-modal">
                                <i class="mr-[0.313rem] icon-icon10 ico-page"></i>
                                <span class="mr-[0.375rem] language-short">{{ __('ms.lang_key_long') }}</span>
                                <i class="icon-icon3 language-i"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            @if ( @$re_link )

            <!-- Top Navigation Bar ( Mobile ) -->
            <nav class="onlymob mob--top-nav-01">
                <div class="flex-items-center">
                    <a href="{{ isset( $re_link ) ? $re_link : '#' }}"><i class="icon-icon1 back-nav mr-[0.75rem]"></i></a>
                    <span class="leading-[1.78] header-navv">{{ $title }}</span>

                    @if ( @$userInfo )
                    <div class="ml-auto flex-items-center page-profile">
                        <i class="icon-icon10 mr-[0.312rem] page-profile-i"></i>
                        <span class="page-profile-span">{{Auth::user()->name}}</span>
                    </div>
                    @endif
                </div>
                
            </nav>

            @else

            <!-- Top Navigation Bar ( Mobile ) -->
            <nav class="onlymob member--top-nav {{ @$home ? 'home' : '' }}">
                <div class="flex-items-center w-[100%]">
                    <span class="leading-[1.78] page-title">{{ $title }}</span>

                    @if ( @$userInfo )
                    <div class="ml-auto flex-items-center">
                        <i class="icon-icon10 mr-[0.312rem] page-profile-i"></i>
                        <span class="page-profile-span">{{Auth::user()->name}}</span>
                    </div>
                    @endif

                    @if ( @$logoutBtn )
                    <!-- Floating Logout Button ( Mob ) -->
                    <div class="fadeInLeft onlymob default--logout-float logout_">
                        <div class="flex-items-center">
                            <i class="icon-icon42 mr-[0.313rem] header-icon--001"></i>
                            <span class="header-text--002 mr-[0.6rem] lg:mr[5rem]">{{ __('ms.logout') }}</span>
                        </div>
                    </div>
                    <!-- END Floating Logout Button -->   
                    @endif
                    
                </div>
            </nav>

            @endif

            <form id="logout_form" action="{{ route('member.logout') }}" method="POST">
                @csrf
            </form>


            <div class="web-content-inner">
                <!-- Popups that needed every page -->
                <?php echo view( 'member/elements/popup/date_filter' ); ?>
                <?php echo view( 'member/elements/popup/language' ); ?>
                <?php echo view( 'member/elements/popup/success' ); ?>
                <?php echo view( 'member/elements/popup/fail' ); ?>
                <?php echo view( 'member/elements/popup/comingsoon' ); ?>
                <?php echo view( 'member/elements/popup/contactus', [ 'data' => @$data ] ); ?>
            
                <?php echo view( $content, [ 'data' => @$data ] ); ?>
            </div>

            @if ( @$bottom_nav )
            <!-- IF Not Back Direct / Show Bottom Nav -->
            <?php echo view( 'member/elements/bottom_nav' ); ?>
            @endif
            

        </div>

    </div>
    

<?php echo view( 'member/footer' ); ?>