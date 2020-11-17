<?php
//fetch_comment.php

require(" MasterPHPFMA.php");

$query = "
SELECT * FROM comments_and_replies NATURAL JOIN user
WHERE parent_comment_ID = '0' and article_ID = '2' and Id = '1'
ORDER BY comment_id DESC 
";

$statement = $conn->prepare($query);

$statement->execute();

$result = $statement->fetchAll();
$output = '';
foreach($result as $row)
{
 $output .= "
        <div class='comment-details'>
            <div class='vertical-line d-flex justify-content-center align-items-center'>
                <i class='fas fa-plus expandIcon d-none'></i>
                <i class='fas fa-minus expandIcon'></i>
            </div>  
            <div class='comment-info'>
                <img src='uploads/".$row['Image_pfp']."' class='profile_pic'>  
                <span class='comment-name'>".$row['Name']."</span>
                <span class='admin_tag text-success'></span>
                <span class='gray comment-date'>• ".$row['comment_created_at']."</span>
                <time class='gray comment-date timeago' title='Last Updated : ".$row['comment_updated_at']."'> • Last Updated : ".$row['comment_updated_at']."</time>
            </div>  
            <p class='".$row['deleted_parent']."'>".$row['comment_content']."</p>               
            <form class='comment_buttons replyAlign comment_form".$row['comment_ID']." w-100 position-relative' action='' method='post'>
                <input type='hidden' id='user_role' value='".$row['Role']."'>
                <input type='hidden' id='deleted_parent' name='deleted_parent' value='".$row['deleted_parent']."'>
                <input type='hidden' id='user_comment_ID' value='".$row['user_ID']."'>
                <button type='button' data-toggle='collapse' data-target='#replyComment".$row['comment_ID']."' class='commentMenu gray reply-btn' name='reply_comment' id='reply'><i id='commentIcon' class='gray fa fa-reply'></i>Reply</button>

                <i class='fas fa-ellipsis-v d-none'></i>
                <div class='button_settings'>
                    <button type='button' data-toggle='modal' data-target='#update".$row['comment_ID']."' name='update' class=' to_show commentMenu gray reply-btn'><i class='far fa-edit'></i> Edit</button>
                    <button type='button' name='delete' class=' to_show commentMenu gray reply-btn' data-toggle='modal' data-target='#delete".$row['comment_ID']."'><i class='fas fa-trash-alt'></i> Delete</button>
                    <button type='submit' name='report_comment' value='' class='commentMenu gray reply-btn'><i class='far fa-flag'></i> Report</button>
                </div>
            </form>
        </div>

        <!-- Comment reply form -->
        <div style='margin-top:0;' id='replyComment".$row['comment_ID']."' class='collapse reply-section'>
            <form class='clearfix sendReply comment_form".$row['comment_ID']."' action='' method='post' onsubmit='return post_reply(".$row['comment_ID'].")'>
                <input type='hidden' class='parentID' name='parent_ID' value='".$row['comment_ID']."'>
                <input type='hidden' class='userID' value='1' name='user_ID'>
                <textarea  type='text' name='comment_content' cols='20' rows='3' class='reply_content comment_text form-control' placeholder='What are your thoughts ?'></textarea>
                <input type='submit' class='btn login_btn send_reply".$row['comment_ID']."' value='Reply' name='submitReply'>
            </form>
            <span id='empty_comment' class='text-danger'></span>
        </div>

        <!-- Comment Modal delete -->
        <div class=' logOutCard modal fade' id='delete".$row['comment_ID']."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
            <div class='d-flex justify-content-center h-100 modal-dialog' role='document'>
                <div class='card modal-content'>
                    <div class='marginButton card-header modal-header border-danger'>
                        <h5 class='modal-title text-danger my-2' id='exampleModalLabel'>Confirm comment deletion ?</h5>
                        <a href='#/' class='float-right mr-1 close' data-dismiss='modal'></a>
                    </div>
                    <div class='card-footer modal-footer border-danger py-2'>
                        <form method='post' action='' class='delete".$row['comment_ID']."' onsubmit='return do_delete(".$row['comment_ID'].")'>
                            <input type='hidden' value='".$row['comment_ID']."' name='comment_ID'>
                            <input type='hidden' value='".$row['parent_comment_ID']."' name='parent_comment_ID'>
                            <button type='button' class='btn btn-blue-grey waves-effect waves-light modal_btn' data-dismiss='modal'>Cancel</button>
                            <input type='submit' class='btn btn-danger waves-effect waves-light modal_btn' value='Delete' name='delete_comment'>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Comment Modal modify -->

        <div class=' logOutCard modal fade' id='update".$row['comment_ID']."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true' style='overflow: hidden;'>
            <div class='d-flex justify-content-center h-100 modal-dialog' role='document'>
                <div class='card modal-content'>
                    <div class='card-header modal-header border-danger'>
                        <h5 class='modal-title text-danger my-2' id='exampleModalLabel'>Edit your comment :</h5>
                        <a href='#/' class='float-right mr-1 close' data-dismiss='modal'></a>
                    </div>
                    <form class='update".$row['comment_ID']."' method='post' action='' onsubmit='return do_update(".$row['comment_ID'].");'>
                        <div class='modal-body'>

                            <textarea id='updated_comment' class='comment_text w-100' type='text' name='updated_comment'>".$row['comment_content']."</textarea>

                        </div>
                        <div class='card-footer modal-footer border-danger py-2'>
                            <input type='hidden' class='userID' value='8' name='user_ID'>
                            <input type='hidden' id='get_comment_ID' name='getComment' value='commentID". $row['comment_ID'] ."'>
                            <input type='hidden' id='commentID". $row['comment_ID'] ."' value='".$row['comment_ID']."' name='comment_ID'>
                            <button type='button' class='btn btn-blue-grey waves-effect waves-light modal_btn' data-dismiss='modal'>Cancel</button>
                            <input type='submit' class='btn btn-danger waves-effect waves-light modal_btn' value='Update' name='updateComment'>
                        </div>
                    </form>
                </div>
        </div>
    
    </div>
 ";
 $output .= get_reply_comment($conn, $row["comment_ID"]);
}

echo $output;

function get_reply_comment($conn, $parent_id = 0, $borderleft = 0)
{
 $query = "
 SELECT * FROM comments_and_replies NATURAL JOIN user WHERE parent_comment_ID = '".$parent_id."' and Id='1'
 ";
 $output = '';
 $statement = $conn->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 $count = $statement->rowCount();
 if($parent_id == 0)
 {
  $borderleft = 0;
 }
 else
 {
  $borderleft = $borderleft + 20;
 }
 if($count > 0)
 {
  foreach($result as $row)
  {
   $output .= "
    <div> 
        <div class='comment-details' style='border-left:".$borderleft."px solid rgba(039, 0, 0, 0.23)'>
            <div class='vertical-line d-flex justify-content-center align-items-center'>
                <i class='fas fa-plus expandIcon d-none'></i>
                <i class='fas fa-minus expandIcon'></i>
            </div>  
            <div class='comment-info'>
                <img src='uploads/".$row['Image_pfp']."' class='profile_pic'>  
                <span class='comment-name'>".$row['Name']."</span>
                <span class='admin_tag text-success'></span>
                <span class='gray comment-date'>• ".$row['comment_created_at']."</span>
                <time class='gray comment-date timeago' title='Last Updated : ".$row['comment_updated_at']."'> • Last Updated : ".$row['comment_updated_at']."</time>
            </div>  
            <p class='".$row['deleted_parent']."'>".$row['comment_content']."</p>
            <form class='comment_buttons replyAlign comment_form".$row['comment_ID']." w-100 position-relative' action='' method='post'>
                <input type='hidden' id='user_role' value='".$row['Role']."'>
                <input type='hidden' id='deleted_parent' value='".$row['deleted_parent']."'>
                <input type='hidden' id='user_comment_ID' value='".$row['user_ID']."'>
                <button type='button' data-toggle='collapse' data-target='#replyComment".$row['comment_ID']."' class='commentMenu gray reply-btn' name='reply_comment' id='reply'><i id='commentIcon' class='gray fa fa-reply'></i>Reply</button>
                <i class='fas fa-ellipsis-v d-none'></i>
                <div class='button_settings'>                   
                    <button type='button' data-toggle='modal' data-target='#update".$row['comment_ID']."' name='update' class='to_show commentMenu gray reply-btn'><i class='far fa-edit'></i> Edit</button>
                    <button type='button' name='delete' class='to_show commentMenu gray reply-btn' data-toggle='modal' data-target='#delete".$row['comment_ID']."'><i class='fas fa-trash-alt'></i> Delete</button>
                    <button type='submit' name='report_comment' value='' class='commentMenu gray reply-btn'><i class='far fa-flag'></i> Report</button>
                </div>
            </form>
        </div>

        <!-- Comment reply form -->
        <div style='margin-top:0;' id='replyComment".$row['comment_ID']."' class='collapse reply-section'>
            <form class='clearfix sendReply comment_form".$row['comment_ID']."' action='' method='post' onsubmit='return post_reply(".$row['comment_ID'].")'>
                <input type='hidden' class='parentID' name='parent_ID' value='". $row['comment_ID'] ."'>
                <input type='hidden' class='userID' value='8' name='user_ID'>
                <textarea type='text' name='comment_content' cols='20' rows='3' class='reply_content comment_text form-control' placeholder='What are your thoughts ?'></textarea>
                <input type='submit' class='btn login_btn send_reply".$row['comment_ID']."' value='Reply' name='submitReply'>
            </form>
            <span id='empty_comment' class='text-danger'></span>
        </div>

        <!-- Comment Modal delete -->
        <div class=' logOutCard modal fade' id='delete".$row['comment_ID']."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
            <div class='d-flex justify-content-center h-100 modal-dialog' role='document'>
                <div class='card modal-content'>
                    <div class='marginButton card-header modal-header border-danger'>
                        <h5 class='modal-title text-danger my-2' id='exampleModalLabel'>Confirm comment deletion ?</h5>
                        <a href='#/' class='float-right mr-1 close' data-dismiss='modal'></a>
                    </div>
                    <div class='card-footer modal-footer border-danger py-2'>
                        <form method='post' action='' class='delete".$row['comment_ID']."' onsubmit='return do_delete(".$row['comment_ID'].")'>
                            <input type='hidden' value='".$row['comment_ID']."' name='comment_ID'>
                            <input type='hidden' value='".$row['parent_comment_ID']."' name='parent_comment_ID'>
                            <button type='button' class='btn btn-blue-grey waves-effect waves-light modal_btn' data-dismiss='modal'>Cancel</button>
                            <input type='submit' class='btn btn-danger waves-effect waves-light modal_btn' value='Delete' name='delete_comment'>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Comment Modal modify -->
        <div class=' logOutCard modal fade' id='update".$row['comment_ID']."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
            <div class='d-flex justify-content-center h-100 modal-dialog' role='document'>
                <div class='card modal-content'>
                    <div class='card-header modal-header border-danger'>
                        <h5 class='modal-title text-danger my-2' id='exampleModalLabel'>Edit your comment :</h5>
                        <a href='#/' class='float-right mr-1 close' data-dismiss='modal'></a>
                    </div>
                    <form class='update".$row['comment_ID']."' method='post' action='' onsubmit='return do_update(".$row['comment_ID'].");'>
                        <div class='modal-body'>

                            <textarea id='updated_comment' class='comment_text w-100' type='text' name='updated_comment'>".$row['comment_content']."</textarea>

                        </div>
                        <div class='card-footer modal-footer border-danger py-2'>
                            <input type='hidden' class='userID' value='8' name='user_ID'>
                            <input type='hidden' id='get_comment_ID' name='getComment' value='commentID". $row['comment_ID'] ."'>
                            <input type='hidden' id='commentID". $row['comment_ID'] ."' value='".$row['comment_ID']."' name='comment_ID'>
                            <button type='button' class='btn btn-blue-grey waves-effect waves-light modal_btn' data-dismiss='modal'>Cancel</button>
                            <input type='submit' class='btn btn-danger waves-effect waves-light modal_btn' value='Update' name='updateComment'>
                        </div>
                    </form>
                </div>
        </div>
    </div>
 ";
   $output .= get_reply_comment($conn, $row["comment_ID"], $borderleft);
  }
 }
 return $output;
}


?>