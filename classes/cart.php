<?php
    $filepath = realpath(dirname(__FILE__));
    include_once ( $filepath.'/../lib/database.php');
    include_once  ($filepath.'/../helpers/format.php');
    ob_start();
?>
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
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
    
        // Lấy thông tin sản phẩm từ bảng tbl_product
        $query_product = "SELECT * FROM tbl_product WHERE productId = '$id' ";
        $result_product = $this->db->select($query_product);
    
        if ($result_product) {
            $row_product = $result_product->fetch_assoc();
            $stock = $row_product['quantity'];
            $productName = $row_product['productName'];
            $image = $row_product['image'];
            $price = $row_product['price'];
    
            // Kiểm tra xem số lượng trong kho có đủ để thêm vào giỏ hàng không
            if ($stock >= $quantity) {
                // Số lượng đủ, tiếp tục thêm sản phẩm vào giỏ hàng
                $query_cart = "SELECT * FROM tbl_cart WHERE productId = '$id' AND sid = '$sId' AND userId = '$userId'";
                $result_cart = $this->db->select($query_cart);
    
                if ($result_cart) {
                    // Sản phẩm đã tồn tại trong giỏ hàng, cập nhật số lượng
                    $query_update = "UPDATE tbl_cart SET quantity = quantity + $quantity WHERE productId = '$id' AND sid = '$sId' AND userId = '$userId'";
                    $this->db->update($query_update);
                    $alert = "Sản phẩm đã được thêm vào giỏ hàng";
                    return $alert;
                } else {
                    // Thêm sản phẩm mới vào giỏ hàng
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
                $alert = "<script>alert('Số lượng không đủ');</script>";
                return $alert;
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
    
        // Lấy thông tin sản phẩm từ giỏ hàng
        $query_cart = "SELECT * FROM tbl_cart WHERE cartId = '$cartid'";
        $result_cart = $this->db->select($query_cart);
    
        if ($result_cart) {
            $row_cart = $result_cart->fetch_assoc();
            $productId = $row_cart['productId'];
            $sId = $row_cart['sId'];
            $userId = $row_cart['userId'];
    
            // Lấy thông tin sản phẩm từ bảng tbl_product
            $query_product = "SELECT * FROM tbl_product WHERE productId = '$productId'";
            $result_product = $this->db->select($query_product);
    
            if ($result_product) {
                $row_product = $result_product->fetch_assoc();
                $stock = $row_product['quantity'];
    
                // Lấy tổng số lượng sản phẩm trong giỏ hàng
                $query_cart_quantity = "SELECT SUM(quantity) AS total_quantity FROM tbl_cart WHERE productId = '$productId' AND sid = '$sId' AND userId = '$userId'";
                $result_cart_quantity = $this->db->select($query_cart_quantity);
                $row_cart_quantity = $result_cart_quantity->fetch_assoc();
                $cart_quantity = $row_cart_quantity['total_quantity'];
    
                // Tính toán số lượng mới sau khi cập nhật
                $total_quantity = $cart_quantity - $row_cart['quantity'] + $quantity;
    
                // Kiểm tra xem có đủ số lượng sản phẩm để cập nhật không
                if ($total_quantity <= $stock) {
                    $query_update = "UPDATE tbl_cart SET quantity ='$quantity' WHERE cartId = '$cartid'";
                    $result_update = $this->db->update($query_update);
                    if ($result_update) {
                        header('location: cart.php');
                        exit();
                    } else {
                        $alert = "Lỗi";
                        return $alert;
                    }
                } else {
                    // Số lượng không đủ, in ra thông báo
                    $alert = "<script>alert('Số lượng không đủ');</script>";
                    return $alert;
                }
            } else {
                // Không tìm thấy thông tin sản phẩm
                header('location: 404.php');
            }
        } else {
            // Không tìm thấy thông tin giỏ hàng
            header('location: 404.php');
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
    public function handleOrderSuccess() {
        $userId = Session::get('user_id');
    
        // Lấy thông tin các sản phẩm đã được đặt từ bảng tbl_order
        $query = "SELECT productId, quantity FROM tbl_order WHERE userId = '$userId'";
        $result = $this->db->select($query);
    
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $productId = $row['productId'];
                $quantityOrdered = $row['quantity'];
    
                // Cập nhật số lượng sản phẩm trong bảng tbl_product
                $query_update = "UPDATE tbl_product SET quantity = quantity - $quantityOrdered WHERE productId = '$productId'";
                $this->db->update($query_update);
            }
    
            // Xóa đơn hàng đã được xử lý từ bảng tbl_order
            $query_delete = "DELETE FROM tbl_order WHERE userId = '$userId'";
            $this->db->delete($query_delete);
        }
    }

    public function handleMomo($data){
        $orderId = mysqli_real_escape_string($this->db->link, $data['orderId']);
        $requestId = mysqli_real_escape_string($this->db->link, $data['requestId']);
        $amount = mysqli_real_escape_string($this->db->link, $data['amount']);
        $orderInfo = mysqli_real_escape_string($this->db->link, $data['orderInfo']);
        $orderType = mysqli_real_escape_string($this->db->link, $data['orderType']);
        $transId = mysqli_real_escape_string($this->db->link, $data['transId']);
        $resultCode = mysqli_real_escape_string($this->db->link, $data['resultCode']);
        $message = mysqli_real_escape_string($this->db->link, $data['message']);
        $payType = mysqli_real_escape_string($this->db->link, $data['payType']);
        $responseTime = mysqli_real_escape_string($this->db->link, $data['responseTime']);
        $paymentOption = mysqli_real_escape_string($this->db->link, $data['paymentOption']);
        $query = "INSERT INTO momo_response (orderId, requestId, amount, orderInfo, orderType, transId, resultCode,message,payType,responseTime,paymentOption) 
                    VALUES ('$orderId', '$requestId', '$amount', '$orderInfo', '$orderType', '$transId', '$resultCode','$message','$payType','$responseTime','$paymentOption')";
                $handleMomo = $this->db->insert($query);
    }
    
    
}

?>