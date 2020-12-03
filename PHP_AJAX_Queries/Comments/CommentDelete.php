<?php

//add_comment.php

require("../../MasterPHPFMA.php");

$error = '';
$is_empty ="...";
date_default_timezone_set('Africa/Casablanca');
$date = date('Y/m/d H:i:s', time());

////SELECT ALL COMMENTS THAT ARE CHILDREN OF THE $_POST COMMENT,
$selectQuery = "SELECT * FROM comments_and_replies WHERE parent_comment_ID = ?";
$statement = $conn->prepare($selectQuery);
$statement->execute(array($_POST["comment_ID"]));
$Children = $statement->fetchAll();

if (!count($Children)) { // IF THE COMMENT HAS NO CHILD
    // SELECT PARENT_ID OF THE $_POST COMMENT
    $selectQuery = "SELECT parent_comment_ID FROM comments_and_replies WHERE comment_ID = ? ";
    $statement = $conn->prepare($selectQuery);
    $statement->execute(array($_POST['comment_ID']));
    $parent_id = $statement->fetch(); 

    if ($parent_id!=0) { // IF THE PARENT_ID OF THE $_POST COMMENT IS NOT EQUAL TO 0 (meaning it is the child of another comment) DO THIS :
        
        // SELECT ALL COMMENTS THAT : 
        // 1- HAVE THE SAME PARENT ID OF THE $_POST COMMENT (ARE SIBLINGS)
        // 2- HAVE A DELETE STATE OF 0 (HAVE NOT BEEN REMOVED FROM DISPLAY)
        $selectQuery = "SELECT * FROM comments_and_replies WHERE parent_comment_ID = ? AND deleted_parent=0";
        $statement = $conn->prepare($selectQuery);
        $statement->execute(array($parent_id['parent_comment_ID']));
        $unremovedSiblings = $statement->fetchAll();
        $count = $statement->rowCount();
        
        if ($count == 1) { // IF THERE IS ONLY ONE COMMENT WHICH MEETS THOSE CONDITIONS (IT MEANS THAT IT IS THE $_POST COMMENT, THEREFORE THERE ARE NO UNREMOVED SIBLINGS)   
            // RUN RECURSIVE FUNCTION TO DELETE ALL REMOVED COMMENTS THAT HAVE NO CHILDREN 
            delete_parents($parent_id['parent_comment_ID']); 

            ////DELETE THE COMMENT THE $_POST COMMENT:
            delete_postComment($_POST["comment_ID"]);


        } else{ // ELSE JUST DELETE THE $_POST COMMENT AND DONT RUN THE RECURSIVE FUNCTION          
            delete_postComment($_POST["comment_ID"]);
        }

    } else {
        delete_postComment($_POST["comment_ID"]);
    }

}else{// IF THE COMMENT HAS AT LEAST ONE CHILD

    $sql = "UPDATE comments_and_replies SET deleted_parent=?, comment_updated_at=? WHERE comment_ID=?";
    $req = $conn->prepare($sql);
    $req->execute(array(1, $date, $_POST["comment_ID"]));
    $error = '<label class="text-success">Comment with children Deleted</label>';

}

function delete_postComment($Id_Param) {
    global $conn;
    global $error;
    $sql = "DELETE FROM comments_and_replies WHERE comment_ID=?";
    $req = $conn->prepare($sql);
    $req->execute(array($Id_Param));
    $error = '<label class="text-success">Comment Deleted</label>';
}

function delete_parents($parentId_Param) {
    global $conn;
    $new_parent_id= 0; // RESET VAR
    // GET THE PARENT OF THE CURRENT 'ABOUT TO BE DELETED' COMMENT BY SELECTING
    // ALL COMMENTS THAT HAVE THE SAME COMMENT_ID VALUE AS THE PARENT_ID VALUE 
    // OF THE CURRENT 'ABOUT TO BE DELETED' COMMENT
    $query = "SELECT * FROM comments_and_replies WHERE comment_ID = ".$parentId_Param." ";
    $statement = $conn->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    
    if ($result[0]['deleted_parent']==1) { // CHECK IF PARENT HAS BEEN REMOVED
        $new_parent_id=$result[0]['parent_comment_ID']; // SAVE THAT PARENT'S PARENT_ID 

        // SELECT ALL COMMENTS THAT ARE UNREMOVED SIBLINGS MEANING: 
        // 1- HAVE THE SAME PARENT_ID OF THE CURRENT 'TO BE DELETED' COMMENT
        // 2- HAVE A DELETE STATE OF 0 (HAVE NOT BEEN REMOVED FROM DISPLAY)
        $query = "SELECT * FROM comments_and_replies WHERE parent_comment_ID = ? AND deleted_parent=0";
        $statement = $conn->prepare($query);
        $statement->execute(array($result[0]['parent_comment_ID']));
        $unremovedSiblings = $statement->fetchAll();
        $count = $statement->rowCount();

        // DELETE THE CURRENT 'ABOUT TO BE DELETED' COMMENT
        delete_postComment($result[0]['comment_ID']);
        // THEN FEED IT'S PARENT_ID (PREVIOUSLY SAVED) TO THE FUNCTION AGAIN
        if ($count == 0) {
            if ($new_parent_id != 0) { // ONLY STOP THIS PROCESS WHEN THE PARENT_ID OF THE CURRENTLY PROCESSED COMMENT IS EQUAL TO 0
                delete_parents($new_parent_id);
            }
        }

    }  
   
}


$data = array(
 'error'  => $error,
 'CrntTime' => $date,
);

echo json_encode($data);

?>