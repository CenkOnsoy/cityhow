<?php
$style_url = get_bloginfo('stylesheet_directory');
$app_url = get_bloginfo('url');
?>
<div id="sidebar-nh" class="sidebar-nh">	

	<div class="widget-side">
		<h5 class="widget-title">Already have an account?</h5>
		<div class="widget-copy">
			<ul class="bullets">
				<li class="bullets"><a class="nhline" href="<?php echo $app_url;?>/lostpwd" title="Forgot password">Forgot your password?</a></li>
			</ul>
		</div>			
	</div><!--/ widget-->
	
	<div class="widget-side">
		<h5 class="widget-title">Create an Account</h5>
		<div class="widget-copy">
			<ul class="bullets">
				<li class="bullets"><a class="nhline" href="<?php echo $app_url;?>/register" title="Sign Up now">Sign Up for Neighborhow</a></li>
			</ul>
		</div>			
	</div><!--/ widget-->	
						
<?php //include(STYLESHEETPATH.'/include_about_nhow.php');?>				

</div><!--/ sidebar-->