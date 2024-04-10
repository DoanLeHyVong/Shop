$(document).ready(function () {
  // Bắt sự kiện khi người dùng thay đổi số lượng sản phẩm
  $("form").on("submit", function (event) {
    event.preventDefault(); // Ngăn chặn hành động mặc định của form

    var form = $(this);
    var formData = form.serialize(); // Chuyển đổi dữ liệu form thành chuỗi

    $.ajax({
      type: form.attr("method"),
      url: form.attr("action"),
      data: formData,
      success: function (response) {
        // Nếu cập nhật thành công, cập nhật lại giao diện người dùng
        location.reload();
      },
    });
  });
});
