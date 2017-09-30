<?php
class ResultTables{

    function __construct(){
    }

    function getResultTables($db){
        return $db->select()->from('resultTable')->fetch();
    }

    // function getTotalResultTables($db){
    //     $db->select()->from('ResultTable')->execute();
    //     return $db->affected_rows;
    // }

    function addResultTable($db,$data,$ResultTableText){

        $db->select()->from('ResultTable')->where('ResultTableText',$ResultTableText)->execute();
        if (($db->affected_rows)<1) {
            $id = $db->insert('ResultTable',$data);//returns the last id inserted
        }else{
            $id = 0;
        }
        return $id;
    }

    function editResultTable($db,$id,$tablename,$values){
        $t = explode('.',$tablename);//{'ResultTables','php'}
        $tn = substr($t[0],0,strlen($t[0]) - 1);
        $db->where('ResultTableID',$id)->update($tn,$values);

        return $id;
    }

    function deleteResultTable($db,$id,$tablename){
        $t = explode('.',$tablename);//{'users','php'}
        $tn = substr($t[0],0,strlen($t[0]) - 1);
        $db->delete("$tn")->where('ResultTableID',$id)->execute();

        return $id;
    }

}
