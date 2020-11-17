<?php  
require("../../MasterPHPFMA.php");

$error = '';
    
    $id = $_POST['comment_ID'];
    $sql = "UPDATE comments_and_replies SET comment_status=? WHERE comment_ID=?";
    $req = $conn->prepare($sql);
    $req->execute(array($_POST['comment_status'], $id));
    $error = '<label class="text-success">Comment reported</label>';


    $data = array(
        'error'  => $error,
       );
       
       echo json_encode($data);
       
       ?>