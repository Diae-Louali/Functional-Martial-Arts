<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";

$conn = new PDO("mysql:host=$servername;dbname=FMA", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

///////////////////////////////////////////////////////////////////////////////////////////////
// if (isset($_SESSION['Connected-UserID'])) {
//     echo '<pre>', print_r('you are connected', true) ,'</pre>';
//     exit(0);
// }else {
//     echo '<pre>', print_r('you NOT are connected', true) ,'</pre>';
// }

function disconnect(){
    unset($_SESSION["Connected-UserID"]);
    unset($_SESSION["Connected-UserFname"]);
    unset($_SESSION["Connected-UserLastname"]);
    unset($_SESSION["Connected-UserAge"]);
    unset($_SESSION["Connected-UserAddress"]);
    unset($_SESSION["Connected-UserEmail"]);
    unset($_SESSION["Connected-UserUsername"]);
    unset($_SESSION["Connected-UserPassword"]);
    unset($_SESSION["Connected-UserRole"]);
    unset($_SESSION["Connected-UserPfp"]);
    session_destroy();
}

function gestsOnly($redirect = "HomeFMA.php") {
    if (isset($_SESSION['Connected-UserID'])) {
        // echo '<pre>', print_r('you are connected', true) ,'</pre>';
        header('Location:' . $redirect);
        exit(0);
    }else {
        // echo '<pre>', print_r('you NOT are connected', true) ,'</pre>';
    }
}

function unsetEmptyVars() {
    
    foreach ($_POST as $key => $value) {
        if (strlen(preg_replace('/\s+/u','',$value)) == 0) {
            unset($_POST[$key]);
        }
    }
    return $_POST;
}

function usersOnly($redirect = "HomeFMA.php") {
    if (empty($_SESSION['Connected-UserID'])) {
        $_SESSION['Error'] = "<div class='alert alert-danger w-100 text-center px-0 mt-4 mb-0' role='alert'><span>'Access denied. You&nbsp;need&nbsp;to&nbsp;<a href='LoginFMA.php' class='alert-link'>login&nbsp;to&nbsp;your&nbsp;account</a>&nbsp;first. Don't&nbsp;have&nbsp;one&nbsp;?&nbsp;<a href='RegisterFMA.php' class='alert-link'>Register&nbsp;!</a>'</span></div>";
        $_SESSION['Center'] = 1;
        header('Location:' . $redirect);
        exit(0);
    }
}

function adminOnly($redirect = "HomeFMA.php") {
    if (empty($_SESSION['Connected-UserID']) || $_SESSION["Connected-UserRole"] != "Admin") {
        $_SESSION['Error'] = "<div class='alert alert-danger w-100 text-center px-0 mt-4 mb-0' role='alert'><span>'Access denied. You&nbsp;do&nbsp;not&nbsp;have&nbsp;the&nbsp;proper&nbsp;authorization to&nbsp;enter&nbsp;this&nbsp;page.'</span></div>";
        $_SESSION['Center'] = 1;
        header('Location:' . $redirect);
        exit(0);
    }
}


function searchForId($id, $array) {
    foreach ($array as $key => $val) {
        if ($val['Id'] === $id) {
            return $key;
        }
    }
    return null;
}



function executeQuery($req, $dataParams) {
    global $conn;
    $stmt = $conn-> prepare($req);
    $values = array_values($dataParams);
    $stmt-> execute($values);
    return $stmt;   
}



function selectALL($table, $conditions = []){
    global $conn;
    $req ="SELECT * FROM $table";
    if (empty($conditions)) {
        $stmt = $conn->prepare($req);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    } else {
        $i=0;
        foreach ($conditions as $key => $value) {
            if ($i === 0) {
                $req = $req . " WHERE $key = ?";
            } else {
                $req = $req . " AND $key = ?";
            }
            $i++;
        }
        $stmt = executeQuery($req, $conditions);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
}


function selectOne($table, $conditions){
    global $conn;
    $req ="SELECT * FROM $table";
    $i=0;
    foreach ($conditions as $key => $value) {
        if ($i === 0) {
            $req = $req . " WHERE $key = ?";
        } else {
            $req = $req . " AND $key = ?";
        }
        $i++;
    }
    $req = $req . " LIMIT 1";
    $stmt = executeQuery($req, $conditions);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    return $data;  
}



function create($table, $data){
    global $conn;
    $req = "INSERT INTO $table SET";
    $i=0;
    foreach ($data as $key => $value) {
        if ($i === 0) {
            $req = $req . " $key = ?";
        } else {
            $req = $req . ", $key = ?";
        }
        $i++;
    }
    $stmt = executeQuery($req, $data);
    $id = $conn->lastInsertId();
    return $id;
}



function update($table, $id, $data){
    global $conn;
    $req = "UPDATE $table SET ";
    $i=0;
    foreach ($data as $key => $value) {
        if ($i === 0) {
            $req = $req . " $key = ?";
        } else {
            $req = $req . ", $key = ?";
        }
        $i++;
    }
    $req = $req . " WHERE Id = ?";
    $data['id'] = $id;
    $stmt = executeQuery($req, $data);
    return $stmt->rowCount();
}



function delete($table, $id){
    global $conn;
    $req = "DELETE FROM $table WHERE Id = ?";
    $stmt = executeQuery($req, ['Id' => $id]);
    return $stmt->rowCount();
}



function loginUser($userVar){
    $_SESSION["Connected-UserID"]       = $userVar["Id"];
    $_SESSION["Connected-UserFname"]    = $userVar["Name"];
    $_SESSION["Connected-UserLastname"] = $userVar["Lastname"];
    $_SESSION["Connected-UserAge"]      = $userVar["Age"];
    $_SESSION["Connected-UserAddress"]  = $userVar["Address"];
    $_SESSION["Connected-UserEmail"]    = $userVar["Email"];
    $_SESSION["Connected-UserUsername"] = $userVar["Username"];
    $_SESSION["Connected-UserPassword"] = $userVar["Password"];
    $_SESSION["Connected-UserRole"]     = $userVar["Role"];
    $_SESSION["Connected-UserPfp"]      = $userVar["Image_pfp"];
    if ($_SESSION["Connected-UserRole"] === "Admin") {
        header("Location:AdminFMA.php");
    } else {
        header("Location:HomeFMA.php");
    }       
    exit();
}



function uploadImg ($fileImg, $rootPathUpload) {
    if (!empty($fileImg['name'])) {
        $image_name = time() . '_' . $fileImg['name'];
        $destination = $rootPathUpload . $image_name;      
        $result= move_uploaded_file($fileImg['tmp_name'], $destination);  
        if ($result) {
            $_POST['Image'] = $image_name;
        } else {
            $ImgErrorMsg="<span>'Image failed to Upload. Please try again.'</span>";
        }
    }
}



function getPutblishedPosts() {
        global $conn;
        $req =  
           'SELECT p.*, u.Username 
            FROM article AS p  
            JOIN user AS u 
            ON p.ID_User=u.Id 
            WHERE Published=?
            ORDER BY p.PublicationDate DESC';
        $stmt = executeQuery($req, ['Published' => 1]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;  
}



function get_posts_with_username() {
    global $conn;
    $req =  
       'SELECT p.*, u.Username 
        FROM article AS p  
        JOIN user AS u 
        ON p.ID_User=u.Id 
        ORDER BY p.PublicationDate ASC';
        $stmt = $conn->prepare($req);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;

}




function getPostsByTopicId($id) {
    global $conn;
    $req =  
       'SELECT p.*, u.Username 
        FROM article AS p
        JOIN user AS u
        ON p.ID_User=u.Id 
        WHERE ID_Topic=?
        ORDER BY p.PublicationDate DESC';
    $stmt = executeQuery($req, ['ID_Topic' => $id]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $data;  
}




function searchPosts($term) {
        global $conn;
        $req = 'SELECT 
                p.*, u.Username 
            FROM article AS p
            JOIN user AS u 
            ON p.ID_User=u.Id 
            WHERE Published=?
            AND p.Title LIKE ? 
            OR p.Content Like ?
            ORDER BY p.PublicationDate DESC';

        $stmt = executeQuery($req, ['Published' => 1, 'Title' => '%'.$term.'%', 'Content' => '%'.$term.'%']);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;      
}



// function updateInfo($sessionVar, $postVar) {
    //     echo "BEFORE  : SESSION  = " .$sessionVar. '<br> BEFORE  : POST  ='. $postVar . '<br>';
    //         $sessionVar = $postVar; 
    //         if (isset($sessionVar)) {
    //             echo "AFTER  : SESSION  = " .$sessionVar. '<br> AFTER  : POST  ='. $postVar . '<br>';
    //             echo "REAL SESSION BEFORE THE RETURN   : " . $_SESSION['Connected-UserAddress'];

    //         } else {
    //             echo "NAH  : " . $_SESSION['Connected-UserAddress'];
    //         }
    //         updateInfo($_SESSION['Connected-UserFname'], $_POST['Name']);
    //         updateInfo($_SESSION['Connected-UserLastname'], $_POST['Lastname']);
    //         updateInfo($_SESSION['Connected-UserAge'], $_POST['Age'] );
    //         updateInfo($_SESSION['Connected-UserAddress'], $_POST['Address']);
    //         updateInfo($_SESSION['Connected-UserEmail'], $_POST['Email']);
    //         updateInfo($_SESSION['Connected-UserUsername'], $_POST['Username']);
    //         updateInfo($_SESSION['Connected-UserPassword'], $_POST['Password']);
    //         updateInfo($_SESSION['Connected-UserRole'], $_POST['Role']);

// }
///////////////////////////////HARD CODED FUNCTIONS AND GENERAL INSTRUCTIONS And Variables//////////////////////////////////////////////////////
$uploadFileDest = 'C:/Users/DELL/Desktop/3wa/WEEK6-and-8-XAMPP-PHP/htdocs/Functional-Martial-Arts/Uploads/';


$topics = selectALL('topics');
$posts = get_posts_with_username('article');
$users = selectALL('user');
$publishedPosts = selectALL('article', ['published' => 1]);
$popularPosts = getPutblishedPosts();
$postMainTitle = 'Recent Posts';
$publishedPosts = array();
if (isset($_GET['t_id'])) {
    $publishedPosts= getPostsByTopicId($_GET['t_id']);
    $postMainTitle = "Posts under '" . $_GET['t_name'] . "' :";
    $searchResult = '<div class="w-100 d-flex justify-content-center font-weight-bold my-lg-5 my-md-4 my-sm-3 centerhere"><span>There are "<strong class="blue-text font-weight-bold">' . count($publishedPosts) . '</strong>" Articles under the  "' . $_GET['t_name'] . '" Category</span></div>';
    $_SESSION['Center'] = 1;

} elseif (isset($_POST['search-term']) && ($_POST['search-term'] !== '')) {
    $publishedPosts = searchPosts($_POST['search-term']);
    $postMainTitle = "Searched term(s) : '" . $_POST['search-term'] . "'";
    $searchResult = '<div class="w-100 d-flex justify-content-center font-weight-bold my-lg-5 my-md-4 my-sm-3 centerhere"><span>Your search request has returned "<strong class="blue-text font-weight-bold">' . count($publishedPosts) . '</strong>" results.</span></div>';
    $_SESSION['Center'] = 1;
} else {
    unset($_POST['search-term']);
    $publishedPosts = getPutblishedPosts();
}





























?>