<?php
require_once '../../config.php';
include '../../classes/Users.php';
include '../../classes/Colleges.php';

$data = array(
    'id'=>strip_tags(trim($_POST['userID'])),
    'table'=>strip_tags(trim($_POST['page'])),
    'values'=>$_POST['values']
);
// print_r($data);
/*
Array
(
    [id] => 10
    [table] => users.php
    [values] => Array
        (
            [0] => admin
            [1] => test
            [2] => test
            [3] => testxx
            [4] => 098f6bcd4621d373cade4e832627b4f6
            [5] => <a href="#" data-rel="10" class="hidden on-editing save-row" rs_id="196"><i class="fa fa-save" rs_id="197"></i></a>
                                                  <a href="#" class="hidden on-editing cancel-row" rs_id="198"><i class="fa fa-times" rs_id="199"></i></a>
                                                  <a href="#" data-rel="10" class="on-default edit-row" rs_id="200"><i class="fa fa-pencil" rs_id="201"></i></a>
                                                  <a href="#" data-rel="10" class="on-default remove-row" rs_id="202"><i class="fa fa-trash-o" rs_id="203"></i></a>
        )

)
Array
(
    [0] => Array
        (
            [userID] => 10
            [userType] => admin
            [firstName] => test
            [lastName] => test
            [username] => testxx
            [password] => 098f6bcd4621d373cade4e832627b4f6
            [resultCollege] =>
        )

)

newarray =(
[userType]=admin
[firstName]=test
)
*/



//print_r($newdata);
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
