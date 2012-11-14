<?php
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'alternate');

// INCLUDES
require(STYLESHEETPATH.'/lib/paths.php');
require(STYLESHEETPATH.'/lib/gen_functions.php');
require(STYLESHEETPATH.'/lib/breadcrumbs.php');

global $style_url;
global $app_url;
$style_url = get_bloginfo('stylesheet_directory');
$app_url = get_bloginfo('url');

// CURRENT USER
global $current_user;
get_currentuserinfo();
$user_info = get_userdata($current_user->ID);
echo $user_info->user_id;
$user_name = $current_user->first_name.' '.$current_user->last_name;
$user_display_name = $current_user->display_name;
if ($user_name === ' ') {
	$user_name = $user_display_name;
}
else {
	$user_name = $user_name;
}
global $user_city;
$user_city = get_user_meta($user_info->ID,'user_city',true);

// CLASSES
$bodyid = get_bodyid();
$links = 'current-item';

?><!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<?php
// Kissmetrics - remove before handover to Philly
?>
<script type="text/javascript">
  var _kmq = _kmq || [];
  var _kmk = _kmk || '007f169f0f432e69426fc8c264cfc753adc023c6';
  function _kms(u){
    setTimeout(function(){
      var d = document, f = d.getElementsByTagName('script')[0],
      s = d.createElement('script');
      s.type = 'text/javascript'; s.async = true; s.src = u;
      f.parentNode.insertBefore(s, f);
    }, 1);
  }
  _kms('//i.kissmetrics.com/i.js');
  _kms('//doug1izaerwt3.cloudfront.net/' + _kmk + '.1.js');
</script>
<script type="text/javascript">
  _kmq.push(['identify', '<?php echo json_encode($current_user->user_login); ?>']);
</script>
<?php
// End Kissmetrics
?>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width; initial-scale=1.0">

<title><?php wp_title('CityHow &#187; ', true, 'left'); ?></title>

<meta name="description" content="CityHow makes it easy to find and share information about working for city government.">
<meta name="author" content="CityHow">
<meta copyright="author" content="CityHow 2012-<?php echo date('Y');?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<?php // images ?>
<link rel="shortcut icon" href="<?php echo $style_url;?>/images/favicon.ico">
<link rel="image_src" type="image/jpeg" href="<?php echo $style_url;?>/images/logo_blog.jpg"/>

<?php // MEDIA QUERIES.JS (fallback) ?>
<!--[if lt IE 9]>
<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>			
<![endif]-->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head();?>

<?php // STYLESHEETS ?>
<link rel="stylesheet" href="<?php echo $style_url; ?>/lib/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $style_url; ?>/style.css">

<?php // fonts ?>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700,600' rel='stylesheet' type='text/css'>

<?php // PNG FIX for IE6 ?>
<!-- http://24ways.org/2007/supersleight-transparent-png-in-ie6 -->
<!--[if lte IE 6]>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/pngfix/supersleight-min.js"></script>
<![endif]-->

</head>

<body <?php body_class('no-js'); ?> id="<?php echo $bodyid;?>">

<div class="row-fluid row-header">
	<div class="wrapper">
		<div id="banner">
			<div id="brand">
					
				<div id="site-title"><a class="home-brand" href="<?php echo $app_url;?>" title="Go to the home page" rel="Home"><img class="logo" src="<?php echo $style_url;?>/images/logo.png" height="70" alt="CityHow logo" /><h3 class="site-title">CityHow</h3></a>
				</div>	
<?php 
// Dont let logged-out user search for guides
if (is_user_logged_in()) : ?>
				<div id="search-header">
					<ul class="header-elements">
						<li class="header-element header-search <?php if ($bodyid == "search") echo $links; ?>"><a title="Search CityHow" href="#" ><?php get_search_form();?></a></li>
					</ul>
				</div>			
<?php 
endif;
// End if user logged in
?>									
			</div><!--/ brand-->
		</div><!--/ banner-->	
	</div><!--/ wrapper-->
</div><!--/ row-fluid-->	

<div class="row-fluid row-nav">
	<div class="wrapper">
		<div id="nhnavigation" class="nav-container">			
			<div class="nhnav">
				<ul id="nhnav-items">					
					<li class="nhnav-item dropdown <?php 
$findit = 'cities';
$pos = strpos($bodyid,$findit);
if ($pos == "cities")
echo $links; 
?>" id="menu1"><a class="dropdown-toggle" data-toggle="dropdown" href="#menu1">Cities <b class="caret"></b></a>
						<ul class="dropdown-menu">				
<?php
// limit list to User City + Any City
$city_terms = get_terms('nh_cities');
foreach ($city_terms as $city_term) {
	$city_term = $city_term->name;
	if ($city_term == $user_city OR $city_term == 'Any City') {
		$cities[] = $city_term;
	}
}
foreach ($cities as $city) {
	echo '<li class="nhnav-item sub-menu ';
	if ($bodyid == 'cities-'.$city) {
		echo $links;
	}
	echo '">';
	echo '<a title="View all content for '.$city.'" href="'.get_term_link($city,'nh_cities').'">'.$city.'</a>';
	echo '</li>';
}
?>
						</ul>
					</li>							
					<li class="nhnav-item <?php if ($bodyid == "guides") echo $links; ?>"><a title="View CityHow Guides" href="<?php echo $app_url;?>/guides">Guides</a></li>
					<li class="nhnav-item <?php 
$term = term_exists($bodyid,'post_tag');
if ($term !== 0 && $term !== null OR $bodyid == 'topics') {
	echo $links;
}
?>"><a title="View all CityHow Topics" href="<?php echo $app_url;?>/topics">Topics</a></li>
		<li class="nhnav-item <?php if ($bodyid == "ideas") echo $links; ?>"><a title="View CityHow Ideas" href="<?php echo $app_url;?>/ideas">Ideas</a></li>
		<!--li class="nhnav-item <?php if ($bodyid == "blog") echo $links; ?>"><a title="View CityHow Blog" href="<?php echo $app_url;?>/blog">Blog</a></li-->
<?php
if (is_user_logged_in()) {
?>
					<li id="menu2" class="nhnav-item nhnav-avatar dropdown <?php if ($bodyid == "profile" OR $bodyid == "settings") echo $links; ?>"><a class="dropdown-toggle" data-toggle="dropdown" title="View your CityHow profile" href="#menu2">
<?php
$avatar_alt = 'Photo of '.$user_display_name;
$avatar = get_avatar($current_user->ID, '18','identicon',$avatar_alt);
echo $avatar;
?> <?php  echo $user_display_name;?> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li class="nhnav-item sub-menu <?php if ($bodyid == "profile") echo $links; ?>"><a href="<?php echo $app_url;?>/author/<?php echo $current_user->user_login;?>" title="Your profile">Profile</a></li>
							<li class="nhnav-item sub-menu <?php if ($bodyid == "settings") echo $links; ?>"><a href="<?php echo $app_url;?>/settings" title="Settings">Settings</a></li>							
							<li class="nhnav-item sub-menu"><a href="<?php echo wp_logout_url('home_url()');?>" title="Your account">Sign Out</a></li>							
						</ul>
					</li>
<?php
}
else {
?>
					<li class="nhnav-item <?php if ($bodyid == "signin") echo $links; ?>"><a title="Sign In to CityHow" href="<?php echo $app_url;?>/login" >Sign In</a></li>
					<li class="nhnav-item <?php if ($bodyid == "signup") echo $links; ?>"><a title="Create an Account" href="<?php echo $app_url;?>/register" >Sign Up</a>
					</li>
<?php
}
?>	
				</ul>
			</div>				
		</div><!--/ nhnavigation-->
	</div><!--/ wrapper-->
</div><!--/ row-fluid-->