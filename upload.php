<?php
include("config.php");
include("includes/header.inc.php");
echo "<br><br>";
//echo getcwd();
if(isset($_POST['but_upload'])){
    // echo "Button clicked";
    $maxsize = 50000000000000;

    $name = $_FILES['file']['name'];
    //echo getimagesize($_FILES['file']['tmp_name'])."<br><br>";
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
        if(($_FILES['file']['size'] >= $maxsize)) {
        echo "File too large. File must be less than 5MB.";
        }else{
            // Upload
            if(move_uploaded_file($_FILES['file']['tmp_name'],$target_file)){
                // Insert record
                $query = $con->prepare("INSERT INTO videos(name,location) VALUES(?,?)");
                $query->bind_param("ss", $name, $target_file);
                $query->execute();
                //mysqli_query($con,$query);
                echo '<div class="alert alert-success" role="alert">';
                    echo "Upload successfully.";
                echo '</div>';
            }
        }

    }else{
        echo "Invalid file extension.";
    }

} 
?>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

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
<script>
// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
</script>

<?php
    include("includes/footer.inc.php")
?>