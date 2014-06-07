<?php
include_once 'SimpleImage.php';
if ( !empty( $_FILES ) ) {

    $tempPath = $_FILES[ 'file' ][ 'tmp_name' ];
    $uploadPath = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $_FILES[ 'file' ][ 'name' ];

    move_uploaded_file( $tempPath, $uploadPath );

    $answer = array( 'answer' => 'File transfer completed' );
    $json = json_encode( $answer );
    $name=$_FILES[ 'file' ][ 'name' ];
    //$name="4f.jpg";
    imgEgitor($name);
    

    echo $json;

} else {

    echo 'No files';

}

function imgEgitor($name)
{
    try {
    $img = new abeautifulsite\SimpleImage('uploads/'.$name);
    $img->flip('x')->rotate(90)->best_fit(320, 200)->sepia()->save('img/'.$name);
    } catch(Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}