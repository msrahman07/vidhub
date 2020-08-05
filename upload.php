
<?php
include("config.php");
include("includes/header.inc.php");
//echo getcwd();
if(isset($_POST['but_upload'])){
    // echo "Button clicked";
    $maxsize = 5242880000; // 5MB

    $name = $_FILES['file']['name'];
    $target_dir = "videos/";
    //echo $target_dir;
    $target_file = $target_dir . $_FILES["file"]["name"];

    // Select file type
    $videoFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Valid file extensions
    $extensions_arr = array("mp4","avi","3gp","mov","mpeg");

    // Check extension
    if( in_array($videoFileType,$extensions_arr) ){

    //   Check file size
        if(($_FILES['file']['size'] >= $maxsize) || ($_FILES["file"]["size"] == 0)) {
        echo "File too large. File must be less than 5MB.";
        }else{
        // Upload
        echo "<h1>hello".$target_file."</h1>";
        if(move_uploaded_file($_FILES['file']['tmp_name'],$target_file)){
            // Insert record
            $query = "INSERT INTO videos(name,location) VALUES('".$name."','".$target_file."')";

            mysqli_query($con,$query);
            echo "Upload successfully.";
        }
        }

    }else{
        echo "Invalid file extension.";
    }

    } 
?>
<div class="container">
    <div class="custom-file">
        <form method="post" action="" enctype='multipart/form-data'>
            <div class="row">
                <div class="col-md-11">
                    <input class="custom-file-input" type='file' name='file' id="customFile">
                    <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
                <div class="col-md-1">
                    <input class="btn btn-primary" type='submit' value='Upload' name='but_upload'>
                </div>
            </div>
        </form>
    </div>
    
</div>

<?php
    include("includes/footer.inc.php")
?>