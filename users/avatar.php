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
		echo err_r();
		require('../incf/foot.php');
		exit;
	}
	
	# Xử lý nếu nhận thấy id
	if(isset($_GET['id'])){
		$IDUser = new userID();
		
		# Xử lý khi id được get là bạn
		if($_GET['id'] == $IDUser->getInfoID('id', $id)){
			
			# Xử lý form upload
			if(isset($_FILES['avatar']['tmp_name'])){
				
				# Đường dẫn thư mục avatar
				$dir 	 = '../users/avatar';
				
				# Lấy id
				$id_ref  = $IDUser->getInfoID('id', $id);
				
				# Lấy đuôi file và tên mới
				$ext     = explode(".", $_FILES['avatar']['name']);
				$ext_c   = count($ext) - 1;
				$name	 = $id_ref. '.' .$ext[$ext_c];
				$convert = $dir. '/' .$id_ref. '.png';
				
				# Nếu chuyển được lên thì làm như sau
				if(copy($_FILES['avatar']['tmp_name'],$dir.'/'.$name)){
					
					# Khởi tạo biến để insert data
					$DB = new truyVan();
					
					# Đổi đuôi hình vừa upload thành .png
					imagepng(imagecreatefromstring(file_get_contents($dir.'/'.$name)), $convert);
					
					# Xóa file nếu không phải là đuôi PNG
					if($ext[$ext_c] != 'png') unlink($dir.'/'.$name);
					
					# Chèn thông báo vào newsfeed
					$DB->insert('newsfeed', array(
						 'user_id' 		=> $id_ref,
						 'user_id_take' => '0',
						 'prefix'		=> '0',
						 'details' 		=> 'đã cập nhật ảnh đại diện.',
						 'time'    		=> time()
					));
					
					# Hủy class truyVan
					unset($DB);
					
					# Chuyển hướng
					header("Location: ../users/profile.php?id=$id_ref&noti=avatar");
				}
				
				# Tiếp foot và thoát
				require('../incf/foot.php');
				exit;
			}
			
			# Main chính
			require('../incf/head.php');
			
			echo '<div class="well well-sm"><center>Hãy chọn Avatar của bạn và tải lên</center></div>';
			echo '<div id="kv-avatar-errors" class="center-block" style="width:800px;display:none"></div>' .
				 '<form class="text-center" action="avatar.php?id=' .$IDUser->getInfoID('id', $id). '" method="post" enctype="multipart/form-data">' .
				 '<div class="kv-avatar center-block" style="width:200px">' .
				 '<input id="avatar" name="avatar" type="file">' .
				 '</div>' .
				 '</form>';
	/* Dưới đây là một đống SCRIPT để file input hoạt động */
?>
<script>
var btnCust = '<button type="button" class="btn btn-default" title="Add picture tags" ' + 
    'onclick="alert(\'Call your custom code here.\')">' +
    '<i class="glyphicon glyphicon-tag"></i>' +
    '</button>'; 
$("#avatar").fileinput({
    overwriteInitial: true,
    maxFileSize: 1500,
    showClose: false,
    showCaption: false,
    browseLabel: '',
    removeLabel: '',
    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
    elErrorContainer: '#kv-avatar-errors',
    msgErrorClass: 'alert alert-block alert-danger',
    defaultPreviewContent: '<img src="../users/avatar/default.gif" alt="Your Avatar" style="width:160px">',
    layoutTemplates: {main2: '{preview} '  + '{browse} <button type="submit" tabindex="500" title="Upload selected files" class="btn btn-success btn-sm fileinput-upload fileinput-upload-button"><i class="glyphicon glyphicon-upload"></i> Upload</button> '},
    allowedFileExtensions: ["jpg", "png", "gif"]
});
</script>
    </body>
	<script>
    $('#file-fr').fileinput({
        language: 'fr',
        uploadUrl: '#',
        allowedFileExtensions : ['jpg', 'png','gif'],
    });
    $('#file-es').fileinput({
        language: 'es',
        uploadUrl: '#',
        allowedFileExtensions : ['jpg', 'png','gif'],
    });
    $("#file-0").fileinput({
        'allowedFileExtensions' : ['jpg', 'png','gif'],
    });
    $("#file-1").fileinput({
        uploadUrl: '#', // you must set a valid URL here else you will get an error
        allowedFileExtensions : ['jpg', 'png','gif'],
        overwriteInitial: false,
        maxFileSize: 1000,
        maxFilesNum: 10,
        //allowedFileTypes: ['image', 'video', 'flash'],
        slugCallback: function(filename) {
            return filename.replace('(', '_').replace(']', '_');
        }
	});
    /*
    $(".file").on('fileselect', function(event, n, l) {
        alert('File Selected. Name: ' + l + ', Num: ' + n);
    });
    */
	$("#file-3").fileinput({
		showUpload: false,
		showCaption: false,
		browseClass: "btn btn-primary btn-lg",
		fileType: "any",
        previewFileIcon: "<i class='glyphicon glyphicon-king'></i>"
	});
	$("#file-4").fileinput({
		uploadExtraData: {kvId: '10'}
	});
    $(".btn-warning").on('click', function() {
        if ($('#file-4').attr('disabled')) {
            $('#file-4').fileinput('enable');
        } else {
            $('#file-4').fileinput('disable');
        }
    });    
    $(".btn-info").on('click', function() {
        $('#file-4').fileinput('refresh', {previewClass:'bg-info'});
    });
    /*
    $('#file-4').on('fileselectnone', function() {
        alert('Huh! You selected no files.');
    });
    $('#file-4').on('filebrowse', function() {
        alert('File browse clicked for #file-4');
    });
    */
    $(document).ready(function() {
        $("#test-upload").fileinput({
            'showPreview' : false,
            'allowedFileExtensions' : ['jpg', 'png','gif'],
            'elErrorContainer': '#errorBlock'
        });
        /*
        $("#test-upload").on('fileloaded', function(event, file, previewId, index) {
            alert('i = ' + index + ', id = ' + previewId + ', file = ' + file.name);
        });
        */
    });
	</script>
	
<?php
		}
	}
	
	require('../incf/foot.php');
?>