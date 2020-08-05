<?php
    include("config.php");
    include("includes/header.inc.php");

?>
<br>
<div class="container text-center">
    <div class="row">
        <?php
            
            $fetchVideos = mysqli_query($con, "SELECT location FROM videos ORDER BY id DESC");
            while($row = mysqli_fetch_assoc($fetchVideos)){
                $location = $row['location'];
                echo '<div class="col-md-6 col-lg-4">';
                echo "<video src='".$location."' controls width='320px' height='200px' >";
                
                echo "</div>";
            }
        ?>    
    </div>
</div>
<?php
    include("includes/footer.inc.php");
?>