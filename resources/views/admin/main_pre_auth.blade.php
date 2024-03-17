<?php echo view( 'admin/header', [ 'header' => @$header ] );?>

<?php echo view( $content, [ 'data' => @$data ] ); ?>

<?php echo view( 'admin/footer' ); ?>