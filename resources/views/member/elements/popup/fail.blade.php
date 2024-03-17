
<!-- Modal -->
<div class="modal fade" id="fail-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">

    <div class="modal-content-boxx">

      <!-- Modal Header -->
      <div class="flex-items-center modal-header-new">
        <span>Register Account</span>
        <i class="ml-auto icon-icon22 modal-close-i" data-dismiss="modal" aria-label="Close"></i>
      </div>
      
        <!-- Modal Content -->
        <div class="modal-content-new">

            <div class="text-center modal-fail">
                <!-- Image -->
                <img src="{{ asset( 'member/Element/BG 19.png?v=' ) }}{{ date('Y-m-d-H:i:s') }}" alt="Success Logo" class="w-[2.5rem] h-auto inline mb-[1rem]">

                <!--  Modal Message Header -->
                <div class="mb-[0.3rem] modal-subject" id="modal_subject">
                    Fail Registration
                </div>

                <!--  Modal Message Desc -->
                <div class="leading-[1.29] modal-desc" id="modal_desc">
                    Network lost connection
                </div>
            </div>
                        
        

            <div class="text-center pt-[1.5rem]">
                <button class="btn--submit" data-dismiss="modal">
                {{ __('member.try_again') }}
                </button>
            </div>
            

            

        </div>
    </div>

  </div>
</div>
