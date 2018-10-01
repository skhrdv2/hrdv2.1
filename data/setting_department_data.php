<?php
include_once('../lib/config.inc.php');
$Db = new MySqlConn; 
if($_POST['req']=='req'){  //เรียกข้อมูล
$sql="SELECT hd.department_name,hd.department_id,
concat(hp.fname,'  ',hp.lname) as head_department,
hd.department_tel,hd.department_status,hd.last_update
from hrd_department hd
LEFT OUTER JOIN hrd_person hp on hp.person_id=hd.head_department
ORDER BY hd.department_id desc";
                $sql = $Db->query($sql,'');
               $data = array();
        foreach ($sql as $row ) {
            $data[] = $row ;
        }
                $response = array(
        "data" => $data
    );	
    echo json_encode($response);   
}else if($_POST['acc']=="save"){ //บันทึก
    $data = array(
     "department_name"=>$_POST['department_name'], 
     "department_tel"=>$_POST['department_tel'],
     "department_status"=>$_POST['department_status'], 
     "department_head_cid"=>$_POST['department_head_cid'],
     "head_department"=>$_POST['person_id_search'],
    
 );
$resualt=$Db->insert('hrd_department',$data);
if($resualt=="success_insert"){
 $msg=array(
     "m"=>$resualt
 );
}else{
   $msg=array(
     "m"=>$resualt
   ) ; 
}
 echo json_encode($msg);

}else if($_POST['acc']=="edit"){ //แก้ไข
    $data = array(
     "department_name"=>$_POST['department_name'], 
     "department_status"=>$_POST['department_status'], 
     "department_head_cid"=>$_POST['department_head_cid'],
     "head_department"=>$_POST['person_id_search'],
     "department_tel"=>$_POST['department_tel']
 );
 $Db->where('department_id',$_POST['department_id']);
$resualt=$Db->update('hrd_department',$data);
if($resualt=="success_update"){
 $msg=array(
     "m"=>$resualt
 );
}else{
   $msg=array(
     "m"=>$resualt
   ) ; 
}
 echo json_encode($msg);

}elseif($_POST['acc']=="delete"){ //ลบ
 $Db->where('department_id',$_POST['sql']);
 $resualt=$Db->delete('hrd_department');
 if($resualt=="success_delete"){
    $msg=array(
        "m"=>$resualt
    );
   }else{
      $msg=array(
        "m"=>$resualt
      ) ; 
   }
    echo json_encode($msg);
}elseif($_POST['acc']=="query_edit"){ //เรียกข้อมูลมาแก้ไข
 
      $Db->where('department_id',$_POST['sql']);
 $sql = $Db->query("","hrd_department");
             $a_data=array();
           foreach ($sql as $row){
                  array_push($a_data,$row);	
                  
              }
 echo json_encode($row);
}
   



     ?>

