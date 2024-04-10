<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . "/../lib/database.php");
include_once($filepath . "/../helpers/format.php");

?>
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
<?php
class Brand{
   private $db;
   private $fm;
   public function __construct()
   {
      $this->db = new Database();   
      $this->fm = new Format();   
   }
   public function insert_brand($brandName) {
      $brandName = $this->fm->validation($brandName);
      $brandName = mysqli_real_escape_string($this->db->link, $brandName);

      if (empty($brandName)) {
         $alert = "<script>toastr.error('Brand must not be empty');</script>";
         return $alert;
      } else {
         $query = "INSERT INTO tbl_brand(brandName) VALUE ('$brandName')" ;
         $result = $this->db->insert($query);
      }
      if ($result){
         $alert = "<script>toastr.success('Insert Brand Successfully', '', { onHidden: function() { window.location = 'brandlist.php'; } });</script>";
         return $alert;
      } else {
         $alert = "<script>toastr.error('Failed to insert brand');</script>";
         return $alert;
      }
   }
   public function getBrands() {
    $query = "SELECT * FROM tbl_brand ";
    $result = $this->db->select($query);
    return $result;
 }
 
 public function update_brand($brandName, $id) {
   $brandName = $this->fm->validation($brandName);
   $brandName = mysqli_real_escape_string($this->db->link, $brandName);
   $id = mysqli_real_escape_string($this->db->link, $id);

   if(empty($brandName)) {
       $alert = "<script>toastr.error('Brand must not be empty');</script>";
       return $alert;
   } else {
       $query = "UPDATE tbl_brand SET brandName = '$brandName' WHERE brandId = '$id'";
       $result = $this->db->update($query);
       if($result) {
           $alert = "<script>toastr.success('Brand Updated Successfully', '', { onHidden: function() { window.location = 'brandlist.php'; } });</script>";
           return $alert;
       } else {
           $alert = "<script>toastr.error('Brand Updated Not Success');</script>";
           return $alert;
       }
   }
}

public function getBrandById($id) {
   $query = "SELECT * FROM tbl_brand WHERE brandId = '$id'";
   $result = $this->db->select($query);
   return $result;
}

public function del_brand($id) {
   $query = "DELETE FROM tbl_brand WHERE brandId = '$id'";
   $result = $this->db->delete($query);
   if($result) {
       $alert = "<script>toastr.success('Brand Deleted Successfully');</script>";
       return $alert;
   } else {
       $alert = "<script>toastr.error('Brand Deleted Not Success');</script>";
       return $alert;
   }
}
public function get_product_by_brand($id) {
   $query = "SELECT * FROM tbl_product WHERE brandId = '$id' ORDER BY brandId DESC LIMIT 8";
   $result = $this->db->select($query);
   return $result;
}

public function get_brand_name($id) {
   $query = "SELECT tbl_product.*, tbl_brand.brandName, tbl_brand.brandId FROM tbl_product, tbl_brand WHERE tbl_product.brandId = tbl_brand.brandId AND tbl_product.brandId = '$id'";
   $result = $this->db->select($query);
   return $result;
}

}
?>