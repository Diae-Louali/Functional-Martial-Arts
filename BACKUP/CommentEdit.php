<?php

//add_comment.php

require("MasterPHPFMA.php");

$error = '';
$comment_user_ID = '';
$comment_content = '';
$articleID=1;
date_default_timezone_set('Africa/Casablanca');
$date = date('Y/m/d H:i:s', time());


if(empty($_POST["user_ID"]))
{
 $error .= '<p class="text-danger">Login is required</p>';
}
else
{
 $comment_user_ID = $_POST["user_ID"];
}

if(empty($_POST["updated_comment"]))
{
 $error .= '<p class="text-danger">Comment is required</p>';
 
}
else
{
 $comment_content = $_POST["updated_comment"];
}
if($error == '')
{
   $sql = "UPDATE comments_and_replies SET comment_content=?, comment_updated_at=? WHERE comment_ID=?";
   $req = $conn->prepare($sql);
   $req->execute(array($_POST["updated_comment"], $date, $_POST["comment_ID"]));
   $error = '<label class="text-success">Comment Edited</label>';
}

$data = array(
 'error'  => $error,
 'CrntTime' => $date
);

echo json_encode($data);

?>