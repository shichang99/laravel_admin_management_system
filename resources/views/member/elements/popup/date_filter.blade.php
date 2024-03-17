
<!-- Modal -->
<div class="modal fade" id="filter-date-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">

    <div class="modal-content-boxx">

      <!-- Modal Header -->
      <div class="flex-items-center modal-header-new">
        <span>{{ __('ms.filter') }}</span>
        <i class="ml-auto icon-icon22 modal-close-i" data-dismiss="modal" aria-label="Close"></i>
      </div>
      
      <!-- Modal Content -->
      <div class="modal-content-new">

        <form action="">
          
          <!-- Start Date -->
          <div class="text--008 mb-[0.313rem] ml-[1.25rem]">{{ __('member.start_date') }}</div>
          <div class="relative form-input-box mb-[1.5rem]">

            <input 
              type="date"
              id="datePicker_start"
              placeholder="Select Start Date"
              name="start_date"
              value="{{ request()->start_date }}"
            />
            
            
          </div>

          <!-- End Date -->
          <div class="text--008 mb-[0.313rem] ml-[1.25rem]">{{ __('member.end_date') }}</div>
          <div class="relative form-input-box mb-[1.5rem]">

            <input 
              type="date"
              id="datePicker_end"
              placeholder="Select End Date"
              name="end_date"
              value="{{ request()->end_date }}"
            />
            
           
          </div>
          

          <div class="text-center pt-[1.5rem]">
            <button class="btn--submit" type="submit">
              {{ __('member.apply_filter') }}
            </button>
          </div>
          

        </form>

      </div>
    </div>

  </div>
</div>

