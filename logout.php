<?php
    /*
    Author:  Drew D. Lenhart
    http://www.snowytech.com
    Page: logout.php
    Desc: Kills login session.
    */
    session_start();

    session_destroy();
    header("Location: index.php");
