<?php
require_once '../../config.php';
include '../../classes/Users.php';

$data = array(
    'id'=>strip_tags(trim($_POST['id'])),
    'table'=>strip_tags(trim($_POST['page']))
);


if(!empty($_POST)){
    $user = new Users();

    $result = $user->deleteUser($db,$data['id'],$data['table']);


    if ($result > 0) {
        $response = array('notice' => 'Success!','msg'=> "Record successfully deleted.",'lastid'=>$result);
    } else {
        $response = array('notice'=>'Warning!','msg' => "Record does not exist.");
    }
    echo json_encode($response);
}
?>