<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . "/../lib/database.php");
include_once($filepath . "/../helpers/format.php");
?>
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
<?php
class Cart{
   private $db;
   private $fm;
   public function __construct()
   {
      $this->db = new Database();   
      $this->fm = new Format();   
   }
   public function add_to_cart($quantity, $id){
    $quantity = $this->fm->validation($quantity);
    $quantity = mysqli_real_escape_string($this->db->link, $quantity);
    $id = mysqli_real_escape_string($this->db->link, $id);
    $sId = session_id();

    $check_query = "SELECT * FROM tbl_cart WHERE productId = '$id' AND sId = '$sId'";
    $check_result = $this->db->select($check_query);
    if ($check_result) {
        $cart_item = $check_result->fetch_assoc();
        $new_quantity = $cart_item['quantity'] + $quantity;
        $update_query = "UPDATE tbl_cart SET quantity = '$new_quantity' WHERE productId = '$id' AND sId = '$sId'";
        $this->db->update($update_query);
    } else {
        $query = "SELECT * FROM tbl_product WHERE productId = '$id'";
        $result = $this->db->select($query);
        if ($result) {
            $row = $result->fetch_assoc();
            $image = $row["image"];
            $price = $row["price"];
            $productName = $row["productName"];
            $query_insert = "INSERT INTO tbl_cart(productId, quantity, sId, image, price, productName) VALUES ('$id', '$quantity', '$sId', '$image', '$price', '$productName')";
            $insert_cart = $this->db->insert($query_insert);
            if ($insert_cart) {
                header('Location: cart.php');
            } else {
                header('Location: 404.php');
            }
        } else {
            header('Location: 404.php');
        }
    }
}

    public function get_product_cart(){
    $sId = session_id();
    $query = "SELECT * FROM tbl_cart WHERE sId = '$sId'";
    $result = $this->db->select($query);
    return $result;
}
public function update_quantity($productId, $quantity) {
    $productId = mysqli_real_escape_string($this->db->link, $productId);
    $quantity = mysqli_real_escape_string($this->db->link, $quantity);
    $sId = session_id();
    $check_query = "SELECT * FROM tbl_cart WHERE productId = '$productId' AND sId = '$sId'";
    $check_result = $this->db->select($check_query);
    if ($check_result) {
        $update_query = "UPDATE tbl_cart SET quantity = '$quantity' WHERE productId = '$productId' AND sId = '$sId'";
        $this->db->update($update_query);
        return true; 
    } else {
        return false; 
    }
}

public function delete_product($productId) {
    $productId = mysqli_real_escape_string($this->db->link, $productId);
    $sId = session_id();

    // Xóa sản phẩm khỏi giỏ hàng
    $delete_query = "DELETE FROM tbl_cart WHERE productId = '$productId' AND sId = '$sId'";
    $delete_result = $this->db->delete($delete_query);
    if ($delete_result) {
        return true; // Trả về true nếu xóa thành công
    } else {
        return false; // Trả về false nếu xóa không thành công
    }
}


}
?>