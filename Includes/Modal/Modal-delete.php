<?php 
if (isset($_POST['submitdelete'])) {
    adminOnly();
    if ($_POST['delete-type'] == "delete-post") {
        delete('article', $_POST['Id-delete']);
        $_SESSION['Deleted'] = 'post-delete';
        $_SESSION['Message'] = "<div class='alert alert-success w-100 text-center px-0 mt-4 mb-1' role='alert'>'Post deleted successfully'</div>";
        header('Location:AdminFMA.php');
        exit(0);
    } elseif ($_POST['delete-type'] == "delete-topic") {
        delete('topics', $_POST['Id-delete']);
        $_SESSION['Deleted'] = 'topic-delete';
        $_SESSION['Message'] = "<div class='alert alert-success w-100 text-center px-0 mt-4 mb-1' role='alert'>'Topic deleted successfully'</div>";
        header('Location:AdminFMA.php');
        exit(0);
    } elseif ($_POST['delete-type'] == "delete-user") {
        delete('user', $_POST['Id-delete']);
        $_SESSION['Deleted'] = 'user-delete';
        $_SESSION['Message'] = "<div class='alert alert-success w-100 text-center px-0 mt-4 mb-1' role='alert'>'User deleted successfully'</div>";
        header('Location:AdminFMA.php');
        exit(0);
    }          
}



?>
<div class="modal fade h-100 confirm_delete" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog d-flex justify-content-center align-items-center h-100">
            <div class="card modal-content">
                <div class="card-header modal-header border-danger">
                    <h2 class="modal-title font-weight-bold mx-auto">Confirm deletion</h2>
                    <a aria-hidden="true" data-dismiss="modal">&times;</a>
                    <a href="#/" class="float-right mr-1 close" data-dismiss="modal"></a>
                </div>
                <div class="card-body modal-body">
                    <p> You are about to delete a record from the database. <br> This procedure is irreversible.</p>
                    <p class='mb-3'><u>Are you sure you want to procede ?</u>:  </p>
                    <p class="debug-url"></p>
                </div>
                <div class="card-footer modal-footer border-danger">
                    <div class="d-flex justify-content-center links">
                        <form action="AdminFMA.php" method="post">
                            <input type="hidden" name="Id-delete" value=""> 
                            <input type="hidden" name="delete-type" value=""> 
                            <button type="button" class="btn btn-blue-grey" data-dismiss="modal">cancel</button>
                            <input type="submit" class="btn btn-danger btn-ok" name="submitdelete" value="Delete"> 
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
