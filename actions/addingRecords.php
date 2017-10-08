<?php
    require_once '../config.php';
    include '../classes/Users.php';
    include '../classes/Session.php';
    include '../classes/Colleges.php';
    $u = new Users();
    $c = new Colleges();
    $s = new Session();
    $finalMax = json_decode($_POST['recCollege']);
    $collegeFetch = implode(',',$finalMax);
    //(5) [4, 7, 9, 12, 13]
//     LOOP
// 	    concatenate collegeCode into a string;
//      UPDATE user SET resultCollege = string WHERE userID = $_SESSION['userID'];
//      show recommendation to front-end user
    //print_r($finalMax);
    //echo $collegeFetch;
    // print_r($str);
    if(isset($_SESSION['username'])){
        $str = $c->concatResults($db,$collegeFetch);
        $u->insertResult($db,$_SESSION['userID'],$str);
        $collegeStr = $c->getCollegeNames($db,$collegeFetch);
        echo json_encode($collegeStr);
    }
    else {
        $collegeStr = $c->getCollegeNames($db,$collegeFetch);
        echo json_encode($collegeStr);
    }
