    <script src="{{ asset( 'admin/js/core.js' ) . Helper::assetVersion() }}"></script>
    <script src="{{ asset( 'admin/js/lucide.min.js' ) . Helper::assetVersion() }}"></script>
    <script src="{{ asset( 'admin/js/template.js' ) . Helper::assetVersion() }}"></script>
    <script src="{{ asset( 'admin/js/jquery.dataTables.min.js' ) . Helper::assetVersion() }}"></script>
    <script src="{{ asset( 'admin/js/dataTables.bootstrap5.min.js' ) . Helper::assetVersion() }}"></script>
    <script src="{{ asset( 'admin/js/moment-with-locales.js' ) . Helper::assetVersion() }}"></script>
    <script src="{{ asset( 'admin/js/flatpickr.js' ) . Helper::assetVersion() }}"></script>
    <script src="https://cdn.datatables.net/select/1.5.0/js/dataTables.select.min.js"></script>

    <script>
        lucide.createIcons();

        document.addEventListener( 'DOMContentLoaded', function() {

            $( document ).on( 'focus', '.form-control', function() {
                if ( $( this ).hasClass( 'is-invalid' ) ) {
                    $( this ).removeClass( 'is-invalid' ).next().text( '' );
                }
            } );

            $( document ).on( 'focus', '.form-select', function() {
                if ( $( this ).hasClass( 'is-invalid' ) ) {
                    $( this ).removeClass( 'is-invalid' ).next().text( '' );
                }
            } );

            $( document ).on( 'hidden.bs.offcanvas', '.offcanvas-right', function() {
                $( '.offcanvas-body .form-control' ).removeClass( 'is-invalid' ).val( '' );
                $( '.invalid-feedback' ).text( '' );
                $( '.offcanvas-body .form-select' ).removeClass( 'is-invalid' ).val( '' );
            } );

            $( document ).on( 'hidden.bs.modal', '.modal', function() {
                $( '.modal .form-control.form-control-sm' ).removeClass( 'is-invalid' ).val( '' ).next().text( '' );
            } );

            setTimeout( function() {
                $( '.alert' ).fadeTo( 250, 0.01, function() { 
                    $( this ).slideUp( 50, function() {
                        $( this ).remove();
                    } ); 
                } );
            }, 2500 );
        } );
    </script>
</body>

</html>