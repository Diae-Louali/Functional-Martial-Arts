<?php 
 session_start();

 if(isset($_SESSION['Connected-UserID'])){
     header('Content-type: application/json');
     echo json_encode($_SESSION);
 } else {
     echo '0';
 }

 ?>