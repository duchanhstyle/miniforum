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
	 
	# Khung HTML
	# sử dụng bootstrap 3
	# các js mới nhất qua bootstrap 3
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"' .
	'"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' .
    '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="vi" lang="vi">' .
    '<head>' .
	'<meta http-equiv="content-type" content="application/xhtml+xml; charset=utf-8"/>' .
	'<link rel="stylesheet" type="text/css" href="../css/boot.min.css">' .
	'<link href="../css/iforum.css" media="all" rel="stylesheet" type="text/css" />' .
	'<script src="../js/bootstrap.js"></script>' .
	'<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>' .
	'<script src="../js/bootstrap.min.js"></script>' .
	'<link rel="shortcut icon" href="../favicon.ico" />' .
    '<title>' .$headtitle. '</title>' .
	'<meta name="viewport" content="width=device-width, initial-scale=1.0">' .
    '</head>' .
    '<body>';

	# Thêm vào các Script load dame, chat, enter to submit
	include('script.php');
	
	# Khởi tạo class
	$IDUser = new userID();


echo'<div class="container">';
# Nút đăng nhập
if(!ID()){
echo'<button
class="btn btn-danger btn-sm pull-right" style="margin: 8px 3px 0px 0px;" data-toggle="modal" data-target="#myModal">
<span
class="glyphicon glyphicon-log-in"></span> Đăng nhập
</button>';
}else{

echo'<a
class="btn btn-danger btn-sm pull-right" style="margin: 8px 3px 0px 0px;" href="../exit.php"><span
class="glyphicon glyphicon-log-out"></span> Thoát</a>';


if($IDUser->getInfoID('rights', $id) >= 6) echo '<a
class="btn btn-danger btn-sm pull-right" style="margin: 8px 3px 0px 0px;" href="cpanel/index.php"><span class="glyphicon glyphicon-text-background"></span> ACP</a>';

}

echo'<a
class="btn btn-danger btn-sm pull-right" style="margin: 8px 3px 0px 0px;" href="/"><span
class="glyphicon glyphicon-home"></span> Home</a> ';


echo'<a class="pull-left" style="margin: 8px 3px 0px 0px;" href="/"><img
src="http://my.teamobi.com/app/view/images/logo.png" height=30px /></a>';

# Modal đăng nhập
if(!ID()){
echo'<div
class="modal fade bs-example-modal-sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div
class="modal-dialog"><form
class="form-signin" role="form" action="./login.php" method="POST" name="login"><div
class="modal-content"><div
class="modal-header">
<button
type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title" id="myModalLabel">Đăng nhập</h4></div><div
class="modal-body">
<input
type="text" class="form-control" name="username" placeholder="Tài khoản" required autofocus>
<br/><input
type="password" class="form-control" name="password" placeholder="Mật khẩu" required>
</div>
<div class="modal-footer">
<button
class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Đăng nhập</button></div></div></form></div></div>';
}



echo'</div><div class="container"><div
id="box_login_ads"><div
align="center" style="padding-bottom:5px;"></div></div>';
	 
	# Xử lý nếu là thành viên
	if(ID()){
		
			 
		/* Tăng thời gian Online
		 * Gọi class userID để truy vấn đến id :((
		 * Dùng hàm timeOnline
		 */
		$__IDUser = new userID();
		
		$__DB = new truyVan();
		
		$__DB->update('users', array(
			'timeOnline' 		=> time()
		), 'id =' .$__IDUser->getInfoID('id', $id));
		
		//$__DB->getNotice();
		
		//unset($__DB);
		
		$__IB = new inbox();
		$__IB->checkInbox($__IDUser->getInfoID('id', $id));
		unset($__IB);
		unset($__IDUser);

	}

	echo '<br/>';
	echo '<div class="content" id="datadame"></div><br/>';

?>