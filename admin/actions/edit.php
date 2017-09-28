<?php
require_once '../../config.php';
include '../../classes/Users.php';
include '../../classes/Colleges.php';

$data = array(
    'id'=>strip_tags(trim($_POST['userID'])),
    'table'=>strip_tags(trim($_POST['page'])),
    'values'=>$_POST['values']
);
if(!empty($_POST)){
    if($data['table'] == 'users.php') {
        $o = new Users();

        $columns = ['userType', 'firstName', 'lastName', 'username', 'password'];

        //getcurret password of the userid passed
        $result = $o->getUser($db, $data['id']);

        $unameexists = false;
        $newdata = array();

        //print_r($result);
        //check if username doesn't exists
        for($j = 1; $j <= $o->getTotalUsers($db);$j++){
            $results = $o->getUser($db,$j);

            //print_r($results);
            if ($data['values'][3] == $results[0]['username']){
                $unameexists = true;
                break;
            }
            else {
                //echo count($data['values']);
                for ($i = 0; $i < count($data['values']) - 1; $i++) {
                    //check if stored password == array['password']
                    //if yes, retain the array['password']
                    if ($result[0]['password'] == $data['values'][4]) {
                        $data['values'][4] = md5($data['values'][4]);
                    }

                    $unameexists = false;

                    $newdata[$columns[$i]] = $data['values'][$i];
                }
            }
        }
        if ($unameexists) {
            $result = 0;
        }
        else
            $result = $o->editUser($db,$data['id'],$data['table'],$newdata);

        if ($result > 0) {
            $response = array('notice' => 'Success!','msg'=> "Record successfully updated.",'lastid'=>$result);
        } else {
            $response = array('notice'=>'Warning!','msg' => "Username[ ".$data['values'][3]." ] already exist.");
        }
    }
    elseif($data['table'] == 'colleges.php'){
        $o = new Colleges();
        $result = $o->editCollege($db,$data['id'],$data['table']);
    }
    else{
        //$o = new Questions();
    }
    echo json_encode($response);
}
?>
