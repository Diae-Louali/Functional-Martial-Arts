<?php 
require("../MasterPHPFMA.php");
$pfp ='';
$error = '';
$validation='';

$file = $_FILES["filePFP"];
$fileName = $_FILES["filePFP"]["name"];
$fileTmpName = $_FILES["filePFP"]["tmp_name"];
$fileSize = $_FILES["filePFP"]["size"];
$fileError = $_FILES["filePFP"]["error"];
$fileType = $_FILES["filePFP"]["type"];

$fileExtention= explode(".", $fileName);
$LowerCasedActualExt= strtolower(end($fileExtention));
$allowed= array("jpg","jpeg","svg","png","pdf",);

if (in_array($LowerCasedActualExt, $allowed)) {
    if($fileError === 0) {

        if ($fileSize < 1000000) {
            $fileNewName = uniqid("", true).".".$LowerCasedActualExt;
            $fileDestination ="../Uploads/".$fileNewName;
            move_uploaded_file($fileTmpName,$fileDestination);
            $id = $_POST['Id']; 
            $_POST['Image_pfp'] = $fileNewName;
            unset($_POST['Id']);
            $user_ID = update('user', $id, $_POST); 
            // updateInfo($_SESSION['Connected-UserPfp'], $_POST['Image_pfp']);  WE GOT A PROBLEM HERE, WHEN SESSION VARIABLE IS ASSIGNED THROUGH A FUNCTION, IT DOES NOT REFRESH PROFILE IMAGE EVEN THOUGHT IT GOES THROUGHT TO THE DATABASE
            $_SESSION['Connected-UserPfp'] = $_POST['Image_pfp']; // WEIRDLY ENOUGH ASSIGNING DIRECTLY FIXES THE ISSUE, WHY ?
            $pfp = $_POST['Image_pfp'];
            $error = '<span class="text-success  py-1 px-3 border border-warning">Success : File uploaded!</span>';
            $validation= 1;
        } else {
            $error = '<span class="text-warning  py-1 px-3 border border-warning">Upload Error : Your image file is too big.</span>';
        }
    } else {
        $error = '<span class="text-warning  py-1 px-3 border border-warning">There was an error uploading your file</span>';
    }
} else {
    $error = '<span class="text-warning  py-1 px-3 border border-warning">Upload Error : Your image filetype is not supported. Please change it.</span>';
}





$data = array(
    'error'  => $error,
    'validation' => $validation,
    'pfp' => $pfp
   );
   
echo json_encode($data);
   
?>