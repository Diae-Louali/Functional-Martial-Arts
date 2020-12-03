<?php

//add_comment.php

require('masterFile.php');

$error = '';
$deleted_comment= '<span class="comment_deleted">(Comment deleted)</span>';

// select all children of the comment
$query = "SELECT * FROM comments WHERE parent_comment_ID = ? ";
$statement = $conn->prepare($query);
$statement->execute(array($_POST['comment_ID']));
$result = $statement->fetchAll();
$count = $statement->rowCount();
//if the comment has no child
if ($count==0) {

    // select the parent_comment_ID of the comment
    $query = "SELECT parent_comment_ID FROM comments WHERE comment_ID = ? ";
    $statement = $conn->prepare($query);
    $statement->execute(array($_POST['comment_ID']));
    $parent_id = $statement->fetch();

    // if the comment has a parent
    if ($parent_id!=0) {

        // select the siblings of the comment
        $query = "SELECT * FROM comments WHERE parent_comment_ID = ? AND comment_deleted=0 ";
        $statement = $conn->prepare($query);
        $statement->execute(array($parent_id['parent_comment_ID'] ));
        $result = $statement->fetchAll();
        $count = $statement->rowCount();

        // if there is at least one sibling ( the comment + a sibling = 2)
        if ($count > 1 ) {

             // delete the comment
             $sql = "DELETE FROM comments WHERE comment_ID=?";
             $req = $conn->prepare($sql);
             $req->execute(array($_POST['comment_ID']));
             $error = '<label class="text-success">Comment Deleted</label>';

        // if there are no siblings
        } else {

            // select the deleted parent of the comment
            $query1 = "SELECT * FROM comments WHERE comment_ID = ? AND comment_deleted=1  ";
            $statement1 = $conn->prepare($query1);
            $statement1->execute(array($parent_id['parent_comment_ID']));
            $parent_comment = $statement1->fetchAll();
            $count1 = $statement1->rowCount();
            // if there is one
            if ($count1 == 1) {

                // remove all deleted parents of the comment
                delete_parent($parent_comment);

                // delete the comment
                $sql = "DELETE FROM comments WHERE comment_ID=?";
                $req = $conn->prepare($sql);
                $req->execute(array($_POST['comment_ID']));
                $error = '<label class="text-success">Comment Deleted</label>';
            
            } else{

                // delete the comment
                $sql = "DELETE FROM comments WHERE comment_ID=?";
                $req = $conn->prepare($sql);
                $req->execute(array($_POST["comment_ID"]));
                $error = '<label class="text-success">Comment Deleted</label>';
            }
            
        }
        
    // if the comment has no parent
    } else {

        // delete the comment
        $sql = "DELETE FROM comments WHERE comment_ID=?";
        $req = $conn->prepare($sql);
        $req->execute(array($_POST["comment_ID"]));
        $error = '<label class="text-success">Comment Deleted</label>';
    }

// if the comment has at least one child
}else{

    // update the comment to deleted state
    $sqli = "UPDATE comments SET comment_content=?, comment_deleted=1 WHERE comment_ID=?";
    $requ = $conn->prepare($sqli);
    $requ->execute(array($deleted_comment, $_POST["comment_ID"]));
    $error = '<label class="text-success">Comment Deleted</label>';

}


function delete_parent($parent_comment)
{
    global $conn;
    $new_parent_id= 0;

    // if the parent is deleted
    if ($parent_comment[0]['comment_deleted']==1) {

        // store the the id of the grand parent
        $new_parent_id=$parent_comment[0]['parent_comment_ID'];

        // select the siblings of the parent
        $query = "SELECT * FROM comments WHERE parent_comment_ID = ? AND comment_deleted=0 ";
        $statement = $conn->prepare($query);
        $statement->execute(array($new_parent_id ));
        $result = $statement->fetchAll();
        $count = $statement->rowCount();
        // print_r($result[0]);
        // if there is at least one sibling ( the comment + a sibling = 2)
        if ($count > 0 ) {

            // delete the parent
            $sql = "DELETE FROM comments WHERE comment_ID=?";
            $req = $conn->prepare($sql);
            $req->execute(array($parent_comment[0]['comment_ID']));

        // if there are no siblings of the parent
        } else {
        
            // select the deleted grand parent
            $query1 = "SELECT * FROM comments WHERE comment_ID = ? AND comment_deleted=1  ";
            $statement1 = $conn->prepare($query1);
            $statement1->execute(array($new_parent_id));
            $grandParent_comment = $statement1->fetchAll();
            $count1 = $statement1->rowCount();

            // delete the parent
            $sql = "DELETE FROM comments WHERE comment_ID=?";
            $req = $conn->prepare($sql);
            $req->execute(array($parent_comment[0]['comment_ID']));

            // if there is a deleted grand parent
            if ($count1 == 1) {

                // if the parent isn't an original comment
                if ($new_parent_id!=0) {

                    // remote all deleted parents of the parent
                    delete_parent($grandParent_comment);
                }
            }
        }
    }
}


$data = array(
 'error'  => $error
);

echo json_encode($data);


?>