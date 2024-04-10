<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . "/../lib/database.php");
include_once($filepath . "/../helpers/format.php");
?>
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
<?php
class Product{
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
    $quantity = mysqli_real_escape_string($this->db->link, $data['quantity']);

    $permited = array('jpg', 'jpeg', 'png', 'gif');
    $file_name = $_FILES['image']['name'];
    $file_size = $_FILES['image']['size'];
    $file_temp = $_FILES['image']['tmp_name'];
    $div = explode('.', $file_name);
    $file_ext = strtolower(end($div));
    $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
    $uploaded_image = "admin/uploads/" . $unique_image;
    
// ai lai xu li $type the nay. empty no nhan 0 la rong tra ve true dung roi
    if(empty($productName) || empty($brand) || empty($category) || empty($product_desc) || empty($price) || 
    empty($file_name) ||empty($quantity)) {
        $alert = "<script>toastr.error('Fields must not be empty');</script>";
        return $alert;
    } else if( $type != 0 && $type != 1 ) {
        $alert = "<script>toastr.error('Invalid type');</script>";
        return $alert;
    } else {
        move_uploaded_file($file_temp, $uploaded_image);
        $query = "INSERT INTO tbl_product(productName, brandId, catId, product_desc, price, type, image,quantity) VALUES ('$productName', 
        '$brand', '$category', '$product_desc', '$price', $type, '$unique_image','$quantity')"; // Loại bỏ dấu nháy xung quanh $type
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
    ORDER BY p.productId ASC" ; // Sắp xếp theo ID tăng dần
    $result = $this->db->select($sql);
    return $result;
}


public function update_product($productName, $categoryId, $brandId, $productDesc, $type, $price, $id, $quantity, $image) {
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
    $quantity = mysqli_real_escape_string($this->db->link, $quantity);

    // Check if productName is empty
    if (empty($productName)) {
        $alert = "<script>toastr.error('Product name must not be empty');</script>";
        return $alert;
    } else {
        // Check if a new image is uploaded
        if ($_FILES['image']['name']) {
            // Upload new image
            $permited = array('jpg', 'jpeg', 'png', 'gif');
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_temp = $_FILES['image']['tmp_name'];

            $div = explode('.', $file_name);
            $file_ext = strtolower(end($div));
            $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
            $uploaded_image = "admin/uploads/" . $unique_image;

            if ($file_size > 1048567) {
                $alert = "<script>toastr.error('Image Size should be less than 1MB');</script>";
                return $alert;
            } elseif (in_array($file_ext, $permited) === false) {
                $alert = "<script>toastr.error('You can upload only:-" . implode(', ', $permited) . "');</script>";
                return $alert;
            } else {
                move_uploaded_file($file_temp, $uploaded_image);

                // Update the product with the new image
                $query = "UPDATE tbl_product SET productName = '$productName', catId = '$categoryId', brandId = '$brandId', product_desc = '$productDesc', type = '$type', price = '$price', quantity='$quantity', image = '$unique_image' WHERE productId = '$id'";
                $result = $this->db->update($query);
                if ($result) {
                    $alert = "<script>toastr.success('Product Updated Successfully', '', { onHidden: function() { window.location = 'productlist.php'; } });</script>";
                    return $alert;
                } else {
                    $alert = "<script>toastr.error('Product Update Not Successful');</script>";
                    return $alert;
                }
            }
        } else {
            // Update the product without changing the image
            $query = "UPDATE tbl_product SET productName = '$productName', catId = '$categoryId', brandId = '$brandId', product_desc = '$productDesc', type = '$type', price = '$price', quantity='$quantity' WHERE productId = '$id'";
            $result = $this->db->update($query);
            if ($result) {
                $alert = "<script>toastr.success('Product Updated Successfully', '', { onHidden: function() { window.location = 'productlist.php'; } });</script>";
                return $alert;
            } else {
                $alert = "<script>toastr.error('Product Update Not Successful');</script>";
                return $alert;
            }
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

        #USER
        public function getproduct_feathered() {
            $query = "SELECT * FROM tbl_product WHERE type = '0'";
            $result = $this->db->select($query);
            return $result;
        }
        public function getproduct_new() {
            $query = "SELECT * FROM tbl_product ORDER BY productId DESC LIMIT 4";
            $result = $this->db->select($query);
            return $result;
        }
        public function get_details($id) {
            $sql = "SELECT p.*, c.catName, b.brandName
                    FROM tbl_product p
                    INNER JOIN tbl_category c ON p.catId = c.catId
                    INNER JOIN tbl_brand b ON p.brandId = b.brandId
                    WHERE p.productId ='$id'";
            $result = $this->db->select($sql);
            return $result;
        }
}
?>