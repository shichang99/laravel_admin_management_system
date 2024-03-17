<section class="flex-items-center justify-center content-04">
    <div class="text-center">
        <!-- Image -->
        <!-- <img src="{{ asset( 'member/Element/BG 02.png?v=' ) }}{{ date( 'Y-m-d-H:i:s' ) }}" alt="Success Logo" class="cs-img w-[20rem] h-auto inline mb-[1.23rem]"> -->

        <div class="text--024 mb-[1rem]">
            {{ __( 'member.under_maintenance_subject' ) }}
        </div>

        <div class="text--025 leading-[1.77]">
            {!! $data['maintenance'] ? $data['maintenance']->content : __( 'member.under_maintenance_message' ) !!}
        </div>
    </div>
</section>