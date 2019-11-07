<div id="main-menu-bg"></div>
</div> <!-- / #main-wrapper -->

<!-- Get jQuery from Google CDN -->
<!--[if !IE]> -->
	<script type="text/javascript"> window.jQuery || document.write('<script src="assets/javascripts/jquery.min.js">'+"<"+"/script>"); </script>
<!-- <![endif]-->
<!--[if lte IE 9]>
	<script type="text/javascript"> window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js">'+"<"+"/script>"); </script>
<![endif]-->


<!-- LanderApp's javascripts -->
<script src="assets/javascripts/bootstrap.min.js"></script>
<script src="assets/javascripts/landerapp.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	var status_alert = '<?php echo $alert_msg; 
	 ?>';
	
//var status_alert = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>'+success_msg +'</strong></div>';
	//var fail_alert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><strong>Oh snap!</strong> Change a few things up and try submitting again.</div>';					
// Javascript code here
		$( ".icon-trash" ).removeClass( "icon-trash" ).addClass( "fa fa-trash-o" );
		$( ".icon-edit" ).removeClass( "icon-edit" ).addClass( "fa fa-edit" );
		$( ".icon-search" ).removeClass( "icon-trash" ).addClass( "fa fa-eye" );

        //$(status_alert).css("position", "absolute");
		//$(status_alert).insertAfter('.breadcrumb');
		$(status_alert).insertAfter('.breadcrumb');
		$(".alert").delay(1000).hide(3000);
});
</script>
<script type="text/javascript">
	init.push(function () {
		
	})
	window.LanderApp.start(init);
</script>

</body>
</html>