
<?php
include_once('host.php');
class MySqlConn {

    protected $_mysql;
    protected $_tableName;
    protected $_where;
    protected $_order;
    protected $_limit;

    public function __construct() {
        $this->_mysql = new mysqli(host, username, password, db)
                or die('not connect to sql');
       
    }
    public function where($prop,$value) {
        if (!empty($prop) && !empty($value)) {
            $this->_where = "WHERE $prop = '$value'";
        }
    }

    public function order($order, $sort) {
        if (!empty($order)) {
            $this->_order = "order by $order $sort";
        }
    }

    public function limit($value) {
        if (!empty($value)) {
            $this->_limit = "LIMIT $value";
        }
    }
    
    public function query($sql = '', $tableName = '') {
        if (!empty($sql)) {
            $sql = $sql;
        } else {
            $sql = 'SELECT * FROM';
        }
        
        $results = '';
        $this->_tableName = $tableName;
        $query = $this->_mysql->query('SET NAMES UTF8');
        $query = $this->_mysql->query("$sql $this->_tableName $this->_where
                 $this->_order $this->_limit");

        

        while ($row = $query->fetch_array()) {
            $results[] = $row;
        }
 
        return $results;
    }

    public function update($tableName, $data) {
        if (!empty($data)) {
            $keys = array_keys($data);

            $sql = "UPDATE $tableName SET ";
            for ($i = 0; $i < count($data); $i++) {
                if (is_string($data[$keys[$i]])) {
                    $sql .= $keys[$i] . "='" . $data[$keys[$i]] . "'";
                    if ($i != count($data) - 1) {
                        $sql .= ',';
                    }
                }
            }

            $sql .= $this->_where;

            if ($sql) {
                $query = $this->_mysql->query('SET NAMES UTF8');
                if( $this->_mysql->query($sql)){
                    return "success_update";
                } else{
                    return "error";
                }
            }
        }
    }
    public function delete($tableName)
    {
        if(!empty($tableName)){
        $sql = "delete from $tableName $this->_where";
        if($this->_mysql->query($sql)){
            return "success_delete";
        }else{
            return "error";
        }
        }
    }
    public function insert($tableName = " ", $data) {

        if (!empty($data)) {

            $keys = array_keys($data);
            $value = array_values($data);

            $sql = "INSERT INTO $tableName ";
            $sql .= "(";
            foreach ($keys AS $key => $k) {
                $sql .= $k;
                if ($key !== count($keys) - 1)
                    $sql .= ", ";
            }
            $sql .= ")";
            $sql .= "VALUES ";
            $sql .= "(";
            foreach ($value AS $val => $v) {
                $sql .= "'" . $v . "'";
                if ($val !== count($value) - 1)
                    $sql .= ",";
            }
            $sql .= ")";
            if ($sql) { 
                        $this->_mysql->query('SET NAMES UTF8');
                      if( $this->_mysql->query($sql)){
                          return "success_insert";
                      } else{
                          return "error";
                      }
          
            }
         
        }
  
    }

    public function num_rows($sql) { //หาจำนวนแถวแบบใส่ Query เอง
       
        $query = $this->_mysql->query("$sql");
        $results = mysqli_num_rows($query);

        return $results;
    }
    
  public function showmenu(){
    $Db = new MySqlConn;
    $department_sub_id=  $_SESSION['department_sub_id'];
    $user_name= $_SESSION['loginname'];
    $sql = $Db->query("SELECT * FROM hrd_accessoperation where accessname='ADMIN'","");
    foreach ($sql AS $row) {
           $group = explode(",", $row['department_sub_id_check']);
           $user = explode(",", $row['user_check']);
       }
      $arr_sess=array($department_sub_id,$user_name); //นำ session มาเปลี่ยนเป็น array
      $group= array_merge($group,$user);    //รวม array ใน modules ว่ากลุ่มหรือ user ถูกเพิ่มในตารางสิทธิ์นั้นๆ
      $result = array_intersect( $arr_sess,$group); // คำสั่ง ตรวจสอบชุด array ว่าตรงกันหรือไม่
      if($result){ //ถ้า array ตรงกันให้ส่งค่า ture
        return "show";
  }
}
   
//check access rule

    public function access($module=" ") {
        ?> 
    <script src="includes/sweet-alert/sweet-alert.js"></script>
    <?php
     $Db = new MySqlConn;
     $department_sub_id=  $_SESSION['department_sub_id'];
     $user_name= $_SESSION['loginname'];
       
       if($user_name){
        if($module==" "){
        return true;
        }else{
           //echo $department_sub_id;
         //  echo "<script language='javascript'>alert('555');</script>";
             $sql = $Db->query("SELECT * FROM hrd_accessoperation where accessname='".$module."'","");
      foreach ($sql AS $row) {
             $group = explode(",", $row['department_sub_id_check']);
             $user = explode(",", $row['user_check']);
         }
        $arr_sess=array($department_sub_id,$user_name); //นำ session มาเปลี่ยนเป็น array
        $group= array_merge($group,$user);    //รวม array ใน modules ว่ากลุ่มหรือ user ถูกเพิ่มในตารางสิทธิ์นั้นๆ
        $result = array_intersect( $arr_sess,$group); // คำสั่ง ตรวจสอบชุด array ว่าตรงกันหรือไม่
        if($result){ //ถ้า array ตรงกันให้ส่งค่า ture
            return true;
        }else{
         
           echo "<script language='javascript'>";
           echo "swal({
            title: 'คุณไม่สามารถเข้าหน้านี้ได้!',
            text: 'ถ้าหน้านี้เกี่ยวกับงานของท่านกรุณาติดต่อเจ้าหน้าที่',
            type: 'warning'
        }).then(function() {
            window.location = 'index.php';
        });";        
             //not showing an alert box.
           echo "</script>";
           exit();   
        }
        }
       }else{
      
        echo "<script> window.location.replace('login.php') </script>" ;
       }
     
    }

}









