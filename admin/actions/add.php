<?php
require_once '../../config.php';
include '../../classes/Users.php';
include '../../classes/Colleges.php';

$data = array(
    'id'=>strip_tags(trim($_POST['ID'])),
    'table'=>strip_tags(trim($_POST['page'])),
    'values'=>$_POST['values']
);
    // $data = array(
    //     'acctType'=>strip_tags(trim($_POST['values'][0])),
    //     'firstName'=>strip_tags(trim($_POST['values'][1])),
    //     'lastName'=>strip_tags(trim($_POST['values'][2])),
    //     'username'=>strip_tags(trim($_POST['values'][3])),
    //     'password'=>md5(strip_tags(trim($_POST['values'][4])))
    // );

    print_r($data);
    die();
    if(!empty($_POST)){
        if(data['table'] == 'users.php'){
            $user = new Users();

            $result = $user->addUser($db,$data['values'],$data['values'][3]);

            if ($result>0) {
                $response = array('notice' => 'Success!','msg'=> "User[".$data['username']."] added.",'lastid'=>$result);
            } else {
                $response = array('notice'=>'Warning!','msg' => "The username[ ".$data['username']." ] already exists.");
            }
        }
        else if(data['table' == 'colleges.php']){

        }
        echo json_encode($response);
    }
?>
