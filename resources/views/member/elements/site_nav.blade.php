<div class="onlyweb web--site-navi">

    <!-- Logo Image -->
    <div class="text-center pl-[1.8rem] pr-[1.8rem]">
        <img src="{{ asset( 'member/Logo/L01.png?v=' ) }}{{ date('Y-m-d-H:i:s') }}" alt="Logo" class="inline logo-main-nav mb-[2rem]">
    </div>
    

    <!-- Username / User Info -->
    <div class="flex items-start pl-[1.8rem] pr-[1.8rem]">
        <img src="{{ asset( 'member/Ranking' ) }}/{{auth()->user()->rankings->id}}.png?v={{ date('Y-m-d-H:i:s') }}" alt="Ranking" class="w-[3.41rem] h-auto mr-[0.938rem]"/>

        <!-- User Info -->
        <div class="w-[100%]">
            <div class="flex items-start">
                <div>
                    <div class="web--username">{{Auth::user()->name}}</div>
                    <div class="web--phone">{{Auth::user()->details->phone_number}}</div>
                    <div class="mb-[0.268rem] mt-[0.3rem] ranking-nav-box web--ranking">{{Auth::user()->rankings->name}}</div>
                </div>
                <i class="ml-auto mt-[0.3rem] icon-icon27 icon--004"></i>
            </div>
            <div class="web--register-date">{{ __('member.register_date') }} : {{date('d M Y',strtotime(Auth::user()->created_at))}}</div>
        </div>
    </div>


    <!-- Navigator -->
    <div class="pr-[1.25rem] mt-[2.4rem] mb-[3rem]">

        <!-- Options -->
        <a href="{{ route('home') }}">
            <div class="flex-items-center web--navigator {{ @$sidebarBold == 'home' ? 'bolded' : '' }}">
                <div class="w-[20%]">
                    <i class="icon-icon7 icon--navi-represented"></i>
                </div>
                <div class="w-[80%] label-reprsent">
                    {{ __('ms.home') }}
                </div>
                <i class="ml-auto icon-icon2 arrow-represent"></i>
            </div>
        </a>

        <!-- Options -->
        <a  href="{{ route('member.investment_history') }}">
            <div class="flex-items-center web--navigator {{ @$sidebarBold == 'investment' ? 'bolded' : '' }}">
                <div class="w-[20%]">
                    <i class="icon-icon9 icon--navi-represented"></i>
                </div>
                <div class="w-[80%] label-reprsent">
                    {{ __('ms.investment') }}
                </div>
                <i class="ml-auto icon-icon2 arrow-represent"></i>
            </div>
        </a>

        <!-- Options -->
        <a href="{{ route('member.wallet') }}">
            <div class="flex-items-center web--navigator {{ @$sidebarBold == 'assets' ? 'bolded' : '' }}">
                <div class="w-[20%]">
                    <i class="icon-icon8 icon--navi-represented"></i>
                </div>
                <div class="w-[80%] label-reprsent">
                    {{ __('ms.wallet') }}
                </div>
                <i class="ml-auto icon-icon2 arrow-represent"></i>
            </div>
        </a>

        <!-- Options -->
        <a href="{{ route('member.edit_profile') }}">
            <div class="flex-items-center web--navigator {{ @$sidebarBold == 'profile' ? 'bolded' : '' }}">
                <div class="w-[20%]">
                    <i class="icon-icon11 icon--navi-represented"></i>
                </div>
                <div class="w-[80%] label-reprsent">
                    {{ __('ms.profile_detail') }}
                </div>
                <i class="ml-auto icon-icon2 arrow-represent"></i>
            </div>
        </a>

        <!-- Options -->
        <a href="{{ route('member.security_center') }}">
            <div class="flex-items-center web--navigator {{ @$sidebarBold == 'change_password' ? 'bolded' : '' }}">
                <div class="w-[20%]">
                    <i class="icon-icon12 icon--navi-represented"></i>
                </div>
                <div class="w-[80%] label-reprsent">
                    {{ __('ms.change_password') }}
                </div>
                <i class="ml-auto icon-icon2 arrow-represent"></i>
            </div>
        </a>

        <!-- Options -->
        <a href="{{ route('announcement') }}?start=0&draw=1&length=10">
            <div class="flex-items-center web--navigator {{ @$sidebarBold == 'announcement' ? 'bolded' : '' }}">
                <div class="w-[20%]">
                    <i class="icon-icon14 icon--navi-represented"></i>
                </div>
                <div class="w-[80%] label-reprsent">
                    {{ __('ms.notification') }}
                </div>
                <i class="ml-auto icon-icon2 arrow-represent"></i>
            </div>
        </a>

        <!-- Options -->
        <a href="#" data-toggle="modal" data-target="#language-modal">
            <div class="flex-items-center web--navigator">
                <div class="w-[20%]">
                    <i class="icon-icon15 icon--navi-represented"></i>
                </div>
                <div class="w-[80%] label-reprsent">
                    {{ __('ms.language') }}
                </div>
                <i class="ml-auto icon-icon2 arrow-represent"></i>
            </div>
        </a>

        <!-- Options -->
        <a href="{{ route('member.my_team') }}">
            <div class="flex-items-center web--navigator {{ @$sidebarBold == 'my_team' ? 'bolded' : '' }}">
                <div class="w-[20%]">
                    <i class="icon-icon16 icon--navi-represented"></i>
                </div>
                <div class="w-[80%] label-reprsent">
                    {{ __('ms.my_team') }}
                </div>
                <i class="ml-auto icon-icon2 arrow-represent"></i>
            </div>
        </a>

        <!-- Options -->
        <a href="{{ route('member.invitation') }}">
            <div class="flex-items-center web--navigator {{ @$sidebarBold == 'invitation' ? 'bolded' : '' }}">
                <div class="w-[20%]">
                    <i class="icon-icon17 icon--navi-represented"></i>
                </div>
                <div class="w-[80%] label-reprsent">
                    {{ __('ms.invitation') }}
                </div>
                <i class="ml-auto icon-icon2 arrow-represent"></i>
            </div>
        </a>

        <!-- Options -->
        <a href="{{ route('member.usdt_address') }}">
            <div class="flex-items-center web--navigator {{ @$sidebarBold == 'usdt_address' ? 'bolded' : '' }}">
                <div class="w-[20%]">
                    <i class="icon-icon13 icon--navi-represented"></i>
                </div>
                <div class="w-[80%] label-reprsent">
                    {{ __('ms.usdt_address') }}
                </div>
                <i class="ml-auto icon-icon2 arrow-represent"></i>
            </div>
        </a>

        <!-- Options -->
        <a href="#" data-toggle="modal" data-target="#contactus-modal">
            <div class="flex-items-center web--navigator">
                <div class="w-[20%]">
                    <i class="icon-icon19 icon--navi-represented"></i>
                </div>
                <div class="w-[80%] label-reprsent">
                    {{ __('ms.contact_us') }}
                </div>
                <i class="ml-auto icon-icon2 arrow-represent"></i>
            </div>
        </a>

        <!-- Options -->
        <a href="{{ route('member.policy') }}">
            <div class="flex-items-center web--navigator {{ @$sidebarBold == 'policy' ? 'bolded' : '' }}">
                <div class="w-[20%]">
                    <i class="icon-icon18 icon--navi-represented"></i>
                </div>
                <div class="w-[80%] label-reprsent">
                    {{ __('ms.privacy_policy') }}
                </div>
                <i class="ml-auto icon-icon2 arrow-represent"></i>
            </div>
        </a>

        <!-- Options -->
        <a class="logout_">
            <div class="flex-items-center web--navigator">
                <div class="w-[20%]">
                    <i class="icon-icon42 icon--navi-represented"></i>
                </div>
                <div class="w-[80%] label-reprsent">
                    {{ __('ms.logout') }}
                </div>
                <i class="ml-auto icon-icon2 arrow-represent"></i>
            </div>
        </a>


        

        

        

    </div>


    <!-- Copyright -->
    <div class="pb-[1.75rem] pt-[1rem] text-center text--copyright">
        © 2023 . Golden Crown Group . All Rights Reserved
    </div>
    <!-- END Copyright -->
</div>