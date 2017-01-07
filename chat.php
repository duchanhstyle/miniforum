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
	


		# Khởi tạo class tryVan
		$DB = new truyVan();

		# Xử lý nếu là thành viên
	        if(ID()){
		# Xử lý form chat
		if(isset($_POST['msg'])){

			$DB->insert('chat', array(
				 'user_id' => $id,
				 'text'    => htmlspecialchars(checkin(mb_substr(trim($_POST['msg']), 0, 5000))),
				 'time'    => time()
			));
		}
		}

		# Hiển thị nội dung đã chat
		echo $DB->getChat();
		
		# Hủy class truyVan
		unset($DB);
	

?>