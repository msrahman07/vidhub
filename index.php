<?php
    include("config.php");
    include("includes/header.inc.php");
    include("db/dbh.php");

?>
<br>
<div class="container text-center">
    <div class="row">
        <?php
            
            $fetchVideos = mysqli_query($con, "SELECT id, location, name FROM videos ORDER BY id DESC");
            while($row = mysqli_fetch_assoc($fetchVideos)){
                $id = $row['id'];
                $location = $row['location'];
                $name = $row['name'];
                echo '<div class="col-md-6 col-lg-4">';
                    echo '<div class="float-left">';
                        echo "<video src='".$location."' controls width='320px' height='200px' >";
                    echo '</div>';
                    echo '<div class="float-left">';
                        echo "<a href=''>".$name."</a>";
                    echo '</div>';
                    
                    echo '<div>';
                        if(isset($_POST['del_btn'])){
                            $dbh = new dbh();
                            $dbh->deleteVideo($id, $con);
                        }
                        echo '<form action="" method="post">';
                            echo '<input type="submit" class="btn btn-sm btn-danger float-right" name="del_btn" value="delete">';
                        echo '</form>';
                    echo '</div>';
                echo "</div>";
            }
        ?>    
    </div>
</div>
<?php
    include("includes/footer.inc.php");
?>