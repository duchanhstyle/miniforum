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


	# Script load phòng chat
	echo "<script>
	$(document).ready(function(){
	$(\"#datachat\").load(\"chat.php\");
	var refreshId = setInterval(function() {
	$(\"#datachat\").load('/chat.php');
	$(\"#datachat\").slideDown(\"slow\");
	}, 2000);
	$('#msg').keydown(function() {
	if (event.keyCode == 13) {
	$.post('/chat.php', $(\"#shoutbox\").serialize(),function(chatoutput) {
	$(\"#datachat\").html(chatoutput);
	});
	$(\"#msg\").val(\"\");
	$(\"textarea\").val('');
	return false;
	}
	});
	$(\"#shoutbox\").validate({
	debug: false,
	submitHandler: function(form) {
	$.post('/chat.php', $(\"#shoutbox\").serialize(),function(chatoutput) {
	$(\"#datachat\").html(chatoutput);
	});
	$(\"#msg\").val(\"\");
	}
	});
	});
	</script>";
	
	# Script load dame
	echo "<script>
	$(document).ready(function(){
	$(\"#datadame\").load(\"../dame.php\");
	var refreshId = setInterval(function() {
	$(\"#datadame\").load('/../dame.php');
	$(\"#datadame\").fadeIn(\"slow\");
	}, 5000);
	});
	</script>";
	//alert("Hello! I am an alert box!!");
?>	
	<script type="text/javascript">
	$(document).ready(function(){
	$("#btn").click(function(){
	$("#myModal").modal('show');
	});
	});
	</script>
	
	<script type="text/javascript">
	$(document).ready(function(){
	$("#ib").click(function(){
	$("#newInbox").modal('show');
	});
	});
	</script>
	
	<script>
	var reg = angular.module('reg',[])
	.controller( "RegisterCtrl",['$scope', function($scope) {
	$scope.success=false;
    $scope.register = function(){
    $scope.success=true;
    }
    }]);
	</script>
	
	<script>
	var newDepend = angular.module('newDepend',[])
	.controller( "RegisterCtrl",['$scope', function($scope) {
	$scope.success=false;
    $scope.register = function(){
    $scope.success=true;
    }
    }]);
	</script>