<?php
    if(isset($_POST['delete']))
    {
        unlink(__FILE__);
    }
?>