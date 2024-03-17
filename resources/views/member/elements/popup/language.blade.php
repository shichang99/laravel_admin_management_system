
<!-- Modal -->
<div class="modal fade" id="language-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">

    <div class="modal-content-boxx">

      <!-- Modal Header -->
      <div class="flex-items-center modal-header-new">
        <span>{{ __( 'ms.language_settings' ) }}</span>
        <i class="ml-auto icon-icon22 modal-close-i" data-dismiss="modal" aria-label="Close"></i>
      </div>
      
      <!-- Modal Content -->
      <div class="modal-content-new">

        <form action="">

          <a href="{{ Helper::baseUrl() }}/lang/en">
            <div class="flex-items-center modal--language-options bolded">
              <span>English</span>
              <i class="ml-auto icon-icon20"></i>
            </div>
          </a>  
          

          <a href="{{ Helper::baseUrl() }}/lang/zh">    
            <div class="flex-items-center modal--language-options">
              <span>简体中文</span>
              <i class="ml-auto icon-icon20"></i>
            </div>
          </a>


          <div class="text-center pt-[1.5rem]">
            <button class="btn--submit" type="submit">
              {{ __('member.confirm') }}
            </button>
          </div>
          

        </form>

      </div>
    </div>

  </div>
</div>
