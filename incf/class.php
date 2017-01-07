<?php
SESSION_START();
    /*
     *
     * @ Forum 4C
     *
     * @ Created by Tí Nhí Nhố (tonghoai)
     *
     * @ Share
     *
     */
	 
	
	# Class ketNoi là quan trọng
	# Chứa 2 hàm ngắt kết nối và kết nối đến DB
	# Được gọi ra sau mỗi class con
	class ketNoi extends info
	{
		# Kết nối
		function connect(){
			$this->__conn = mysqli_connect($this->db_host, $this->db_user, $this->db_pass, $this->db_name) or die ('Lỗi kết nối');
			mysqli_query($this->__conn, "SET NAMES 'utf8'");
		}
		
		# Hủy kết nối */
		function dis_connect(){
			if ($this->__conn){
				mysqli_close($this->__conn);
			}
		}
		
	}
	
	
	# Class đăng nhập với chức năng kiểm tra đăng nhập
	class dangNhap extends ketNoi
	{
		
		# Khởi tạo và ngắt kết nối
		# __construct sẽ tự động đc thực hiện khi dangNhap được gọi ra
		# __destruct sẽ được thực hiện ở cuối 
		function __construct() {
			parent::connect();
		}
		function __destruct() {
			parent::dis_connect();
		}

		# Hàm truy vấn theo ID
		function checkID($username, $password){
			$sql = 'select id from users where userName = "' .$username. '" AND passWord = "' .$password. '"';
			$result = mysqli_fetch_assoc(mysqli_query($this->__conn, $sql));
			if(isset($result['id'])) return 1;
			else return 0;
		}

	}
	
	
	# Class truyVan
	# Chứa các lệnh với DB
	class truyVan extends ketNoi
	{
		
		# Khởi tạo và ngắt kết nối
		# __construct sẽ tự động đc thực hiện khi dangNhap được gọi ra
		# __destruct sẽ được thực hiện ở cuối
		function __construct() {
			parent::connect();
		}
		function __destruct() {
			parent::dis_connect();
		}
		
		# Hàm insert dữ liệu
		function insert($table, $data){
			
			# Sử dụng biến $field_list là danh sách các cột cần thêm
			# Sử dụng biến $value_list là dữ liệu tương ứng
			# Vòng foreach để lọc data, trả về truy vấn.
			$field_list = '';
			$value_list = '';
			foreach ($data as $key => $value){
				$field_list .= ",$key";
				$value_list .= ",'".mysqli_real_escape_string($this->__conn, $value)."'";
			}
			$sql = 'INSERT INTO '.$table. '('.trim($field_list, ',').') VALUES ('.trim($value_list, ',').')';
			mysqli_query($this->__conn, $sql);
			return mysqli_insert_id($this->__conn);
		}
		
		# Hàm update dữ liệu
		function update($table, $data, $where){
			
			# Sử dụng vòng foreach để lọc thông tin
			# Trả về truy vấn
			$sql = '';
			foreach ($data as $key => $value){
				$sql .= "$key = '".mysqli_real_escape_string($this->__conn, $value)."',";
			}
			$sql = 'UPDATE '.$table. ' SET '.trim($sql, ',').' WHERE '.$where;
			return mysqli_query($this->__conn, $sql);
		}

		# Hàm xóa dữ liệu
		function remove($table, $where){
			$sql = "DELETE FROM $table WHERE $where";
			return mysqli_query($this->__conn, $sql);
		}
		
		# Một số hàm "ngoại"
		# Hàm hiển thị nội dung Chat
		# Dữ liệu lấy từ table `chat`
		function getChat(){
			$result = mysqli_query($this->__conn, 'SELECT * FROM chat ORDER BY id DESC LIMIT 6');
			$return = array();
			while ($row = mysqli_fetch_assoc($result)){
				$getNR = mysqli_fetch_assoc(mysqli_query($this->__conn, 'select id, nickName, rights from users where userName = "' .$row['user_id']. '"'));
				$user = user($getNR['nickName'], $getNR['rights'], $getNR['id']);
				$msg = $row['text'];
				echo '<li class="list-group-item">' .$user. ': ' .char($msg). '</li>';
			}
			return;
		}
		

		function getslfr(){
			$result = mysqli_query($this->__conn, 'select * from topic where type = "2" AND sub !="1"');
			$return = array();
			while ($row = mysqli_fetch_assoc($result)){
                echo'<option value="' .$row['id']. '">' . $row['title'] . '</option>';
			}
			return;
		}

		# Một số hàm "ngoại"
		# Hàm hiển thị nội dung Dame
		# Dữ liệu lấy từ table `dame`
		function getDame($dame){
			$result = mysqli_query($this->__conn, 'SELECT * FROM dame WHERE time > '.time().' - 10 AND yourID = ' .$dame. ' ORDER BY time DESC LIMIT 1');
			$return = array();
			while ($row = mysqli_fetch_assoc($result)){
				$user = user3($row['myID']);
				$msg = $row['text'];
				echo '<div class="well well-sm"><center><strong>' .$user. '</strong> vừa đánh bạn, khiến bạn bị ' .$msg. '</center></div>';
			}
			return;
		}
		
		# Một số hàm "ngoại"
		# Hàm lấy thông tin từ newsfeed
		function getNewsfeed($username, $myname){
			$result = mysqli_query($this->__conn, 'select * from newsfeed where user_id = "' .$username. '" ORDER BY time DESC LIMIT 10');
			while ($row = mysqli_fetch_assoc($result)){
				$getNR      = mysqli_fetch_assoc(mysqli_query($this->__conn, 'select nickName, rights from users where id = "' .$row['user_id']. '"'));
				$getNR_Take = mysqli_fetch_assoc(mysqli_query($this->__conn, 'select nickName, rights from users where id = "' .$row['user_id_take']. '"'));
				echo '<div class="row"><div class="col-lg-2">';
				if(file_exists('../users/avatar/' .$username. '.png')) echo '<center><img src="../users/avatar/' .$username. '.png" alt="" class="img-responsive img-circle"></center>';
				echo '</div>' .
					 '<div class="col-lg-10">';
					 if($row['prefix'] == 0)	 echo danhTinh($getNR['nickName'], $getNR['rights'], $row['user_id'], $myname). ' ' .$row['details'];
					 elseif($row['prefix'] == 1) echo danhTinh($getNR['nickName'], $getNR['rights'], $row['user_id'], $myname). ' đã đánh ' .danhTinh($getNR_Take['nickName'], $getNR_Take['rights'], $row['user_id_take'], $myname). ' khiến ' .danhTinh($getNR_Take['nickName'], $getNR_Take['rights'], $row['user_id_take'], $myname). ' bị ' .$row['details'];
					 elseif($row['prefix'] == 2) echo danhTinh($getNR['nickName'], $getNR['rights'], $row['user_id'], $myname). ' bị ' .danhTinh($getNR_Take['nickName'], $getNR_Take['rights'], $row['user_id_take'], $myname). ' đánh đến ' .$row['details'];
					 elseif($row['prefix'] == 3) echo danhTinh($getNR['nickName'], $getNR['rights'], $row['user_id'], $myname). ' đã cập nhật cảm nghĩ: ' .$row['details'];
					 echo '<p align="right">[' .realTime($row['time']). ']</p>';
				echo '</div></div><br/>';
			}
			return;
		}
		
		# Một số hàm "ngoại"
		# Hàm lấy thông báo trên head
		function getNotice(){
			$result = mysqli_query($this->__conn, 'select * from topic where notice = "1" ORDER BY realTime DESC LIMIT 1');
			while ($row = mysqli_fetch_assoc($result)){
				$getNR = mysqli_fetch_assoc(mysqli_query($this->__conn, 'select nickName, rights from users where id = "' .$row['user_id']. '"'));
				echo '<div class="well well-sm"><center><font color="#009999"><span class="glyphicon glyphicon-info-sign" aria-hidden="false"></span></font><br/>' .$getNR['nickName']. ' muốn thông báo: <a href="../forum/index.php?id=' .$row['topic']. '">' .$row['title']. '</a></center></div>';
			}
			return;
		}
		
		# Một số hàm "ngoại"
		# Hàm lấy headtitle
		function getHeadTitle(){
			$result = mysqli_query($this->__conn, 'select title from setting where id = "1"');
			$row = mysqli_fetch_assoc($result);
			return $row['title'];
		}
		
	}
	
	
	# Class userID 
	# Xử lý các vấn đề liên quan đến truy vấn người dùng
	class userID extends ketNoi
	{
		
		# Khởi tạo và ngắt kết nối
		# __construct sẽ tự động đc thực hiện khi dangNhap được gọi ra
		# __destruct sẽ được thực hiện ở cuối
		function __construct() {
			parent::connect();
		}
		function __destruct() {
			parent::dis_connect();
		}
		
		# Hàm kiểm tra xem user đã được đăng kí?
		function checkUser($username){
			$result = mysqli_query($this->__conn, 'select * from users where userName = "' .$username. '"');
			return mysqli_num_rows($result);
		}
		
		# Hàm lấy thông tin User từ userName
		function getInfoID($act, $username){
			$sql = 'select * from users where username = "' .$username. '"';
			$result = mysqli_fetch_assoc(mysqli_query($this->__conn, $sql));
			return $result[$act];
		}
		
		# Hàm lấy thông tin user từ ID
		function getInfoID2($act, $username){
			$sql = 'select * from users where id = "' .$username. '"';
			$result = mysqli_fetch_assoc(mysqli_query($this->__conn, $sql));
			return $result[$act];
		}
		
		# Hàm kiểm tra xem user có tồn tại hay không?
		function checkInfoID($username){
			$sql = 'select * from users where id = "' .$username. '"';
			$result = mysqli_num_rows(mysqli_query($this->__conn, $sql));
			return $result;
		}
		
		# Hàm lấy thành viên Online
		function getUsersOnline(){
			$result = mysqli_query($this->__conn, 'select * from users where timeOnline >= ' .time(). ' - 300'); 
			echo '<br/><label class="control-label"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="false"></span>  Đang trực tuyến:</label> ';
if($result->num_rows > 0){
			while ($row = mysqli_fetch_assoc($result)){
					echo user($row['nickName'], $row['rights'], $row['id']). ', ';
			}

}else{echo'không có thành viên nào trực tuyến';}

			return;
		}
		
	}
	
	
	# Class Topic 
	# Chứa các lệnh xử lý với mảng Topic
	class topic extends ketNoi
	{
		
		# Khởi tạo và ngắt kết nối
		# __construct sẽ tự động đc thực hiện khi dangNhap được gọi ra
		# __destruct sẽ được thực hiện ở cuối
		function __construct() {
			parent::connect();
		}
		function __destruct() {
			parent::dis_connect();
		}
		
		# Hàm kiểm tra sự tồn tại của một topic
		function checkTopic($id){
			$result = mysqli_query($this->__conn, 'select * from topic where topic = "' .$id. '" AND type = "1"');
			return mysqli_num_rows($result);
		}
		
		# Hàm kiểm tra sự tồn tại của một id topic
		function checkExistID($id){
			$result = mysqli_query($this->__conn, 'select * from topic where id = "' .$id. '"');
			return mysqli_num_rows($result);
		}
		
		# Hàm kiểm tra xem id Topic có phải là depend
		function checkDepend($id){
			$result = mysqli_query($this->__conn, 'select * from topic where id = "' .$id. '"');
			$row    = mysqli_fetch_assoc($result);
			return $row['type'];
		}
		
		# Hàm lấy thông tin IDTopic
		# IDTopic để lấy ID mới nhất
		function getIDTopic(){
			$result = mysqli_query($this->__conn, 'select IDTopic from setting where id = "2"');
			$row    = mysqli_fetch_assoc($result);
			return $row['IDTopic'];
		}
		
		# Hàm lấy danh mục diễn đàn
		function getDepend($rights){
			$result = mysqli_query($this->__conn, 'select * from topic where type = "2" AND sub !="1"');
			echo '<ul class="breadcrumb">' .
				 '<li><a href="../index.php">Home</a></li>' .
				 '<li class="active"><b>Diễn đàn</b></li>' .
				 '</ul>';
			if($rights >= 6) echo '<center><a href="../cpanel/topic.php" class="label label-danger">Thêm mới một mục</a></center><br/>';
			echo '<ul class="list-group">';
			while ($row = mysqli_fetch_assoc($result)){
				echo '<a href="../forum/index.php?id=' .$row['id']. '" class="list-group-item">' .
				'<h4 class="list-group-item-heading"><span class="glyphicon glyphicon-ok-sign" aria-hidden="false"></span> ' . $row['title'] . '</h4>' .
				'<p class="list-group-item-text">' .$row['text']. '</p>' .
				'</a>';
			}
			echo '</ul>';
			return;
		}



		
		# Hàm lấy danh mục diễn đàn trong Depend
		function getListDepend($id,$rights){
			$result = mysqli_query($this->__conn, 'select * from topic where type = "1" AND depend = "' .$id. '" ORDER BY time DESC');
			$gettit = mysqli_query($this->__conn, 'select * from topic where id = "' .$id. '"');
			$rrr    = mysqli_fetch_assoc($gettit);

			$gettit2 = mysqli_query($this->__conn, 'select * from topic where id = "' .$rrr['depend']. '"');
			$rrr2    = mysqli_fetch_assoc($gettit2);

if($rrr['sub']!=1){
			echo '<ul class="breadcrumb">' .
			  	 '<li><a href="../index.php">Home</a></li>' .
				 '<li><a href="../forum/index.php">Diễn đàn</a></li>' .
				 '<li class="active"><b>' .$rrr['title']. '</b></li>' .
				 '</ul>';
}else{
			echo '<ul class="breadcrumb">' .
			  	 '<li><a href="../index.php">Home</a></li>' .
				 '<li><a href="../forum/index.php">Diễn đàn</a></li>' .
				 '<li><a href="../forum/index.php?id=' .$rrr2['id']. '">' .$rrr2['title']. '</a></li>' .
				 '<li class="active"><b>' .$rrr['title']. '</b></li>' .
				 '</ul>';
}
if(ID()){
			echo '<p><a href="newpost.php?id=' .$id. '"><button
type="submit" value="submit" class="btn btn-default btn-sm">Bài mới</button></a> ';

echo'</p><br/>';
}

// chuyên mục
			$resultcon = mysqli_query($this->__conn, 'select * from topic where type = "2" AND depend = "' .$id. '" AND sub = "1" ORDER BY time DESC');

			echo '<ul class="list-group">';
			while ($row = mysqli_fetch_assoc($resultcon)){
				echo '<a href="../forum/index.php?id=' .$row['id']. '" class="list-group-item">' .
				'<h4 class="list-group-item-heading"><span class="glyphicon glyphicon-arrow-right"></span> ' . $row['title'] . '</h4>' .
				'<p class="list-group-item-text">' .$row['text']. '</p>' .
				'</a>';
			}
			echo '</ul>';

			echo '<ul class="list-group">';
			while ($row = mysqli_fetch_assoc($result)){
				echo '<a href="../forum/index.php?id=' .$row['id']. '" class="list-group-item">' .
				$row['title'] .
				'</a>';
			}
echo'</ul>';


			return;
		}
		


		# Hàm lấy danh sách Topic hiển thị ngoài index
		function getTopic(){
			$result = mysqli_query($this->__conn, 'select * from topic where type = "1" ORDER BY time DESC LIMIT 5');
			echo '<ul class="list-group">';
			while ($row = mysqli_fetch_assoc($result)){
				$counts = mysqli_query($this->__conn, 'select * from topic where type = "0" AND topic = "' .$row['topic']. '"');
				$getNR = mysqli_fetch_assoc(mysqli_query($this->__conn, 'select nickName, rights from users where id = "' .$row['user_id']. '"'));
				echo '<a href="../forum/index.php?id=' .$row['topic']. '" class="list-group-item">' .
				'<span class="badge">' .$getNR['nickName']. '</span>' .
				'<div class="list-group-item-heading"><span class="glyphicon glyphicon-play-circle" aria-hidden="false"></span>  ' . $row['title'] . '  <span class="label label-success"><span class="glyphicon glyphicon-comment" aria-hidden="false"></span> ' .mysqli_num_rows($counts). '</span>' .
				' </div>' .
				'</a>';
				# ' .mysqli_num_rows($counts). '
			}
			echo '</ul>';
			return;
		}
		




		# Hàm lấy Depend breadcrumb
		function getDependTopic($id){
			$result = mysqli_query($this->__conn, 'select title from topic where depend = "' .$id. '" AND type="2"');
			$row    = mysqli_fetch_assoc($result);
			return $row['title'];
		}
		
		# Hàm lấy thông tin Topic
		function getInfoTopic($g, $id){
			$result = mysqli_query($this->__conn, 'select * from topic where topic = "' .$id. '"');
			$row    = mysqli_fetch_assoc($result);
			return $row[$g];
		}
		
		# Hàm lấy tiêu đề của mục Depend
		function getInfoDepend($id){
			$result = mysqli_query($this->__conn, 'select title from topic where id = "' .$id. '"');
			$row    = mysqli_fetch_assoc($result);
			return $row['title'];
		}
		
		# Hàm lấy danh sách bình luận
		function getCommentTopic($id, $rights, $st){
			$result = mysqli_query($this->__conn, 'select * from topic where topic = "' .$id. '" AND type = 0 ORDER BY time ASC LIMIT ' .$st. ', 5');
			while ($row = mysqli_fetch_assoc($result)){
				if($rights >= 6)
					$AD = '<p align="right"><a href="delete.php?id=' .$row['id']. '&topic=' .$id. '" class="label label-danger">Xóa</a></p>';
				else
					$AD = '';
				$getNR = mysqli_fetch_assoc(mysqli_query($this->__conn, 'select id, nickName, rights from users where id = "' .$row['user_id']. '"'));
				echo ' <li class="left clearfix"><span class="chat-img pull-left">' .
					 '<img src="../users/avatar/' .$row['user_id']. '.png" alt="" class="img-responsive" width="48" height="48">' .
					 '</span>' .
					 '<div class="chat-body clearfix">
                                <div class="header">
                                    <strong class="primary-font">' .
					 user($getNR['nickName'], $getNR['rights'], $getNR['id']) .
					 '</strong> <small class="pull-right text-muted">
                                        <span class="glyphicon glyphicon-time"></span> ' .realTime($row['time']). '</small>
                                </div><p>' .
					 char($row['text']) .
					 '</p>
                            </div>
                        </li>' .$AD. '<hr/>';

			}
			return;
		}
		
		# Hàm phân trang danh sách bình luận
		function getPagesTopic($id){
			$result = mysqli_query($this->__conn, 'select * from topic where topic = "' .$id. '" AND type = 0');
			$count  = mysqli_num_rows($result);
			$h      = ($count-1)/5 - 0.5;
			$p      = round($h, 0) + 1;
			$i      = 1;
			if($p >= 1)
				echo '<nav><ul class="pagination pagination-sm"><li><a>&laquo;</a></li>';
			while($i <= $p){
					echo '<li><a href="index.php?id=' .$id. '&p=' .$i. '">' .$i. '</a></li>';
				$i++;
			}
			if($p >= 1)
				echo '<li><a>&raquo;</a></li></ul></nav>';
		}
	}
	
	
	# Class inbox
	# Chứa các xử lý liên quan đến việc gửi nhận và đọc thư
	class inbox extends ketNoi
	{
		
		# Khởi tạo và ngắt kết nối
		# __construct sẽ tự động đc thực hiện khi dangNhap được gọi ra
		# __destruct sẽ được thực hiện ở cuối
		function __construct() {
			parent::connect();
		}
		function __destruct() {
			parent::dis_connect();
		}
		
		# Hàm kiểm tra sự tồn tại của một đoạn hội thoại
		function checkConversation($id){
			$result = mysqli_query($this->__conn, 'select * from inbox where conversation = "' .$id. '"');
			return mysqli_num_rows($result);
		}
		
		# Hàm lấy thông tin IDInbox
		# IDInbox để lấy ID mới nhất
		function getIDInbox(){
			$result = mysqli_query($this->__conn, 'select IDInbox from setting where id = "3"');
			$row    = mysqli_fetch_assoc($result);
			return $row['IDInbox'];
		}
		
		# Hàm lấy danh sách các thư đến
		function getInbox($myID){
			$result = mysqli_query($this->__conn, 'select * from inbox where type = "p" AND IDRece = "' .$myID. '" ORDER BY time DESC');
			echo '<div class="list-group">';
			while ($row = mysqli_fetch_assoc($result)){
				$getNR = mysqli_fetch_assoc(mysqli_query($this->__conn, 'select nickName, rights from users where id = "' .$row['IDSend']. '"'));
				if($row['receView'] == 0) $noti = '<span class="badge"><span class="glyphicon glyphicon-hand-left" aria-hidden="false"></span></span>';
				else $noti = '';
				echo '<a href="../users/inbox.php?conversation=' .$row['conversation']. '" class="list-group-item">' .userText($getNR['nickName'], $getNR['rights']). $noti . '</a>';
			}
			if(mysqli_num_rows($result) == 0) echo '<span class="list-group-item">Hộp thư đến trống. Ngay bây giờ bạn có thể gửi thư cho ai đó.</span>';
			echo '</div>';
			return;
		}
		
		# Hàm lấy danh sách các thư đi
		function getInbox2($myID){
			$result = mysqli_query($this->__conn, 'select * from inbox where type = "p" AND IDSend = "' .$myID. '" ORDER BY time DESC');
			echo '<div class="list-group">';
			while ($row = mysqli_fetch_assoc($result)){
				$getNR = mysqli_fetch_assoc(mysqli_query($this->__conn, 'select nickName, rights from users where id = "' .$row['IDRece']. '"'));
				if($row['sendView'] == 0) $noti = '<span class="badge"><span class="glyphicon glyphicon-hand-left" aria-hidden="false"></span></span>';
				else $noti = '';
				echo '<a href="../users/inbox.php?conversation=' .$row['conversation']. '" class="list-group-item">' .userText($getNR['nickName'], $getNR['rights']). $noti . '</a>';
			}
			if(mysqli_num_rows($result) == 0) echo '<span class="list-group-item">Hộp thư đi trống. Ngay bây giờ bạn có thể gửi thư cho ai đó.</span>';
			echo '</div>';
			return;
		}
		
		# Hàm in ra các tin nhắn
		function getText($id, $myID){
			$result = mysqli_query($this->__conn, 'select * from inbox where type = "l" AND conversation = "' .$id. '"');
			while ($row = mysqli_fetch_assoc($result)){
				if($row['IDSend'] == $myID) echo '<p align="right" style="margin-right:10px">' .$row['text']. '</p>';
				else echo '<div class="well well-sm">' .$row['text']. '</div>';
			}
			return;
		}
		
		# Hàm lấy ra ID người nhận trong đoạn hội thoại dựa vào conversation
		function getIDRece($id){
			$result = mysqli_query($this->__conn, 'select * from inbox where type = "p" AND conversation = "' .$id. '"');
			$row    = mysqli_fetch_assoc($result);
			return $row['IDRece'];
		}
		
		# Hàm lấy ra ID người gửi trong đoạn hội thoại dựa vào conversation
		function getIDSend($id){
			$result = mysqli_query($this->__conn, 'select * from inbox where type = "p" AND conversation = "' .$id. '"');
			$row    = mysqli_fetch_assoc($result);
			return $row['IDSend'];
		}
		
		# Hàm kiểm tra tin nhắn mới
		function checkInbox($myID){
			$result = mysqli_query($this->__conn, 'select * from inbox where type = "p"');
			$i = 0; $j = 0;
			while ($row = mysqli_fetch_assoc($result)){
				if($row['IDSend'] == $myID){
					if($row['sendView'] == 0) $i++;
				}
				if($row['IDRece'] == $myID){
					if($row['receView'] == 0) $j++;
				}
			}
			if($i>0) echo '<center><a href="../users/inbox.php" class="label label-danger">Bạn có tin nhắn mới</a></center>';
			if($j>0) echo '<center><a href="../users/inbox.php" class="label label-danger">Bạn có tin nhắn mới</a></center>';
			return;
		}
		
		# Hàm lấy ID conversation
		function IDInbox(){
			$result = mysqli_query($this->__conn, 'select * from inbox ORDER BY id DESC LIMIT 1');
			$row    = mysqli_fetch_assoc($result);
			return $row['id'];
		}
	}
	
	
	# Class statistical
	# Chứa các hàm thống kê
	class statistical extends ketNoi
	{
		
		# Khởi tạo và ngắt kết nối
		# __construct sẽ tự động đc thực hiện khi dangNhap được gọi ra
		# __destruct sẽ được thực hiện ở cuối
		function __construct() {
			parent::connect();
		}
		function __destruct() {
			parent::dis_connect();
		}
		
		# Hàm hiện tổng thành viên
		function sumID(){
			$result = mysqli_query($this->__conn, 'select * from users');
			return mysqli_num_rows($result);
		}
		
		# Hàm hiện tổng Admin, Smod, Mod
		function sumAD(){
			$result = mysqli_query($this->__conn, 'select * from users where rights >= "6"');
			return mysqli_num_rows($result);
		}
	}
    /* Class chứa thông tin kết nối */

    class info
    {
        public $db_host = 'localhost';
        public $db_user = 'aviet_video';
        public $db_pass = '55365536';
        public $db_name = 'aviet_video';
    }

?>