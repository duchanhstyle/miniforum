<?php
session_start();
ob_start();
    /*
     *
     * @ Forum 4C
     *
     * @ Created by Tí Nhí Nhố (tonghoai)
     *
     * @ Share
     *
     */
	 
	# Import thư viện
	include('incf/class.php');
	include('incf/func.php');
	require('incf/head.php');
	# Xử lý form submit
	if(isset($_POST['submit'])){
		
	#Lỗi nếu đã đăng nhập
        if(ID()){
echo'<div class="alert alert-dismissible alert-warning">
  <h4>Đăng nhập thất bại</h4>
  <p>Bạn đã đăng nhập trên hệ thống.</p>
</div>';
require('incf/foot.php');
exit;
        }
	# Kiểm tra sự tồn tại của 2 biến POST
		# Chuyển đến error_login nếu sai tên hoặc pass
		# Chuyển đến error_blank nếu để trống
		if(isset($_POST['username']) && isset($_POST['password'])){
			
			# Khởi tạo biến và kiểm tra đăng nhập
			# Class dangNhap
			$kiemTraDangNhap = new dangNhap();
			
			# Bắt đầu kiểm tra
			# checkID là kiểm tra
			# Trả về 1 là đúng, 0 là sai
			# Chuyển hướng trang về index nếu đúng và giữ lại nếu sai
			if($kiemTraDangNhap->checkID($_POST['username'], $_POST['password']) == 1){
				$_SESSION['userName'] = $_POST['username'];
				$_SESSION['passWord'] = $_POST['password'];
				header('Location: index.php');
			}
			else
			{


echo'<div class="alert alert-dismissible alert-warning">
  <h4>Đăng nhập thất bại</h4>
  <p>Tên tài khoản hoặc mật khẩu không chính xác, vui lòng thử lại.</p>
</div>';			}
		}
		else {

echo'<div class="alert alert-dismissible alert-warning">
  <h4>Đăng nhập thất bại</h4>
  <p>Không thể bỏ trống thông tin.</p>
</div>';

	}}else{

echo'<div class="alert alert-dismissible alert-warning">
  <h4>Đăng nhập thất bại</h4>
  <p>Không thể bỏ trống thông tin.</p>
</div>';
}

require('incf/foot.php');
?>