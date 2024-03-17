
<!-- Modal -->
<div class="modal fade" id="contactus-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">

    <div class="modal-content-boxx">

      <!-- Modal Header -->
      <div class="flex-items-center modal-header-new">
        <span id="modal_header">{{ __('ms.contact_us') }}</span>
        <i class="ml-auto icon-icon22 modal-close-i" data-dismiss="modal" aria-label="Close"></i>
      </div>
      
        <!-- Modal Content -->
        <div class="modal-content-new">

            <div class="text-center modal-success">

              <!-- Reminder -->
              <div class="reminder-03 mb-[1rem]">
                {{ __('ms.contactus_reminder_pop') }}
              </div>

              <div class="contactus-cover">
                <!-- Image -->
                @if ( isset( $data['CUSTOMER_URL'] ) )
                <div  class="p-1">{!! QrCode::size(100)->generate($data['CUSTOMER_URL'])!!}</div>
                @endif
                @if(1==2)
                <img src="" alt="Success Logo" class="cs-img w-[6.8rem] h-auto inline">
                @endif
              </div>
              
            </div>
                        
        

            <div class="text-center pt-[1.5rem]">

                <a href="{{$data['CUSTOMER_URL']}}"><button class="btn--submit pl-[1rem] pr-[1rem]">
                  {{ __('member.redirect_cs') }}
                </button></a>
            </div>
            

            

        </div>
    </div>

  </div>
</div>
