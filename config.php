<?php
if (!defined('BASE_URL')) {
    define('BASE_URL','http://localhost/project/');
}


$conn= mysqli_connect("localhost","root","","add_to_cart");
if($conn==false){
    echo " connection is not done";
}


?>