
<?php echo view( 'member/elements/toast' ); ?>


<script>

    /*document.addEventListener( 'DOMContentLoaded', function() {

        $( document ).on( 'click', '.logout_', function() {
            $( '#logout_form' ).submit();
        } );

        $( document ).on( 'hidden.bs.modal', '#notification-modal', function() {
            
            $.ajax( {
                url: '{{ route( 'member.announcement_read' ) }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function() {
                    console.log( 'ok' );
                }
            } );
        } );
    } );*/


    function viewPassword(id,e)
    {
        if($('#'+id).attr('type') == 'password')
        {
            $('#'+id).attr('type','text');
            $(e).attr('class','icon-icon5 opened-eye');
        }else{
            $('#'+id).attr('type','password');
            $(e).attr('class','icon-icon6 closed-eye');
        }
    }
    
    
    function launch_toast(msg) {
        $('#toast').find('#desc').html(msg);
        var x = document.getElementById("toast")
        x.className = "show";
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 5000);
    }

    function open_modal(modal)
    {
        $('#'+modal).modal('show');
    }
    function copy_clipboard(value, object, msg='Successfully')
    {
        var temp = $( '<input>' );

        $( 'body' ).append( temp );
        temp.val( value ).select();
        temp[0].setSelectionRange( 0, 99999 );
        document.execCommand( 'copy' );
        temp.remove();
        
        $('#'+object).css( 'opacity' , '0.5');
        launch_toast(msg);
        setTimeout(function(e){
            
            $('#'+object).css( 'opacity' , '1');
        }, 3000);

    }
</script>



</body>

</html>