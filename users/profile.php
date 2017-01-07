<?php

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
	include('../incf/class.php');
	include('../incf/func.php');
	
	# Kiểm tra thành viên
	if(!ID()){
		$headtitle = 'Lỗi';
		require('../incf/head.php');
		echo err_r();
		require('../incf/foot.php');
		exit;
	}
	
	# Xử lý nếu nhận thấy id
	if(isset($_GET['id'])){
		
		# Khởi tạo class userID
		$IDUser = new userID();
		
		# Nếu ID không tồn tại
		if($IDUser->checkInfoID($_GET['id']) == 0){
			$headtitle = 'Lỗi';
			require('../incf/head.php');
			echo err_u();
			require('../incf/foot.php');
			exit;
		}
		
		# Khi ID chính là bạn
		# dùng class UserID với function getInfoID() để lấy thông tin
		# hiển thị các thông tin cá nhân
		if($_GET['id'] == $IDUser->getInfoID('id', $id)){
			# Chèn head của phần profile của mình
			$headtitle = 'Profile: ' .$IDUser->getInfoID('nickName', $id);
			require('../incf/head.php');
			
			# Thông báo cập nhật avatar thành công qua $_GET
			if(isset($_GET['noti']) && $_GET['noti'] == 'avatar') echo '<div class="well well-sm"><center>Avatar cập nhật thành công</center></div>';
			
			# Xử lý form thay đổi thông tin cá nhân */
			if(isset($_GET['noti']) && $_GET['noti'] == 'edit' && isset($_POST['submit'])){
				
				# Mã hóa
				$realName = trim($_POST['realname']);
				$country  = trim($_POST['country']);
				
				# Khởi tạo class truyVan
				$DB  = new truyVan();
				$DB->update('users', array(
					 'tenThat' 		=> $realName,
					 'queQuan'      => $country
				), 'id =' .$IDUser->getInfoID('id', $id));
				
				# Hủy class truyVan
				unset($DB);
				
				# Hiển thị thông báo thành công
				echo '<div class="well well-sm"><center>Cập nhật thông tin thành công</center></div>';
			}
			
			# Hiện Avatar của bạn và status
			echo '<center>' .
				 '<blockquote>';
			if(file_exists('../users/avatar/' .$IDUser->getInfoID('id', $id). '.png')) echo '<a href="#" id="btn"><img src="../users/avatar/' .$IDUser->getInfoID('id', $id). '.png" alt="" class="img-responsive img-circle" style="width: 120px; height: 120px;"></a>';
			echo '<p>Bạn là ' .user($IDUser->getInfoID('nickName', $id), $IDUser->getInfoID('rights', $id), $IDUser->getInfoID('id', $id)). '</p>';
			if($IDUser->getInfoID('chamNgon', $id) != NULL) echo '<small><cite>' .$IDUser->getInfoID('chamNgon', $id). '</cite></small>';
			echo '</blockquote>' .
				 '</center>';
				 
			# Hiện inbox
			echo '<center><a href="inbox.php" class="label label-primary">Hộp thư</a></center><br/>';

			# Khung change Avatar
			echo '<div class="bs-example"><div id="myModal" class="modal fade"><div class="modal-dialog"><div class="modal-content"><div class="modal-header">' .
				 '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>' .
                 '<h4 class="modal-title">Tải lên ảnh đại diện</h4>' .
                 '</div>' .
                 '<div class="modal-body"><div class="well well-sm"><center>Hãy chọn Avatar của bạn và tải lên</center></div>' .
				 '<div id="kv-avatar-errors" class="center-block" style="width:800px;display:none"></div>' .
				 '<form class="text-center" action="avatar.php?id=' .$IDUser->getInfoID('id', $id). '" method="post" enctype="multipart/form-data">' .
				 '<div class="kv-avatar center-block" style="width:200px">' .
				 '<input id="avatar" name="avatar" type="file">' .
				 '</div>' .
				 '</form>';
				 
			# Thêm script thay đổi avatar
			include 'script.js';
			
			echo '</div>' .
                 '<div class="modal-footer">' .
				 '</div></div></div></div></div>';

			# Nhật ký hoạt động
			echo '<div class="panel panel-default">' .
				 '<div class="panel-heading">Nhật ký hoạt động</div>' .
				 '<div class="panel-body">';
				 
			# Khởi tạo class truyVan
			$DB = new truyVan();
			
			# Lấy dữ liệu bảng tin
			$DB->getNewsfeed($_GET['id'], $IDUser->getInfoID('id', $id));
			
			# Hủy class truyVan
			unset($DB);
			
			# Đóng khung HTML newsfeed
			echo '</div>' .
				 '</div>';
			
			# Hiển thị thông tin cá nhân
			echo '<div class="panel-group"><div class="panel panel-default"><div class="panel-heading">' .
				 'Thông tin  <a data-toggle="collapse" href="#collapse1"><font size="1">Edit</font></a>' .
				 '</div>' .
				 '<div class="panel-body"><table style="width:100%"><tr><td><span class="glyphicon glyphicon-user"></span>  Name:</td><td>' .
				 '<a style="text-decoration:none">' .$IDUser->getInfoID('tenThat', $id). '</a>' .
				 '</td></tr><tr><td><span class="glyphicon glyphicon-calendar"></span>  Birthday: </td><td>' .
				 '<a style="text-decoration:none"></a>' .
				 '</td></tr><tr><td><span class="glyphicon glyphicon-home"></span>  Lives in:</td><td>' .
				 '<a style="text-decoration:none">' .$IDUser->getInfoID('queQuan', $id). '</a>' .
				 '</td></tr></table></div></div>' .
				 '<br/>' .
				 '<div id="collapse1" class="panel-collapse collapse">' .
				 '<div class="panel-group"><div class="panel panel-default">' .
				 '<div class="panel-heading"><center><b>Chỉnh sửa thông tin cá nhân</b></center></div>' .
				 '<div class="panel-body">' .
				 '<form class="form-horizontal" action="./profile.php?id=' .$_GET['id']. '&noti=edit" method="post">' .
				 '<fieldset>' .
				 '<div class="form-group">' .
				 '<label for="inputEmail" class="col-lg-2 control-label">Name:</label><div class="col-lg-10"><input type="text" name="realname" class="form-control" id="inputEmail" placeholder="Tên của bạn"></div>' .
				 '</div>' .
				 '<div class="form-group">' .
				 '<label for="inputPassword" class="col-lg-2 control-label">Lives in:</label><div class="col-lg-10"><input type="text" name="country" class="form-control" id="inputPassword" placeholder="Quê của bạn"></div>' .
				 '</div>' .
				 '<div class="form-group">' .
				 '<center><button class="btn btn-success" type="submit" name="submit">Hoàn Thành</button></center>' .
				 '</div>' .
				 '</fieldset></form>' .
				 '</div></div></div></div></div>';
		}
		else
		{
			
			# Chèn head phần profile của người khác
			$headtitle = 'Profile: ' .$IDUser->getInfoID2('nickName', $_GET['id']);
			require('../incf/head.php');
			
			# Thông báo gửi tin nhắn đến người này thành công
			if(isset($_GET['noti']) && $_GET['noti'] == 'send') echo '<div class="well well-sm"><center>Gửi tin nhắn thành công</center></div>';
			
			# Khi ID là người khác
			# Hiển thị cả thông báo bị Dame ở đây
			if(isset($_GET['act']) && $_GET['act'] == 'dame'){
				
				# Hàm dùng để đánh nhau: __dame
				# Sử dụng strong ramdom từ 10 -> 30% để dame nhau
				function __dame($myStrong, $yourStrong, $myID, $yourID, $yourName, $yourRights){
					
					if($myStrong <= 0) return '<div class="well well-sm"><center>Bạn quá yếu để Dame</center></div>';
					if($yourStrong <= 0) return '<div class="well well-sm"><center>Đối thủ quá yếu để Dame</center></div>';
					if($myStrong > 0 && $yourStrong > 0){
						$myDame = mt_rand($myStrong * 0.1, $myStrong * 0.3);
						$yourDame = mt_rand($yourStrong * 0.1, $yourStrong * 0.3);
						$updateStrong = new truyVan();
						$updateStrong->update('users', array(
									 'strong' => $myStrong - $yourDame
						), 'id ='. $myID);
						$updateStrong->update('users', array(
									 'strong' => $yourStrong - $myDame
						), 'id ='. $yourID);
						$arrayChieu = array(
							'nắm đấm thép', 'cú đấm đẫm máu', 'đấm thẳng vào mặt', 'đấm dập dụi', 'đấm ngu người', 'đấm lệch mõm',
							'tát bể mõm', 'tát lệch mặt', 'tát bằng chân', 'tát tới tấp', 'tát ngu người', 'tát xuyên màn đêm',
							'long chảo thủ', 'cào cào mổ nhái', 'ếch vồ hoa mướp', 'ba ba xung kích',
							'xoay người trên không san tô 3 vòng', 'liên hoàn cước', 'quay tay vòng xuyến'
						);
						$arrayBi = array(
							'đập đầu vào đá', 'đập đầu vào đệm', 'rơi xuống nước', 'úp mặt vào ***',
							'ngu người toàn tập'
						);
						$ranBi = rand(0, count($arrayBi) - 1);
						$ranChieu = rand(0, count($arrayChieu) - 1);
						
						# 3 đoạn text hiển thị, dame và bị dame
						$text = $arrayBi[$ranBi];
						$nd   = 'Bạn vừa đánh ' .user($yourName, $yourRights, $yourID) .' đến ' .$text;
						
						# Insert Data vào `dame`
						$updateStrong->insert('dame', array(
									 'myID' => $myID,
									 'yourID' => $yourID,
									 'text' => $text,
									 'time' => time()
						));
						
						# Insert data vào bảng tin
						$updateStrong->insert('newsfeed', array(
									 'user_id' 		=> $myID,
									 'user_id_take' => $yourID,
									 'prefix' 		=> '1',
									 'details' 		=> $arrayBi[$ranBi],
									 'time' 		=> time()
						));
						$updateStrong->insert('newsfeed', array(
									 'user_id'		=> $yourID,
									 'user_id_take' => $myID,
									 'prefix' 		=> '2',
									 'details' 		=> $arrayBi[$ranBi],
									 'time' 		=> time()
						));
						
						# Hủy class truyVan
						unset($updateStrong);
						
						return '<div class="well well-sm"><center>' .$nd. '</center></div>';
					}
				}
			echo __dame($IDUser->getInfoID('strong', $id), $IDUser->getInfoID2('strong', $_GET['id']), $IDUser->getInfoID('id', $id), $_GET['id'], $IDUser->getInfoID('nickName', $id), $_GET['id'], $IDUser->getInfoID('rights', $id), $_GET['id']);
			}
			# Hết function __dame
			
			# Hiển thị avatar và châm ngôn của id người dùng
			echo '<blockquote>' .
				 '<center>';
			if(file_exists('../users/avatar/' .$_GET['id']. '.png')) echo '<img src="../users/avatar/' .$_GET['id']. '.png" alt="" class="img-responsive img-circle" style="width: 120px; height: 120px;">';
			echo '<p>Thông tin của ' .user($IDUser->getInfoID2('nickName', $_GET['id']), $IDUser->getInfoID2('rights', $_GET['id']), $_GET['id']). '</p>' .
				 '</center>';
			if($IDUser->getInfoID2('chamNgon', $_GET['id']) != NULL) echo '<small><cite>' .$IDUser->getInfoID2('chamNgon', $_GET['id']). '</cite></small>';
			echo '</blockquote>';
				 
			# Dòng gửi tin
			echo '<center><a href="#" id="ib" class="label label-success">Gửi tin nhắn cho ' .$IDUser->getInfoID2('nickName', $_GET['id']). ' ngay bây giờ</a></center><br/>';
			
			# Dòng set quyền nếu là Admin
			if($IDUser->getInfoID('rights', $id) >= 6)
				echo '<center><a href="#" class="label label-danger">Đưa ' .$IDUser->getInfoID2('nickName', $_GET['id']). ' lên làm quản trị</a></center><br/>';
			
			# Khung gửi tin nhắn mới bằng modal
			echo '<div class="bs-example">' .
				 '<div id="newInbox" class="modal fade">' .
				 '<div class="modal-dialog"><div class="modal-content"><div class="modal-header">' .
				 '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>' .
                 '<h4 class="modal-title">Gửi tin nhắn mới</h4>' .
                 '</div>' .
                 '<div class="modal-body"><br/>' .
				 '<form action="inbox.php?user=' .$_GET['id']. '" method="post">' .
				 '<textarea class="form-control" rows="3" name="msg"></textarea>' .
				 '<input class="btn btn-primary btn-xs" type="submit" name="submit" value="Gửiiii" />' .
				 '</form>' .
				 '</div>' .
                 '<div class="modal-footer"></div>' .
				 '</div></div></div></div>';
			
			# Nhật ký hoạt động
			echo '<div class="panel panel-default">' .
				 '<div class="panel-heading">Nhật ký hoạt động</div>' .
				 '<div class="panel-body">';
				 
			# Khởi tạo class truyVan
			$DB = new truyVan();
			
			# Lấy nội dung newsfeed
			$DB->getNewsfeed($_GET['id'], $IDUser->getInfoID('id', $id));
			
			# Hủy class truyVan
			unset($DB);
			
			# Đóng khung HTML newsfeed
			echo '</div>' .
				 '</div>';
				 
			# Hiển thị thông tin cá nhân
			echo '<div class="panel-group">' .
				 '<div class="panel panel-default">' .
				 '<div class="panel-heading">Thông tin</div>' .
				 '<div class="panel-body">' .
				 '<table style="width:100%"><tr><td>' .
				 '<span class="glyphicon glyphicon-user"></span>  Name:</td><td>' .
				 '<a style="text-decoration:none">' .$IDUser->getInfoID2('tenThat', $_GET['id']). '</a>' .
				 '</td></tr><tr><td>' .
				 '<span class="glyphicon glyphicon-calendar"></span>  Birthday: '.
				 '</td><td>' .
				 '<a style="text-decoration:none"></a>' .
				 '</td></tr><tr><td>' .
				 '<span class="glyphicon glyphicon-home"></span>  Lives in:</td><td>' .
				 '<a style="text-decoration:none">' .$IDUser->getInfoID2('queQuan', $_GET['id']). '</a>' .
				 '</td></tr>' .
				 '</table>' .
				 '</div></div><br/>';
				 
			# Thanh hành động với đối phương
			echo '<div class="btn-group btn-group-justified">' .
				 '<a href="../users/profile.php?act=dame&id=' .$_GET['id']. '" class="btn btn-danger btn-sm">Oánh</a>' .
				 '<a href="#" class="btn btn-warning btn-sm">Disable</a>' .
				 '<a href="#" class="btn btn-success btn-sm">Disable</a>' .
				 '</div><br/>';
		}
		
		# Hủy class userID
		unset($IDUser);
	}
	
	# Báo lỗi
	else
	{
		$headtitle = 'Lỗi';
		require('../incf/head.php');
		echo err_u();
	}
	
	# Tiếp foot
	require('../incf/foot.php');
?>