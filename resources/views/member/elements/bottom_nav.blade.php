<!-- Bottom Nav -->
<div class="onlymob bottom-nav">
    <div class="flex-items-center justify-center">
        <a class="bottom-nav-options" href="{{ route( 'home' ) }}">
            <i class="icon-icon7"></i>
            <div class="mt-[0.1rem] label-bottom-nav">{{ __('ms.home') }}</div>
        </a>
        <a class="bottom-nav-options" href="{{ route( 'member.investment_history' ) }}">
            <i class="icon-icon9"></i>
            <div class="mt-[0.1rem] label-bottom-nav">{{ __('ms.investment') }}</div>
        </a>
        <a class="bottom-nav-options" href="{{ route( 'member.wallet' ) }}">
            <i class="icon-icon8"></i>
            <div class="mt-[0.1rem] label-bottom-nav">{{ __('ms.wallet') }}</div>
        </a>
        <a class="bottom-nav-options" href="{{ route( 'member.profile' ) }}">
            <i class="icon-icon10"></i>
            <div class="mt-[0.1rem] label-bottom-nav">{{ __('ms.profile') }}</div>
        </a>
    </div>
</div>