
<!-- Modal -->
<div class="modal fade" id="notification-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">

    <div class="modal-content-boxx">

      <!-- Modal Header -->
      <div class="flex-items-center modal-header-new">
        <span>{{ __('ms.notification') }}</span>
        <i class="ml-auto icon-icon22 modal-close-i" data-dismiss="modal" aria-label="Close"></i>
      </div>
      
        <!-- Modal Content -->
        <div class="modal-content-new">

            <div class="text-center modal-success">
                
                <!--  Modal Message Header -->
                <div class="mt-[2rem] mb-[0.3rem] modal-subject" id="modal_subject">
                  {{@$data['latest_announcement']->title}}
                </div>

                <!--  Modal Message Desc -->
                <div class="leading-[1.29] modal-desc" id="modal_desc">
                {{@$data['latest_announcement']->message}}
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
