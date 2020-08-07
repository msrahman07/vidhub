<?php
class dbh {
    public function deleteVideo($id, $con){
        $query = $con->prepare("DELETE FROM videos WHERE id=?");
        $query->bind_param("i", $id);
        $query->execute();
    }
}
?>
