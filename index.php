<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Emerson - Toy Taxonomy</title>
</head>
<body>
<?php
$json = json_encode( array( 1 => array( 'blocks', 'dolls' ), 2 => array( 'balls', 'planes' ) ) );

if( isset( $json ) ) { //testing
    $json = json_decode( $json );
    
//if( isset( $_POST['json'] ) ) {
    //$json = json_decode( $_POST['json'] );
    $error = array();
    
    /* Check JSON */
    if( empty( $json ) ) {
        $error[] = 'No JSON data supplied.';
    } else {
        foreach( $json as $key => $value ) {
            if( empty( $value ) ) {
                $error[] = "Shelf $key has no Options supplied. ";
            } else if( count( $value ) > 4 ) {
                $error[] = "Shelf $key has more than 4 Options supplied. ";
            }
        }
        unset( $key );
        
        if( empty( $error ) ) {
            require_once 'connect_db.php';
            //$response = db_insert_data( $json );
            //echo $response;
            db_select();
        }
    }
    
} else { //return error
    $failresponse = json_encode( array( 'response' => 'error', 'contents' => $error ) );
    echo $failresponse;
}

?>
</body>
</html>