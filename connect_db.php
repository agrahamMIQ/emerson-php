<?php
function db_connect() {
    mysql_connect( 'localhost', 'root', '' );
    @mysql_select_db( 'emerson_tt' ) or die( "Unable to connect to database" );
    return true;
}

function db_insert_data( $data ) {
    $error = "";
    $dbcon = db_connect();
    if( $dbcon === true ) {
        $values = "";
        foreach( $data as $key => $value ) {
            foreach( $value as $option => $val ) {
                $values .= "( '', $key, '$val' ),";
            }
            unset( $option );
        }
        unset( $key );
        
        $values = substr( $values, 0, -1 ); //clean trailing comma
        
        $query = "INSERT INTO options VALUES $values";
        $result = mysql_query( $query );
        if (!$result) {
            $errorresponse = json_encode( array( 'response' => 'error', 'contents' => array( 'mysqlerror' => mysql_error(), 'query' => $query ) ) );
            die( $errorresponse );
        } else {
            $successresponse = json_encode( array( 'response' => 'success', 'contents' => array( 'query' => $query ) ) );
            return $successresponse;
        }
    }
    
    mysql_close();
    mysql_free_result( $result );
}

function db_select() {
    $dbcon = db_connect();
    if( $dbcon === true ) {
        $query = "SELECT options.option, (COUNT(options.option)* 100 / (SELECT COUNT(options.option) FROM options)) as Shelf1 FROM options WHERE shelf = 1 GROUP BY options.option";
        $result = mysql_query( $query );
        while ($row = mysql_fetch_assoc($result)) {
            echo $row['option'];
        }
    } else {
        //error
    }
    mysql_close();
}

?>