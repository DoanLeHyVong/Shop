<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . "/../lib/database.php");
include_once($filepath . "/../helpers/format.php");
include_once($filepath . "/../lib/session.php");
Session::init(); 


?>

<?php
class User{
   private $db;
   private $fm;
   public function __construct()
   {
      $this->db = new Database();   
      $this->fm = new Format();   
   }
   public function insertUser($data){
    $username = mysqli_real_escape_string($this->db->link, $data['username']);
    $address = mysqli_real_escape_string($this->db->link, $data['address']);
    $username = mysqli_real_escape_string($this->db->link, $data['username']);
    $phone = mysqli_real_escape_string($this->db->link, $data['phone']);
    $password = mysqli_real_escape_string($this->db->link, md5($data['password']));

    if($username == "" ||  $password == "" || $username == "" || $address == "" || $phone == ""){
        $arlet = "<span class='label label-danger'>Không được để trống !!</span>";
        return $arlet;
    } else {
        $check_username = "SELECT * FROM tbl_users WHERE Username = '$username'";
        $result = $this->db->select($check_username);
        if($result){
            $arlet = "<span class='label label-danger'>Tên đăng nhập đã tồn tại !!</span>";
            return $arlet;
        } else {
            $query="INSERT INTO `tbl_users`(Username, Address, username, Phone, Password)
                    VALUES ('$username', '$address', '$username', '$phone', '$password')";
            $result = $this->db->insert($query);
            if($result != false){
                $arlet = "<span class='label label-success'>Đăng ký thành công !!</span>";
                // Chuyển hướng người dùng sau khi đăng ký thành công
                header("location: login.php");
                exit(); // Kết thúc kịch bản sau khi chuyển hướng
            } else {
                $arlet = "Lỗi ";
                return $arlet;
            }
        }
    }
}
public function loginUser($data) {
    $username = mysqli_real_escape_string($this->db->link, $data['username']);
    $password = mysqli_real_escape_string($this->db->link, md5($data['password']));
    
    if ($username == '' || $password == '') {
        $alert = "<span class='error'>Password and username must not be empty</span>";
        return $alert;
    } else {
        $check_login = "SELECT * FROM tbl_users WHERE username = '$username' AND password = '$password'";
        $result_check = $this->db->select($check_login);
        
        if ($result_check) {
            $value = $result_check->fetch_assoc();
            Session::set('user_login', true);
            Session::set('user_id', $value['id']);
            Session::set('user_name', $value['name']);
            header('Location: index.php');
            exit(); 
        } else {
            $alert = "<span class='error'>Username or Password doesn't match</span>";
            return $alert;
        }
    }
}
public function getAllUser($id) {
    $query = "SELECT * FROM tbl_users WHERE id = '$id'";
    $result=$this->db->select($query);
    return $result;

}
}
?>