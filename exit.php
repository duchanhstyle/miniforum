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
	
	# Thư viện
	include('incf/class.php');
	include('incf/func.php');
	
	# Hủy SESSION
    SESSION_DESTROY();
	
	# Chuyển hướng đến trang chủ
    header("Location: index.php");

?>