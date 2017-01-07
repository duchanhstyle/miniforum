<?php
session_start();

	# Import thư viện
	include('incf/class.php');
	include('incf/func.php');
	
	# Kiểm tra xem đã đăng nhập chưa
	if(!ID()){
		if(isset($_POST['submit'])){
			
			# Gọi class kiểm tra user đã tồn tại?
			$IDUser = new userID();
			# Kiểm tra các lỗi
			if(empty($_POST['username']) || empty($_POST['password']) || empty($_POST['password2']) || empty($_POST['answer']))
				$error = '<center><div class="alert alert-dismissible alert-warning"><strong>Chú ý:</strong> Không được bỏ trống bất kì ô nào</div></center>';
			elseif(preg_match('/[^\da-z\-\@\*\(\)\?\!\~\_\=\[\]]+/', mb_strtolower(trim($_POST['username']))))
				$error = '<center><div class="alert alert-dismissible alert-danger"><strong>Lỗi:</strong> Tên đăng nhập chứa kí tự không hợp lệ</div></center>';
			elseif($IDUser->checkUser($_POST['username']) > 0)
				$error = '<center><div class="alert alert-dismissible alert-danger"><strong>Lỗi:</strong> Người dùng này đã tồn tại</div></center>';
			elseif($_POST['password'] != $_POST['password2'])
				$error = '<center><div class="alert alert-dismissible alert-danger"><strong>Lỗi:</strong> Nhập lại Mật Khẩu không khớp</div></center>';
			elseif($_SESSION['answer'] != $_POST['answer'])
				$error = '<center><div class="alert alert-dismissible alert-danger"><strong>Lỗi:</strong> Mã xác nhận không đúng, kết quả đúng là '.$_SESSION['answer'].'</div></center>';
			else
			{
				
				# Thêm người mới
				# Sủ dụng class truyVan để insert data
				# biến DB
				#
				$DB = new truyVan();
				$count = $DB->insert('users', array(
							 'userName' 	  => str_replace(' ', '', trim($_POST['username'])),
							 'passWord' 	  => str_replace(' ', '', $_POST['password']),
							 'nickName'		  => mb_strtolower(trim($_POST['username'])),
							 'status'		  => 'iForum',
							 'rights'  		  => '0',
							 'poin'  		  => '0',
							 'timeOnline'     => time()
				));
				
				# Tạo lệnh để tạo avatar cho user mới

$im = imagecreatetruecolor(65, 65); // Chiuề rộng và chiều cao
$color1 = rand(0,900);
$color2 = rand(0,900);
$color3 = rand(0,900);
$background = @imagecolorallocate($im, $color1,$color2,$color3); // Màu nền
$white = @imagecolorallocate($im, 255, 255, 255); // Màu chữ
@imagefilledrectangle($im, 0, 0, 65, 65, $background); // Tạo ảnh nền
$text = substr($_POST['username'],0,1); // Text
$text = ucfirst($text);
$font = 'css/font.ttf'; // Font chữ
$save_name = 'users/avatar/'.$count.'.png';
@imagettftext($im, 45, 0, 16, 56, $white, $font, $text);
@imagepng($im, $save_name);
imagedestroy($im);

				# Hủy các class
				unset($DB);
				unset($IDUser);
				
				# Chuyển hướng
				header('Location: index.php?act=success');
			exit;
			}
		}
		
		require('incf/head.php');

                # mã xác nhận

    $digit1 = mt_rand(1,8);
    $digit2 = mt_rand(1,4);
    if( mt_rand(0,1) === 1 ) {
            $math = "$digit1 + $digit2";
            $_SESSION['answer'] = $digit1 + $digit2;
    } else {
            $math = "$digit1 - $digit2";
            $_SESSION['answer'] = $digit1 - $digit2;
    }

		
		# Hiển thị lỗi form nếu có
		if(isset($error)) echo $error;
		
		
		# Hiển thị form
		echo '<a href="forum/index.php"><label class="control-label"><span class="glyphicon glyphicon-user" aria-hidden="false"></span> Đăng ký thành viên</label></a><div id="main" ng-app="reg" ng-controller="RegisterCtrl">' .
			 '<form class="form-horizontal" action="registration.php" method="post" name="form" ng-submit="register()" novalidate>' .
			 '<div class="col-lg-6">' .
			 '<div class="form-group">' .
			 '<input name="username" type="text" class="form-control" placeholder="Tên đăng nhập" ng-model="fullname" ng-minlength="6" ng-maxlength="50" required>' .
			 '</div>' .
			 '<div class="form-group">' .
			 '<input name="password" ng-model="password" type="password" class="form-control" placeholder="Mật Khẩu" ng-minlength="6" ng-maxlength="30" required>' .
			 '</div>' .
			 '<div class="form-group">' .
			 '<input name="password2" ng-model="password2" type="password" class="form-control" placeholder="Nhập Lại Mật Khẩu" ng-minlength="6" ng-maxlength="30" required>' .
			 '</div>' .

			 '<div class="form-group">' .
			 '<input name="answer" ng-model="answer" type="text" class="form-control" placeholder="'.$math.'=?" ng-minlength="1" ng-maxlength="3" required>' .
			 '</div>' .

			 '<div class="form-group">' .
             '<button type="submit" name="submit" class="btn btn-primary">Đăng ký</button>' .
			 '</div>' .
			 '</form>' .
			 '</div></div>';
	}
	
	# Tiếp foot
	require('incf/foot.php');
	
	
?>