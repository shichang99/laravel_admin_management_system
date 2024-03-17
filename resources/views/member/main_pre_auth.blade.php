<?php echo view( 'member/header', [ 'header' => @$header ] );?>

    
    @if ( @$templateStyle )
    <div class="{{ $templateStyle }} relative">
    @else
    <div class="bg-default relative">
    @endif

        @if ( @$re_link )
    
            <!-- Top Nav ( Mobile ) -->
            <nav class="onlymob top-nav">

                <div class="flex-items-center">
                    <!-- Redirect Back -->
                    <a  href="{{ $re_link }}" class="flex-items-center">
                        <i class="icon-icon1 header-icon--001 mr-[0.4rem]"></i>
                        <span class="header-text--001">
                            Create Account
                        </span>
                    </a>
                    <!-- END Redirect Back -->

                    <!-- Language Buttons ( Mobile ) -->
                    <div class="ml-auto">
                        <a class="flex-items-center btn--mob-header-language" data-toggle="modal" data-target="#language-modal">
                            <i class="icon-icon15 mr-[0.313rem] header-icon--001"></i>
                            <span class="header-text--002">ENG</span>
                            <i class="icon-icon3 ml-[0.375rem] header-icon--002"></i>
                        </a>
                    </div>
                    <!-- END Language Buttons ( Mobile ) -->

                </div>

            </nav>

            <!-- Top Nav ( Web ) -->
            <nav class="onlyweb web-top-nav">

                <div class="flex-items-center">
                    <!-- Redirect Back -->
                    <div class="w-[25%]">
                        <a href="{{ $re_link }}" class="btn--web-back-direct">
                            <i class="icon-icon1 header-icon--001"></i>
                        </a>
                    </div>
                    <!-- END Redirect Back -->

                    <!-- Page Title -->
                    <div class="w-[50%] text-center">
                        <span class="header-text--001">
                            Create Account
                        </span>
                    </div>
                    <!-- END Page Title -->

                    <!-- Language Buttons ( Web ) -->
                    <div class="w-[25%] flex-items-center justify-right">
                        <a class="ml-auto flex-items-center btn--web-header-language" data-toggle="modal" data-target="#language-modal">
                            <i class="icon-icon15 mr-[0.313rem] header-icon--001"></i>
                            <span class="header-text--002">English</span>
                            <i class="icon-icon3 ml-[0.375rem] header-icon--002"></i>
                        </a>
                    </div>
                    <!-- END Language Buttons ( Web ) -->
                    
                </div>

            </nav>
        @else
            <!-- Top Nav ( Mobile ) -->
            <!--nav class="onlymob">
                
            </nav-->   

            <!-- Top Nav ( Web ) -->
            <!--nav class="onlyweb">

            </nav-->

        @endif

        <div>
            <!-- Popups that needed every page -->
            <?php echo view( 'member/elements/popup/language' ); ?>
            <?php echo view( 'member/elements/popup/success' ); ?>
            <?php echo view( 'member/elements/popup/success_direct' ); ?>
            <?php echo view( 'member/elements/popup/fail' ); ?>
            
            <!-- END Popups that needed every page -->

            <?php echo view( $content, [ 'data' => @$data ] ); ?>

            <!-- Copyright -->
            <div class="pb-[1.75rem] pt-[1rem] text-center text--copyright">
                © {{date('Y')}} . {{ __('ms.website_name') }} . {{ __('ms.all_rights_reserved') }}
            </div>
            <!-- END Copyright -->
        </div>
        
        
        
        
        
    </div>
        
        
       

<?php echo view( 'member/footer' ); ?>