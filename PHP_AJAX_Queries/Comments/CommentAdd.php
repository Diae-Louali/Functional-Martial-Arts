<?php

//add_comment.php

require("../../MasterPHPFMA.php");

$error = '';
$comment_user_ID = '';
$comment_content = '';
$childState='';


if(empty($_POST["user_ID"]))
{
 $error .= '<p class="text-danger">Login is required</p>';
}
else
{
 $comment_user_ID = $_POST["user_ID"];
}

if(empty($_POST["comment_content"]))
{
 $error .= '<p class="text-danger">Comment is required</p>';
 
}
else
{
 $comment_content = $_POST["comment_content"];
}


if($error == '')
{
     
 $query = "
 INSERT INTO comments_and_replies 
 (parent_comment_ID, user_ID, article_ID, comment_content) 
 VALUES (:parent_comment_id, :comment_sender_id, :articleID, :comment)
 ";
 $statement = $conn->prepare($query);
 $statement->execute(
  array(
   ':parent_comment_id' => $_POST["parent_ID"],
   ':comment'    => $comment_content,
   ':comment_sender_id' => $comment_user_ID,
   ':articleID' => $_POST['article_ID']
  )
 );
 $error = '<label class="text-success">Comment Added</label>';
}

$data = array(
 'error'  => $error
);

echo json_encode($data);

?>