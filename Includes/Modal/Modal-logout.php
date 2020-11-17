<?php 
if (isset($_POST['submitlogout'])) {
    disconnect();
} 
?>
<div id="SignOutModal">
    <div class="modal_wrapper modal fade" id="LogOutModal" style="overflow: hidden;">
        <div class="d-flex justify-content-center h-100 modal-dialog">
            <div class="card modal-content">
                <div class="card-header modal-header border-danger">
                    <h2 class="modal-title font-weight-bold mx-auto" id="signin">Confirm sign out ?</h2>
                    <span aria-hidden="true">&times;</span>
                    <a href="#/" class="float-right mr-1 close" data-dismiss="modal"></a>
                </div>
                <div class="card-body modal-body">
                    <p>You are currently logged in as : <br> <span class='badge m-2'><?php echo $_SESSION["Connected-UserUsername"]; ?></span> </p>
                </div>
                <div class="card-footer modal-footer border-danger">
                    <div class="d-flex justify-content-center links">
                        <form action="HomeFMA.php" method="post">
                            <input type="submit" id="logOut_btn" name="submitlogout" value="Log out"> 
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
