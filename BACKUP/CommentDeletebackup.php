<?php

//add_comment.php

require("MasterPHPFMA.php");

$error = '';
$is_empty ="...";
date_default_timezone_set('Africa/Casablanca');
$date = date('Y/m/d H:i:s', time());

$selectQuery = "SELECT * FROM comments_and_replies WHERE parent_comment_ID = ?";
    $statement = $conn->prepare($selectQuery);
    $statement->execute(array($_POST["comment_ID"]));
$result = $statement->fetchAll();
if (!count($result)) { ////IF THERE ARE NO OTHER COMMENTS(ARRAYS) THAT HAVE  [PARENT_ID  = POSTED COMMENT_ID],     
////DELETE THE COMMENT THAT MATCHED THE ID GIVEN BY POST:
    $sql = "DELETE FROM comments_and_replies WHERE comment_ID=?";
    $req = $conn->prepare($sql);
    $req->execute(array($_POST["comment_ID"]));
    $error = '<label class="text-success">Comment Deleted</label>';

////DELETE ALL COMMENTS WICH HAVE A DELETE STATE OF 1 IF THEY HAVE NO CHILD
    $selectQuery1 = "SELECT * FROM comments_and_replies WHERE parent_comment_ID = ?";
    $statement1 = $conn->prepare($selectQuery1);
    $statement1->execute(array($_POST["parent_comment_ID"]));
    $result1 = $statement1->fetchAll();

    if (count($result1) == 0) {
        
    $sql1 = "DELETE FROM comments_and_replies WHERE deleted_parent=? AND comment_ID=?";
    $req = $conn->prepare($sql1);
    $req->execute(array(1, $_POST["parent_comment_ID"]));
    $error = '<label class="text-success">IT WORKED</label>';
    } else {
        $error = '<label class="text-success">IT DIDNT WORK</label>';

    }

} else { // IF THERE ARE OTHER COMMENTS(ARRAYS) THAT HAVE A [PARENT_ID  =  POSTED COMMENT_ID],
    $sql = "UPDATE comments_and_replies SET deleted_parent=?, comment_updated_at=? WHERE comment_ID=?";
    $req = $conn->prepare($sql);
    $req->execute(array(1, $date, $_POST["comment_ID"]));
    $error = '<label class="text-success">Comment with children Deleted</label>';
}











// SELECT ALL PARENTS WHO HAVE DELETE STATE OF 1
    $selectAllQuery = "SELECT * FROM comments_and_replies WHERE deleted_parent=?";
    $statement = $conn->prepare($selectAllQuery);
    $statement->execute(array(1));
    $result2 = $statement->fetchAll();
while (count($result2) > 0) {
    
}










$data = array(
 'error'  => $error,
 'CrntTime' => $date,
);

echo json_encode(count($result2));

?>