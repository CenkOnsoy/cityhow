<?php
$style_url = get_bloginfo('stylesheet_directory');
$app_url = get_bloginfo('url');
global $current_user;
get_currentuserinfo();
?>
<div id="sidebar-int" class="sidebar-nh">	
	<div class="widget-side">
		<!--h5 class="widget-title">Details</h5-->
		<div class="widget-copy">
			<div class="guide-details">
				<p class="gde-avatar">
<?php
$authors = get_coauthors($post->ID);
if ($authors) {
	foreach ($authors as $author) {
		$user_info = get_userdata($author->ID);
		$displayname = $user_info->first_name.' '.$user_info->last_name;
		$user_info_alt = 'Photo of '.$displayname;
		$user_info_avatar = get_avatar($author->ID, '48','',$user_info_alt);
		echo $user_info_avatar.'<br/>';
	}	
	
		echo '</p><p class="gde-byline"><span class="byline">by </span>';	
	foreach ($authors as $author) {
		$user_info = get_userdata($author->ID);
		$user_info_slug = $user_info->user_login;
		$displayname = $user_info->first_name.' '.$user_info->last_name;		
		
		$authors_list .= '<a class="nhline" href="'.$app_url.'/author/'.$user_info_slug.'" title="See '.$displayname.'&#39;s profile">'.$displayname.'</a> + ';
	}
	echo rtrim($authors_list, ' + ');
}
?>
			   <br/><span class="byline">on</span> <?php the_date();?><br/>
					<span class="byline">for</span> 
<?php
$post_cities = wp_get_post_terms($post->ID,'nh_cities');
$user_guide_cities = get_post_meta($post->ID,'gde-user-city',true);
// Post cities are official cities
if (!empty($post_cities)) {
	foreach ($post_cities as $post_city) {
		$city = substr($post_city->name,0,-3); //remove state		
		$city_string .= '<a class="nhline" href="'.$app_url.'/cities/'.$post_city->slug.'" title="See other CityHow content for '.$city.'">City of '.$city.'</a>, ';
	}
	echo rtrim($city_string, ', ');
}

// User guide cities are cities input by users
// Not official yet so dont link to a city page
elseif (empty($post_cities)) {
	$user_guide_city = explode(',', $user_guide_cities);
	foreach ($user_guide_city as $city) {
		$slug = str_replace(' ','-', $city);
		$slug = strtolower($slug);
		$city = substr($city,0,-3); //remove state
		$city_string .= 'City of '.$city.', ';
	}
	echo rtrim($city_string, ', ');
}
?>					
				</p>	
				<ul class="gde-meta">
					<li><img src="<?php echo $style_url;?>/lib/timthumb.php?src=/images/icons/heart.png&h=14&zc=1&at=t" alt="Number of likes"> 
<?php 
$tmp = lip_get_love_count($post->ID); 
echo '<span class="nh-love-count">'.$tmp.'</span>';
?>
					</li>
<?php 
if (have_comments()) {
	echo '<li>';
	echo '<img src="'.$style_url.'/lib/timthumb.php?src=/images/icons/comment.png&h=16&zc=1&at=t" alt="Number of comments"> ';
	comments_number( '', '1', '%' );
	echo '</li>'; 
}
?>
					<li><img src="<?php echo $style_url;?>/lib/timthumb.php?src=/images/icons/eyeball.png&h=14&zc=1&at=t" alt="Number of views"> <?php if(function_exists('the_views')) { the_views(); } ?></li>											
				</ul>
			</div><!--/guide details-->
		</div><!--/widget copy-->
	</div><!-- widget-side-->
	
	<div class="widget-side" style="padding-top:1.25em !important;">			
		<!--h5 class="widget-title">Tools</h5-->			
		<div class="widget-copy">
			<div class="guide-details">
<?php 
if (lip_user_has_loved_post($current_user->ID, $post->ID)) {
	echo '<a id="likedthis" title="See your other Likes" href="'.$app_url.'/author/'.$current_user->user_login.'" class="likedthis nhline">You like this</a>';
}
else {
	lip_love_it_link();
}
?>
<?php 
// Turn off when working locally - only works hosted
echo '<div class="jetpack-guide-single">';
//echo sharing_display(); 
echo '</div>';
?>
				<br/><a class="nhline" href="#leavecomment" title="Add Your Comment">Add a Comment</a>
			</div><!--/ guide details-->
		</div>
	</div><!-- widget-side-->

	<div class="widget-side">			
		<h5 class="widget-title">Explore More In</h5>			
		<div class="widget-copy">
			<div class="guide-details">				
				<ul class="gde-actions">
<?php 
$post_tags = wp_get_post_tags($post->ID);
foreach($post_tags as $tag){
	$tag_name = $tag->name;
	$tag_string .= '<a href="'.$app_url.'/topics/'.$tag->slug.'" title="See all CityHow content for '.$tag->name.'">'.$tag->name.'</a>, ';
}	
	echo '<li>';
	echo rtrim($tag_string, ', ');	
	echo '</li>';	
?>
<?php
if (!empty($post_cities)) {
	foreach ($post_cities as $post_city) {
		$city = substr($post_city->name,0,-3); //remove state		
		echo '<li><a class="nhline" href="'.$app_url.'/cities/'.$post_city->slug.'" title="See other CityHow content for this city">'.$city.'</a></li>';
	}
}
?>						
				</ul>
			</div><!--/guide details-->
		</div><!--widget copy-->
	</div><!-- widget-side-->	
</div><!--/ sidebar-->