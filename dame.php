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
	
	# Xử lý nếu là thành viên
	if(ID()){
		
		# Khởi tạo class truyVan và userID
		$DB     = new truyVan();
		$IDUser = new userID();
		
		# Hiển thị dữ liệu dame bằng function getDame
		echo $DB->getDame($IDUser->getInfoID('id', $id));
		
		# Hủy các class
		unset($IDUser);
		unset($DB);
	}

?>