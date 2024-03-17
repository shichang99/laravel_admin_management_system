
<!-- Modal -->
<div class="modal fade" id="success-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">

    <div class="modal-content-boxx">

      <!-- Modal Header -->
      <div class="flex-items-center modal-header-new">
        <span id="modal_header">Register Account</span>
        <i class="ml-auto icon-icon22 modal-close-i" data-dismiss="modal" aria-label="Close"></i>
      </div>
      
        <!-- Modal Content -->
        <div class="modal-content-new">

            <div class="text-center modal-success">
                <!-- Image -->
                <img src="{{ asset( 'member/Element/BG 18.png?v=' ) }}{{ date('Y-m-d-H:i:s') }}" alt="Success Logo" class="w-[2.5rem] h-auto inline mb-[1rem]">

                <!--  Modal Message Header -->
                <div class="mb-[0.3rem] modal-subject" id="modal_subject">
                    Succeessful Registration
                </div>

                <!--  Modal Message Desc -->
                <div class="leading-[1.29] modal-desc" id="modal_desc">
                    You successful create an account via phone No.(+6018 888 8888)
                </div>
            </div>
                        
        

            <div class="text-center pt-[1.5rem]">
                <button class="btn--submit" data-dismiss="modal">
                {{ __('member.confirm') }}
                </button>
            </div>
            

            

        </div>
    </div>

  </div>
</div>
