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
	

	# Khởi tạo class
	$IDUser = new userID();
	$TP     = new topic();
		
	# Xử lý nếu phát hiện id
	if(isset($_GET['id'])){
		
		# Kiểm tra xem có phải là id Depend
		# Phải thì hiển thị ra các topic chứa trong depend này và thoát
		# Không phải thì bỏ qua
		if($TP->checkDepend($_GET['id']) == '2'){
			$headtitle = $TP->getInfoDepend($_GET['id']);
			require('../incf/head.php');

			# Hiển thị danh mục bài viết trong depend ở đây
			$TP->getListDepend($_GET['id']);
			require('../incf/foot.php');
			exit;
		}
		
		# Kiểm tra sụ tồn tại của Topic
		# Topic không tồn tại thì báo lỗi
		# Tồn tại topic thì tiếp tục
		if($TP->checkTopic($_GET['id']) == 0){
			$headtitle = 'Lỗi';
			require('../incf/head.php');
			echo '<div class="alert alert-dismissible alert-danger"><strong>Lỗi: </strong>Topic không tồn tại!</div>';
			require('../incf/foot.php');
			exit;
		}
		
		# Chèn head phần topic đang đọc và hiện avatar
		$headtitle = $TP->getInfoDepend($_GET['id']);
		require('../incf/head.php');


		# Hiển thị thông báo tạo topic thành công bằng $_GET['noti']
		if(isset($_GET['noti']) && $_GET['noti'] == 'success')
			echo '<center><div class="well well-sm">Tạo Topic thành công</div></center>';
		
		# Hiển thị thông báo pin topic thành công bằng $_GET['noti']
		if(isset($_GET['noti']) && $_GET['noti'] == 'pin')
			echo '<center><div class="well well-sm">Ghim Topic thành công</div></center>';
		
		# Hiển thị thông báo unpin topic thành công bằng $_GET['noti']
		if(isset($_GET['noti']) && $_GET['noti'] == 'unpin')
			echo '<center><div class="well well-sm">Gỡ ghim Topic thành công</div></center>';
	
		# Hiển thị Breadcrumb
		echo '<ul class="breadcrumb">' .
			 '<li><a href="../index.php">Home</a></li>' .
			 '<li><a href="../forum/index.php">Diễn đàn</a></li>' .
			 '<li><a href="../forum/index.php">' .$TP->getDependTopic($TP->getInfoTopic('depend', $_GET['id'])). '</a></li>' .
			 '<li class="active"><b>' .$TP->getInfoTopic('title', $_GET['id']). '</b></li>' .
			 '</ul>';
		
		# Các hành động của người có rights >= 6
		$AD = '<p align="right">';
		if(($IDUser->getInfoID('rights', $id)) >= 6){
			if($TP->getInfoTopic('notice', $_GET['id']) == 0)
				$AD .= '<a href="notice.php?id=' .$_GET['id']. '&act=pin" class="label label-primary">Pin</a> ';
			else
				$AD .= '<a href="notice.php?id=' .$_GET['id']. '&act=unpin" class="label label-default">Un Pin</a> ';
			
			$AD .= '<a href="delete.php?id=' .$_GET['id']. '" class="label label-danger">Xóa</a>';
		}
		else
			$AD .='';
		$AD .= '</p>';
		
		# Lấy các biến để cho vào hiển thị
		$name   = $IDUser->getInfoID2('nickName', $TP->getInfoTopic('user_id', $_GET['id']));
		$rights = $IDUser->getInfoID2('rights', $TP->getInfoTopic('user_id', $_GET['id']));
		$user_id= $TP->getInfoTopic('user_id', $_GET['id']);
		
		# Hiển thị bài viết chính của Topic

echo' <ul class="chat">';

		echo '<li class="left clearfix"><span class="chat-img pull-left">';
		echo '<img src="../users/avatar/1.png" alt="" class="img-responsive" width="48" height="48"></span>
<div class="chat-body clearfix">
<div class="header">
                                    <strong class="primary-font">' .
			 user($name, $rights, $user_id) .
			 '</strong><small class="pull-right text-muted">
                                        <span class="glyphicon glyphicon-time"></span> ' .realTime($TP->getInfoTopic('time', $_GET['id'])). '</small>
                                </div><p>' .
			 char($TP->getInfoTopic('text', $_GET['id'])) . 
			 '</p></div>
                        </li>' .$AD. '<hr/>';
			 
		# Khởi tạo biến để tạo phân trang
		if(isset($_GET['p']))
			$st = ($_GET['p'] - 1) * 5;
		else
			$st = 0;
		
		# Hiển thị các bình luận


		$TP->getCommentTopic($_GET['id'], $IDUser->getInfoID('rights', $id), $st);
		


echo'</ul>';
		# Hiển thị phân trang bình luận
		$TP->getPagesTopic($_GET['id']);
		
		//echo '</div>';
		
		# Khung comment của thành viên
		if(ID()){
			
			# Form bình luận

echo'<div id="emoticons" class="collapse">
<s
href="#" title=":)"><img
alt=":)" border="0"
src="/images/emoj/1.gif" /></s>
<s
href="#" title=":~"><img
alt=":~" border="0"
src="/images/emoj/2.gif" /></s>
<s
href="#" title=":B"><img
alt=":B" border="0"
src="/images/emoj/3.gif" /></s>
<s
href="#" title=":|"><img
alt=":|" border="0"
src="/images/emoj/4.gif" /></s>
<s
href="#" title="8-)"><img
alt="8-)" border="0"
src="/images/emoj/5.gif" /></s>
<s
href="#" title=":-(("><img
alt=":-((" border="0"
src="/images/emoj/6.gif" /></s>
<s
href="#" title=":$"><img
alt=":$" border="0"
src="/images/emoj/7.gif" /></s>
<s
href="#" title=":x"><img
alt=":x" border="0"
src="/images/emoj/8.gif" /></s>
<s
href="#" title=":z"><img
alt=":z" border="0"
src="/images/emoj/9.gif" /></s>
<s
href="#" title=":(("><img
alt=":((" border="0"
src="/images/emoj/10.gif" /></s>
<s
href="#" title=":-|"><img
alt=":-|" border="0"
src="/images/emoj/11.gif" /></s>
<s
href="#" title=":-h"><img
alt=":-h" border="0"
src="/images/emoj/12.gif" /></s>
<s
href="#" title=":p"><img
alt=":p" border="0"
src="/images/emoj/13.gif" /></s>
<s
href="#" title=":d"><img
alt=":d" border="0"
src="/images/emoj/14.gif" /></s>
<s
href="#" title=":o"><img
alt=":o" border="0"
src="/images/emoj/15.gif" /></s>
<s
href="#" title=":("><img
alt=":(" border="0"
src="/images/emoj/16.gif" /></s>
<s
href="#" title=":+"><img
alt=":+" border="0"
src="/images/emoj/17.gif" /></s>
<s
href="#" title="--b"><img
alt="--b" border="0"
src="/images/emoj/18.gif" /></s>
<s
href="#" title=":q"><img
alt=":q" border="0"
src="/images/emoj/19.gif" /></s>
<s
href="#" title=":t"><img
alt=":t" border="0"
src="/images/emoj/20.gif" /></s>
<s
href="#" title=";p"><img
alt=";p" border="0"
src="/images/emoj/21.gif" /></s>
<s
href="#" title=";-d"><img
alt=";-d" border="0"
src="/images/emoj/22.gif" /></s>
<s
href="#" title=";d"><img
alt=";d" border="0"
src="/images/emoj/23.gif" /></s>
<s
href="#" title=";o"><img
alt=";o" border="0"
src="/images/emoj/24.gif" /></s>
<s
href="#" title=";g"><img
alt=";g" border="0"
src="/images/emoj/25.gif" /></s>
<s
href="#" title="|-)"><img
alt="|-)" border="0"
src="/images/emoj/26.gif" /></s>
<s
href="#" title=":!"><img
alt=":!" border="0"
src="/images/emoj/27.gif" /></s>
<s
href="#" title=":l"><img
alt=":l" border="0"
src="/images/emoj/28.gif" /></s>
<s
href="#" title=":>"><img
alt=":>" border="0"
src="/images/emoj/29.gif" /></s>
<s
href="#" title=":;"><img
alt=":;" border="0"
src="/images/emoj/30.gif" /></s>
<s
href="#" title=";f"><img
alt=";f" border="0"
src="/images/emoj/31.gif" /></s>
<s
href="#" title=";-s"><img
alt=";-s" border="0"
src="/images/emoj/32.gif" /></s>
<s
href="#" title=";?"><img
alt=";?" border="0"
src="/images/emoj/33.gif" /></s>
<s
href="#" title=";-x"><img
alt=";-x" border="0"
src="/images/emoj/34.gif" /></s>
<s
href="#" title=":-f"><img
alt=":-f" border="0"
src="/images/emoj/35.gif" /></s>
<s
href="#" title=";8"><img
alt=";8" border="0"
src="/images/emoj/36.gif" /></s>
<s
href="#" title=";!"><img
alt=";!" border="0"
src="/images/emoj/37.gif" /></s>
<s
href="#" title=";-!"><img
alt=";-!" border="0"
src="/images/emoj/38.gif" /></s>
<s
href="#" title=";xx"><img
alt=";xx" border="0"
src="/images/emoj/39.gif" /></s>
<s
href="#" title=":-bye"><img
alt=":-bye" border="0"
src="/images/emoj/40.gif" /></s>
<s
href="#" title=":wipe"><img
alt=":wipe" border="0"
src="/images/emoj/41.gif" /></s>
<s
href="#" title=":-dig"><img
alt=":-dig" border="0"
src="/images/emoj/42.gif" /></s>
<s
href="#" title=":hanclap"><img
alt=":hanclap" border="0"
src="/images/emoj/43.gif" /></s>
<s
href="#" title="&-("><img
alt="&-(" border="0"
src="/images/emoj/44.gif" /></s>
<s
href="#" title="b-)"><img
alt="b-)" border="0"
src="/images/emoj/45.gif" /></s>
<s
href="#" title=":-l"><img
alt=":-l" border="0"
src="/images/emoj/46.gif" /></s>
<s
href="#" title=":-r"><img
alt=":-r" border="0"
src="/images/emoj/47.gif" /></s>
<s
href="#" title=":-o"><img
alt=":-o" border="0"
src="/images/emoj/48.gif" /></s>
<s
href="#" title=">-|"><img
alt=">-|" border="0"
src="/images/emoj/49.gif" /></s>
<s
href="#" title="p-("><img
alt="p-(" border="0"
src="/images/emoj/50.gif" /></s>
<s
href="#" title=":--|"><img
alt=":--|" border="0"
src="/images/emoj/51.gif" /></s>
<s
href="#" title="x-)"><img
alt="x-)" border="0"
src="/images/emoj/52.gif" /></s>
<s
href="#" title=":*"><img
alt=":*" border="0"
src="/images/emoj/53.gif" /></s>
<s
href="#" title=";-a"><img
alt=";-a" border="0"
src="/images/emoj/54.gif" /></s>
<s
href="#" title="8*"><img
alt="8*" border="0"
src="/images/emoj/55.gif" /></s>
<s
href="#" title="/-showlove"><img
alt="/-showlove" border="0"
src="/images/emoj/56.gif" /></s>
<s
href="#" title="/-rose"><img
alt="/-rose" border="0"
src="/images/emoj/57.gif" /></s>
<s
href="#" title="/-fade"><img
alt="/-fade" border="0"
src="/images/emoj/58.gif" /></s>
<s
href="#" title="/-heart"><img
alt="/-heart" border="0"
src="/images/emoj/59.gif" /></s>
<s
href="#" title="/-break"><img
alt="/-break" border="0"
src="/images/emoj/60.gif" /></s>
<s
href="#" title="/-coffee"><img
alt="/-coffee" border="0"
src="/images/emoj/61.gif" /></s>
<s
href="#" title="/-cake"><img
alt="/-cake" border="0"
src="/images/emoj/62.gif" /></s>
<s
href="#" title="/-li"><img
alt="/-li" border="0"
src="/images/emoj/63.gif" /></s>
<s
href="#" title="/-bome"><img
alt="/-bome" border="0"
src="/images/emoj/64.gif" /></s>
<s
href="#" title="/-bd"><img
alt="/-bd" border="0"
src="/images/emoj/65.gif" /></s>
<s
href="#" title="/-shit"><img
alt="/-shit" border="0"
src="/images/emoj/66.gif" /></s>
<s
href="#" title="/-strong"><img
alt="/-strong" border="0"
src="/images/emoj/67.gif" /></s>
<s
href="#" title="/-weak"><img
alt="/-weak" border="0"
src="/images/emoj/68.gif" /></s>
<s
href="#" title="/-share"><img
alt="/-share" border="0"
src="/images/emoj/69.gif" /></s>
<s
href="#" title="/-v"><img
alt="/-v" border="0"
src="/images/emoj/70.gif" /></s>
<s
href="#" title="/-thanks"><img
alt="/-thanks" border="0"
src="/images/emoj/71.gif" /></s>
<s
href="#" title="/-jj"><img
alt="/-jj" border="0"
src="/images/emoj/72.gif" /></s>
<s
href="#" title="/-punch"><img
alt="/-punch" border="0"
src="/images/emoj/73.gif" /></s>
<s
href="#" title="/-bad"><img
alt="/-bad" border="0"
src="/images/emoj/74.gif" /></s>
<s
href="#" title="/-loveu"><img
alt="/-loveu" border="0"
src="/images/emoj/75.gif" /></s>
<s
href="#" title="/-no"><img
alt="/-no" border="0"
src="/images/emoj/76.gif" /></s>
<s
href="#" title="/-ok"><img
alt="/-ok" border="0"
src="/images/emoj/77.gif" /></s>
<s
href="#" title="/-flag"><img
alt="/-flag" border="0"
src="/images/emoj/78.gif" /></s>
<s
href="#" title=":3"><img
alt=":3" border="0"
src="/images/emoj/curlylips.png" /></s>
<s
href="#" title=":v"><img
alt=":v" border="0"
src="/images/emoj/pacman.png" /></s>
</div>';
			echo '<br/>
<form action="write.php?id=' .$_GET['id']. '" method="post">' .
				 '<div
class="input-group"><textarea class="form-control" rows="3" name="msg" id="contentArea"></textarea>' .
				 '<input type="hidden" name="topic" value="' .$_GET['id']. '">';
				 if(isset($_GET['p']))
					echo '<input type="hidden" name="p" value="' .$_GET['p']. '">';
			echo '<span
class="input-group-addon" id="showsmile" data-toggle="collapse" data-target="#emoticons">
<span class="glyphicon glyphicon-plus-sign"></span>
</span></div><br/>
<button type="submit" name="submit" class="btn btn-default">Gửi</button>' .
				 '</form>' .
				 '<br/>';


?>
<script type="text/javascript">$('#emoticons s').click(function(){var smiley=$(this).attr('title');ins2pos(smiley,'contentArea');});function ins2pos(str,id){var TextArea=document.getElementById(id);var val=TextArea.value;var before=val.substring(0,TextArea.selectionStart);var after=val.substring(TextArea.selectionEnd,val.length);TextArea.value=before+str+after;setCursor(TextArea,before.length+str.length);}
function setCursor(elem,pos){if(elem.setSelectionRange){elem.focus();elem.setSelectionRange(pos,pos);}else if(elem.createTextRange){var range=elem.createTextRange();range.collapse(true);range.moveEnd('character',pos);range.moveStart('character',pos);range.select();}}</script>
<?

	}
		
		# Tiếp foot và thoát
		require('../incf/foot.php');
		exit;
	}
	
	# Head phần mặc định
	$headtitle = 'Diễn đàn';
	require('../incf/head.php');
	
	# Mặc định là list các depend của forum/index.php
	$TP->getDepend($IDUser->getInfoID('rights', $id));
	
	# Hủy class topic
	unset($TP);
	
	# Hủy class userID
	unset($IDUser);
	
	# Tiếp foot
	require('../incf/foot.php');

?>