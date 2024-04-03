<?php
include_once "../lib/database.php";
include_once "../helpers/format.php";
?>
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
<?php
class Category{
   private $db;
   private $fm;
   public function __construct()
   {
      $this->db = new Database();   
      $this->fm = new Format();   
   }
   public function insert_category($catName) {
      $catName = $this->fm->validation($catName);
      $catName = mysqli_real_escape_string($this->db->link, $catName);

      if (empty($catName)) {
         $alert = "<script>toastr.error('Category must not be empty');</script>";
         return $alert;
      } else {
         $query = "INSERT INTO tbl_category(catName) VALUE ('$catName')" ;
         $result = $this->db->insert($query);
      }
      if ($result){
         $alert = "<script>toastr.success('Insert Category Successfully', '', { onHidden: function() { window.location = 'catlist.php'; } });</script>";
         return $alert;
      } else {
         $alert = "<script>toastr.error('Failed to insert category');</script>";
         return $alert;
      }
   }
   public function getCategories() {
    $query = "SELECT * FROM tbl_category ";
    $result = $this->db->select($query);
    return $result;
 }
 public function update_category($catName, $id) {
   $catName = $this->fm->validation($catName);
   $catName = mysqli_real_escape_string($this->db->link, $catName);
   $id = mysqli_real_escape_string($this->db->link, $id);

   if(empty($catName)) {
       $alert = "<script>toastr.error('Category must not be empty');</script>";
       return $alert;
   } else {
       $query = "UPDATE tbl_category SET catName = '$catName' WHERE catId = '$id'";
       $result = $this->db->update($query);
       if($result) {
           $alert = "<script>toastr.success('Category Updated Successfully', '', { onHidden: function() { window.location = 'catlist.php'; } });</script>";
           return $alert;
       } else {
           $alert = "<script>toastr.error('Category Updated Not Success');</script>";
           return $alert;
       }
   }
}

public function getcatbyId($id) {
   $query = "SELECT * FROM tbl_category WHERE catId = '$id'";
   $result = $this->db->select($query);
   return $result;
}

public function del_category($id) {
   $query = "DELETE FROM tbl_category WHERE catId = '$id'";
   $result = $this->db->delete($query);
   if($result) {
       $alert = "<script>toastr.success('Category Deleted Successfully');</script>";
       return $alert;
   } else {
       $alert = "<script>toastr.error('Category Deleted Not Success');</script>";
       return $alert;
   }
}

}
?>