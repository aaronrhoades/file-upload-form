<?php
//create db connections
require __DIR__ . '/config.php';
$con = connect(); //from connect.php

//folder name for uploads
$target_dir = "uploads";

//create folder if it doesn't exist
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}

$target_file = $target_dir . "/" . basename($_FILES["uploadFile"]["name"]);
//echo $target_file + "<br>";
//echo $FILES["uploadFile"];

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["uploadFile"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

  // Check if file already exists
  if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
  }

  // Check file size
  if ($_FILES["uploadFile"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
  }

  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
  }
  
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $target_file)) {
        $upload_title = $_POST["uploadTitle"];
        echo "The file ". htmlspecialchars( basename( $_FILES["uploadFile"]["name"])). " has been uploaded.";
        saveUploadMetadata($target_file, $upload_title);
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

function saveUploadMetadata($targetFileLocation, $uploadTitle){
    global $con;

    echo 'writing db metadata:' . $targetFileLocation . '<br>';
    echo $uploadTitle; 
 
    //use prepare SQL to avoid SQL injection
    $sql = "INSERT INTO files (file_path, meta_title) VALUES(?,?);";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ss", $targetFileLocation, $uploadTitle);
    
    if($stmt->execute())
    {
        echo 'success!';
      //return json_encode(['success' => true]);
    }
    else {
        http_response_code(500); //TODO: determine when should be 400? https://www.php.net/manual/en/function.http-response-code.php
        echo '<br>failure :(<br>';
        echo $stmt->error;
        //return json_encode(['success'=>false]);
    }
    $stmt->close();
}

?>