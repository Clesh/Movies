<?php
include_once 'SimpleImage.php';
function imgEgitor($name)
{
    try {
    $img = new abeautifulsite\SimpleImage('uploads/'.$name);
    $img->flip('x')->rotate(90)->best_fit(320, 200)->sepia()->save('img/'.$name);
    } catch(Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
