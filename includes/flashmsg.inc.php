<?php
    class flashmsg {
        function msg($msg, $type){
            echo '<div class="alert alert-'.$type.'" role="alert">';
                echo $msg;
            echo '</div>';
        }
    }
?>