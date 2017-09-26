<?php
require_once '../../config.php';
include '../../classes/Users.php';
include '../../classes/Colleges.php';

$data = array(
    'id'=>strip_tags(trim($_POST['userID'])),
    'table'=>strip_tags(trim($_POST['page'])),
    'values'=>$_POST['values']
);

//print_r($data);


//print_r($newdata);
if(!empty($_POST)){
    if($data['table'] == 'users.php'){
        $o = new Users();

        $columns = ['acctType','firstName','lastName','username','password'];

        //getcurret password of the userid passed
        $result = $o->getUser($db,$data['id']);

        $unameexists = false;
        $newdata = array();

        //check if username doesn't exists
        //echo $result[0]['username'].'!='.$data['values'][3];
        if($result[0]['username']!=$data['values'][3]){
            for($i = 0;$i < count($data['values'])-1;$i++){
                //check if stored password == array['password']
                //if yes, retain the array['password']
                if($result[0]['password']!=$data['values'][4]){
                    $data['values'][4]=md5($data['values'][4]);
                }

                $unameexists = false;
                $newdata[$columns[$i]] = $data['values'][$i];
            }
        }else{
            $unameexists = true;
        }


        if($unameexists)
            $result = 0;
        else
            $result = $o->editUser($db,$data['id'],$data['table'],$newdata);

    }
    elseif($data['table'] == 'colleges.php'){
        $o = new Colleges();
        $result = $o->editCollege($db,$data['id'],$data['table']);
    }
    else{
        //$o = new Questions();
    }



    if ($result > 0) {
        $response = array('notice' => 'Success!','msg'=> "Record successfully updated.",'lastid'=>$result);
    } else {
        $response = array('notice'=>'Warning!','msg' => "Username[ ".$data['values'][3]." ] already exist.");
    }
    echo json_encode($response);
}
?>