<?php
    $filepath = realpath(dirname(__FILE__));
    include_once ( $filepath.'/../lib/database.php');
    include_once  ($filepath.'/../helpers/format.php');
    ob_start();
?>

<?php
Class Cart{
    
    private $db;
    private $frm;


    public function __construct()
    {
        $this->db= new Database();
        $this->frm= new Format();
    }
    
    public function addtocart($id, $quantity) {
        $quantity = $this->frm->validation($quantity);
        $quantity = mysqli_real_escape_string($this->db->link, $quantity);
        $id = mysqli_real_escape_string($this->db->link, $id);
        $sId = session_id();
        
        // Lấy userId từ session hoặc một nguồn khác phù hợp
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    
        $query = "SELECT * FROM tbl_product WHERE productId = '$id' ";
        $result = $this->db->select($query);
    
        if ($result) {
            $row = $result->fetch_assoc();
            $image = $row['image'];
            $price = $row['price'];
            $productName = $row['productName'];
    
            $check_cart = "SELECT * FROM tbl_cart 
                           WHERE productId = '$id' AND sid = '$sId' AND userId = '$userId'";
            $resultcheck = $this->db->select($check_cart);
    
            if ($resultcheck) {
                $query = "UPDATE tbl_cart SET quantity = quantity + $quantity WHERE productId = '$id' AND sid = '$sId' AND userId = '$userId'";
                $this->db->update($query);
                $alert = "Sản phẩm đã được thêm vào giỏ hàng";
                return $alert;
            } else {
                $query_insert = "INSERT INTO tbl_cart (productId, sid, productName, price, quantity, image, userId) 
                                 VALUES ('$id', '$sId', '$productName', '$price', '$quantity', '$image', '$userId')";
                $insert_cart = $this->db->insert($query_insert);
                if ($insert_cart) {
                    header('location: cart.php');
                    exit();
                } else {
                    header('location: 404.php');
                }
            }
        } else {
            header('location: 404.php');
        }
    }
    
     public function getProductCart(){
        $userId = Session::get('user_id');
        $query="SELECT * FROM tbl_cart WHERE userId = '$userId' ";
        $result=$this->db->select($query);
        return $result;
    }
    public function updatequantityCart($quantity, $cartid) {
        $quantity = mysqli_real_escape_string($this->db->link, $quantity);
        $cartid = mysqli_real_escape_string($this->db->link, $cartid);
        $query = "UPDATE tbl_cart SET quantity ='$quantity' WHERE cartId = '$cartid' ";
        $result = $this->db->update($query);
        if ($result) {
            header('location: cart.php');
            exit();
        } else {
            $alert = "Lỗi";
            return $alert;
        }
    }
    public function deleteProCart($cartid) {
        $cartid = mysqli_real_escape_string($this->db->link, $cartid);
        $query = "DELETE FROM tbl_cart WHERE cartId = '$cartid' ";
        $result = $this->db->delete($query);
        if ($result) {
            header('location: cart.php');
            exit();
        } else {
            $alert = "Lỗi";
            return $alert;
        }
    }
    public function delAllCart(){
        $userId = Session::get('user_id');
        $query = "DELETE  FROM tbl_cart WHERE userId = '$userId' ";
        $result=$this->db->delete($query);
        return $result;
    }
    public function insertOder($userId) {
        $userId = Session::get('user_id');
        $query = "SELECT * FROM tbl_cart WHERE userId = '$userId' ";
        $getProduct = $this->db->select($query);
        if ($getProduct) {
            while ($result = $getProduct->fetch_assoc()) {
                $productid = $result['productId'];
                $productname = $result['productName'];
                $quantity = $result['quantity'];
                $price = $result['price'] * $quantity;
                $image = $result['image'];
                $user_Id = $userId;
                $dateOrder = date('Y-m-d H:i:s'); // Lấy thời gian hiện tại
    
                $query_insertOrder = "INSERT INTO tbl_order (productId, productName, userId, quantity, price, image, dateOrder) 
                    VALUES ('$productid', '$productname', '$user_Id', '$quantity', '$price', '$image', '$dateOrder')";
                $insertOrder = $this->db->insert($query_insertOrder);
                // }if($insertOrder){
    
                // }else{
    
                // }
            }
        }
    }
    
    public function getAmountPrice($userId){
        $query="SELECT * FROM tbl_order WHERE userId = '$userId'";
        $get_price= $this->db->select($query);
        return   $get_price;
    }
    public function getcartOdered($userId ){
        $query="SELECT * FROM tbl_order WHERE userId = '$userId'";
        $get_cart_order= $this->db->select($query);
        return   $get_cart_order;

    }
    public function getInboxCart(){
        $query="SELECT * FROM tbl_order ";
        $get_cart_order= $this->db->select($query);
        return   $get_cart_order;
    }
    public function shilfted($shiftId,$time,$price){
        $shiftId = mysqli_real_escape_string($this->db->link,$shiftId);
        $time = mysqli_real_escape_string($this->db->link,$time);
        $price = mysqli_real_escape_string($this->db->link,$price);
        $query = "UPDATE tbl_order SET Status = '1' WHERE id ='$shiftId' AND dateOrder='$time' AND Price = '$price' ";
        $result = $this->db->update($query);
        if($result){
            $alert="<span class='label label-success'>Cập nhật trạng thái thành công !!</span>";
            return $alert;
        }else{
            $alert="Lỗi";
            return $alert;
        }
    }
    public function delShift($shiftId,$time,$price){
        $shiftId = mysqli_real_escape_string($this->db->link,$shiftId);
        $time = mysqli_real_escape_string($this->db->link,$time);
        $price = mysqli_real_escape_string($this->db->link,$price);
        $query = "DELETE  FROM tbl_order WHERE id ='$shiftId' AND dateOrder='$time' AND Price = '$price' ";
        $result = $this->db->delete($query);
        if($result){
            $alert="<span class='label label-success'>Xóa thành công !!</span>";
            return $alert;
        }else{
            $alert="Lỗi";
            return $alert;
        }
    }
    public function shiftConfirm($id,$time,$price){
        $shiftId = mysqli_real_escape_string($this->db->link,$id);
        $time = mysqli_real_escape_string($this->db->link,$time);
        $price = mysqli_real_escape_string($this->db->link,$price);
        $query = "UPDATE tbl_order SET Status = '2' WHERE userId ='$shiftId' AND dateOrder='$time' AND Price = '$price' ";
        $result = $this->db->update($query);
        if($result){
            $alert="<span class='label label-success'>Cập nhật trạng thái thành công !!</span>";
            return $alert;
        }else{
            $alert="Lỗi";
            return $alert;
        }
    }
    
}

?>