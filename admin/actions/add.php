<?php
require_once '../../config.php';
include '../../classes/Users.php';

    $data = array(
        'userType'=>strip_tags(trim($_POST['values'][0])),
        'firstName'=>strip_tags(trim($_POST['values'][1])),
        'lastName'=>strip_tags(trim($_POST['values'][2])),
        'username'=>strip_tags(trim($_POST['values'][3])),
        'password'=>md5(strip_tags(trim($_POST['values'][4])))
    );


    if(!empty($_POST)){
        $user = new Users();

        $result = $user->addUser($db,$data,$data['username']);

        if ($result>0) {
            $response = array('notice' => 'Success!','msg'=> "User[".$data['username']."] added.",'lastid'=>$result);
        } else {
            $response = array('notice'=>'Warning!','msg' => "The username[ ".$data['username']." ] already exists.");
        }
        echo json_encode($response);
    }
?>