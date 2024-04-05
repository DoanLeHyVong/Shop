<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . "/../lib/database.php");
include_once($filepath . "/../helpers/format.php");
?>
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
<?php
class User{
   private $db;
   private $fm;
   public function __construct()
   {
      $this->db = new Database();   
      $this->fm = new Format();   
   }
   public function insert_product($data,$file) {
    $productName = mysqli_real_escape_string($this->db->link, $data['productName']);
    $category = mysqli_real_escape_string($this->db->link, $data['category']);
    $brand = mysqli_real_escape_string($this->db->link, $data['brand']);
    $product_desc = mysqli_real_escape_string($this->db->link, $data['product_desc']);
    $price = mysqli_real_escape_string($this->db->link, $data['price']);
    $type = mysqli_real_escape_string($this->db->link, $data['type']);

    $permited = array('jpg', 'jpeg', 'png', 'gif');
    $file_name = $_FILES['image']['name'];
    $file_size = $_FILES['image']['size'];
    $file_temp = $_FILES['image']['tmp_name'];
    $div = explode('.', $file_name);
    $file_ext = strtolower(end($div));
    $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
    $uploaded_image = "uploads/" . $unique_image;
    

    if(empty($productName) || empty($brand) || empty($category) || empty($product_desc) || empty($price) || empty($type) || 
    empty($file_name)) {
      $alert = "<script>toastr.error('Fields  must not be empty');</script>";
      return $alert;
  } else {
      move_uploaded_file($file_temp, $uploaded_image);
      $query = "INSERT INTO tbl_product(productName, brandId, catId, product_desc, price, type, image) VALUES ('$productName', 
      '$brand', '$category', '$product_desc', '$price', '$type', '$unique_image')";
      $result = $this->db->insert($query);
      if($result) {
          $alert = "<script>toastr.success('Insert Product Successfully');</script>";
          return $alert;
      } else {
          $alert = "<script>toastr.error('Insert Product Not Success');</script>";
          return $alert;
      }
  }
}
    
public function getProducts() {
    $sql = "SELECT p.*, c.catName, b.brandName
    FROM tbl_product p
    INNER JOIN tbl_category c ON p.catId = c.catId
    INNER JOIN tbl_brand b ON p.brandId = b.brandId
    " ;
    $result = $this->db->select($sql);
    return $result;
}

public function update_product($productName, $categoryId, $brandId, $productDesc, $type, $price, $id) {
    // Validate and sanitize input data
    $productName = $this->fm->validation($productName);
    $productName = mysqli_real_escape_string($this->db->link, $productName);
    $categoryId = mysqli_real_escape_string($this->db->link, $categoryId);
    $brandId = mysqli_real_escape_string($this->db->link, $brandId);
    $productDesc = $this->fm->validation($productDesc);
    $productDesc = mysqli_real_escape_string($this->db->link, $productDesc);
    $type = mysqli_real_escape_string($this->db->link, $type);
    $price = mysqli_real_escape_string($this->db->link, $price);
    $id = mysqli_real_escape_string($this->db->link, $id);

    // Check if productName is empty
    if(empty($productName)) {
        $alert = "<script>toastr.error('Product name must not be empty');</script>";
        return $alert;
    } else {
        // Update the product in the database
        $query = "UPDATE tbl_product SET productName = '$productName', catId = '$categoryId', brandId = '$brandId', product_desc = '$productDesc', type = '$type', price = '$price' WHERE productId = '$id'";
        $result = $this->db->update($query);
        if($result) {
            $alert = "<script>toastr.success('Product Updated Successfully', '', { onHidden: function() { window.location = 'productlist.php'; } });</script>";
            return $alert;
        } else {
            $alert = "<script>toastr.error('Product Update Not Successful');</script>";
            return $alert;
        }
    }
}


public function getProductById($id) {
    $query = "SELECT * FROM tbl_product WHERE productId = '$id'";
    $result = $this->db->select($query);
    return $result;
}


public function del_product($id) {
    $query = "DELETE FROM tbl_product WHERE productId = '$id'";
    $result = $this->db->delete($query);
    if($result) {
        $alert = "<script>toastr.success('Product Deleted Successfully');</script>";
        return $alert;
    } else {
        $alert = "<script>toastr.error('Product Deletion Not Successful');</script>";
        return $alert;
    }
}
}
?>