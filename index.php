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
	include('incf/class.php');
	include('incf/func.php');


	require('incf/head.php');

	
	
		# Thông báo dựa vào act
		if(isset($_GET['act'])){
			if($_GET['act'] == 'success')     echo '<center><div class="alert alert-dismissible alert-success"><strong>Đăng kí thành viên thành công: </strong>bạn có thể đăng nhập ngay</div></center>';
		}
# lời ngỏ khi chưa đăng nhập		
if(!ID()){	
echo'<div class="well well-sm"><b><a href="registration.php">Đăng ký</a></b> thành viên để cùng tham gia thảo luận, chia sẽ, trao đổi các vấn đề về Wap/Web</div>';
}

		
		# Hiển thị các bài viết của topic
		echo '<a href="forum/index.php"><label class="control-label"><span class="glyphicon glyphicon-list" aria-hidden="false"></span> Diễn đàn</label></a>';
		$TP = new topic();
		echo $TP->getTopic();
		unset($TP);
		
		# Hiển thị chém gió
		echo '<a href="forum/index.php"><label class="control-label"><span class="glyphicon glyphicon-pencil" aria-hidden="false"></span> Lưu bút</label></a>';

if(ID()){
echo'<div class="row"><div class="col-lg-6">
<form action="chat.php" id="shoutbox" method="post" name="shoutbox">
<div class="input-group">
<input type="text" class="form-control" placeholder="Nhập tin nhắn" name="msg" id="msg">
<span class="input-group-btn">
<button class="btn btn-default" type="submit" name="submit"> Gửi</button>
</span>
</div>
</form>
</div>
</div>';
}



		echo '<div class="content" id="datachat"></div>';
		/*
		# Thành viên Online
		echo $IDUser->getUsersOnline();
		echo '<br/>';
		
                */



	require('incf/foot.php');

?>