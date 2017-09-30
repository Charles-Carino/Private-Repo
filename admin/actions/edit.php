<?php
require_once '../../config.php';
include '../../classes/Users.php';
include '../../classes/Colleges.php';
include '../../classes/Questions.php';

$data = array(
    'id'=>strip_tags(trim($_POST['userID'])),
    'table'=>strip_tags(trim($_POST['page'])),
    'values'=>$_POST['values']
);

//print_r($data);


if(!empty($_POST)){

    if($data['table'] == 'users.php') {
        $o = new Users();

        $columns = ['userType', 'firstName', 'lastName', 'username', 'password'];

        //getcurret password of the username passed
        $result = $o->getUserbyUsername($db,$data['values'][3]);//$data['id']

        $unameexists = false;
        $selfrecord = false;
        $unameupdated = false;
        $upwupdated = false;

        $newdata = array();

        if(count($result)>0){
            $unameexists = true;
            $selfrecord = true;

            //echo 'Data fetch: '.$result[0]['userID']." == ".' Data pass: '.$data['id'];
            //compare username
            if($result[0]['userID'] == $data['id']){
                $selfrecord = true;
            }else{
                $selfrecord = false;
            }

            if($selfrecord){

                //echo 'Updated self!';
                //store result into newdata array
                for ($i = 0; $i < count($data['values']) - 1; $i++) {
                    $newdata[$columns[$i]] = $data['values'][$i];
                }

                //print_r($newdata);
                //check if username doesn't exists
                if ($result[0]['username'] != $data['values'][3]) {
                    $newdata['username'] = $data['values'][3];
                    $unameupdated = true;
                }

                if ($result[0]['password'] !=   ($data['values'][4])) {
                    $newdata['password'] = md5($data['values'][4]);
                    $upwupdated = true;
                }

                $result = $o->editUser($db, $data['id'], $data['table'], $newdata);

                $response = array('notice' => 'Success!','msg' => 'Record successfully updated.','lastid'=>$result);
            }else{

                //echo 'User exists and not self!';
                $response = array('notice' => 'Warning!','msg' => "Username [".$data['values'][3]."] already exists.");

            }

        }else{
            for ($i = 0; $i < count($data['values']) - 1; $i++) {
                $newdata[$columns[$i]] = $data['values'][$i];

                if($i==4){
                    $newdata[$columns[$i]] = md5($data['values'][$i]);
                }
            }
            //print_r($newdata);

            $result = $o->editUser($db, $data['id'], $data['table'], $newdata);
            $response = array('notice' => 'Success!','msg' => 'Record successfully updated.','lastid'=>$result);
        }

    }else if($data['table'] == 'colleges.php'){
        $o = new Colleges();
        $columns = ['collegeCode', 'collegeName', 'collegeAboutInfo', 'collegeDean', 'collegeEmail', 'collegePhoneNumber'];

        $result = $o->getCollegeDetail($db,$data['values'][0]);

        $newData = array();

        for ($i = 0; $i < count($data['values']) - 1; $i++) {
            $newdata[$columns[$i]] = $data['values'][$i];
        }

        $result = $o->editCollege($db, $data['id'], $data['table'], $newdata);

        $response = array('notice' => 'Success!','msg' => 'Record successfully updated.','lastid'=>$result);

    }else if($data['table'] == 'questions.php'){
        $o = new Questions();
        $columns = ['questionText'];

        $result = $o->getQuestionDetail($db,$data['id']);
        $newData = array();

        for ($i = 0; $i < count($data['values']) - 1; $i++) {
            $newdata[$columns[$i]] = $data['values'][$i];
        }

        $result = $o->editQuestion($db, $data['id'], $data['table'], $newdata);

        $response = array('notice' => 'Success!','msg' => 'Record successfully updated.','lastid'=>$result);
    }

    echo json_encode($response);
}
?>
