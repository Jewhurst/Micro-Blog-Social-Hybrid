		</div><!-- col-md-8 col-lg-8 col-sm-12 col-xs-12-->
		<!--<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12 " style="">
			<?php //require 'right-sidebar.php'; ?>
		</div> end third bit -->
	</div><!-- row-->
</div><!-- container-->
<!-- Latest compiled and minified JavaScript -->
	<script src="<?php echo HOME; ?>js/tether.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js" ></script>
	<script src="<?php echo HOME; ?>js/bootstrap.min.js"></script>
	<script src="<?php echo HOME; ?>js/charactercounter.js" ></script>
	<script>
		$(function(){
			//Example #1
            $("#name").characterCounter();
            $("#profile").characterCounter();            
            $("#blotter").characterCounter();            
		});
	</script>
	
		<script>
			$('#profile').keyup(function(){
				var thetext = $(this).val();				
				if (thetext.length > 500) {
					$('#workroom_submit').attr('disabled', 'disabled');
				} else {
					$('#workroom_submit').removeAttr('disabled');
				}
			})		
		</script>
		
		<script type="text/javascript">
var url = document.location.toString();
if (url.match('#')) {
    $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
} 

// Change hash for page-reload
$('.nav-tabs a').on('shown.bs.tab', function (e) {
    window.refresh.hash = e.target.hash;
})
    </script>
</body>