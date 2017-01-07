		 $('#shoutbox').keydown(function() {
		 var key = e.which;
		 if (key == 13) {
		 // As ASCII code for ENTER key is "13"
		 $('#shoutbox').submit(); // Submit form code
		 }
		 });