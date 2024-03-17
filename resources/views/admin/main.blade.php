<?php echo view( 'admin/header', [ 'header' => @$header ] );?>
    
    <div class="main-wrapper">

        <?php echo view( 'admin/sidebar', [ 'controller' => @$controller, 'action' => @$action ] ); ?>

        <div class="page-wrapper">
            <?php echo view( 'admin/navbar' ); ?>

            <div class="page-content">

                @if ( @$breadcrumb )
                <nav class="page-breadcrumb">
                    <ol class="breadcrumb">
                        @foreach ( $breadcrumb as $bs )
                        <li class="breadcrumb-item {{ $bs['class'] }}">
                            @if ( $bs['url'] )
                            <a href="{{ $bs['url'] }}">{{ $bs['text'] }}</a>
                            @else
                            {{ $bs['text'] }}
                            @endif
                        </li>
                        @endforeach
                    </ol>
                </nav>
                @endif

                <!-- Here load respective page -->
                <?php echo view( $content, [ 'data' => @$data ] ); ?>
            </div>

            <footer class="footer d-flex flex-column flex-md-row align-items-center justify-content-between px-4 py-3 border-top small">
				<p class="text-muted mb-1 mb-md-0">Copyright © {{ date( 'Y' ) }} <a href="#" target="_blank">{{ Helper::websiteName() }}</a>.</p>
				<!--p class="text-muted">Handcrafted With <i class="mb-1 text-primary ms-1 icon-sm" icon-name="heart"></i></p-->
			</footer>
        </div>
    </div>

    <?php echo view( 'admin/footer' ); ?>