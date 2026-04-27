<?php
/*
 * Template Name: SST About Us
 */
get_header();

get_template_part( 'common/content', 'breadcrumbs' ); 

while ( have_posts() ): the_post();
	$post_id        = get_the_ID();
	$is_philosophy_enabled      = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_enable_philosophy', 1 ) );
	$philosophy_title        = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_philosophy_title', 1 ) );
	$philosophy_desc           = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_philosophy_desc', 1 ) );
	$is_enabled_leadership          = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_enable_leadership', 1 ) );
	$leadership_title            = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_leadership_title', 1 ) );
	$leadership_desc        = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_leadership_desc', 1 ) );
	$banners       = get_post_meta( $post_id, '_ttm_banner_slide_about_group', 1 );
	$is_values_enabled        = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_enable_values_section', 1 ) );
	$values_title        = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_values_title', 1 ) );
	$values_group       = get_post_meta( $post_id, '_ttm_values_group', 1 );
	$is_company_enabled      = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_enable_company', 1 ) );
	$company_title      = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_company_title', 1 ) );
	$comapny_group       = get_post_meta( $post_id, '_ttm_company_group', 1 );
	$is_reviews_enabled      = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_enable_reviews', 1 ) );
	$num_reviews      = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_num_reviews', 1 ) );
	$title_reviews      = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_title_reviews', 1 ) );
	$enable_video_section      = carbon_get_the_post_meta( 'enable_video_section' );
	$video_aboutus_title      = carbon_get_the_post_meta( 'video_aboutus_title' );
	$video_aboutus_desc      = carbon_get_the_post_meta( 'video_aboutus_desc' );
	$video_lists           = carbon_get_the_post_meta( 'video_aboutus_list' );
	$is_location_enabled      = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_enable_location', 1 ) );
	$location_title        = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_title_location', 1 ) );
?>

<div class="page-content fullwidth"> 

<div class="holder">

<div class="content-slider">

	<?php if ( is_array( $banners ) && $banners[0]['_ttm_banner_img_id'] != '' ): ?>
        <div id="billboard">
            <div class="slides slick-slider">
				<?php foreach ( $banners as $banner ): ?>
					<?php if ( array_key_exists( '_ttm_banner_img_id', $banner ) ) : ?>
                        <div class="slide-holder slide-1">

							<div class="slider-img">

							<?php echo wp_get_attachment_image( $banner['_ttm_banner_img_id'], 'full' ); ?>
                           

							</div>

							<div class="slider-content">

							<img src="<?php echo get_theme_file_uri('assets/images/quta-slider.png'); ?>">

							<h2 class="title">	<?php echo  $banner['_ttm_banner_heading']; ?>
                           </h2>

							<p><?php   echo wp_strip_all_tags($banner['_ttm_banner_para']); ?></p>

							<div class="slider-arrows">
							<i class="fa fa-long-arrow-left slick-arrow" style="display: inline-block;"></i>
							<i class="fa fa-long-arrow-right slick-arrow" style="display: inline-block;"></i>
							</div>

							</div>

							</div>
								
					<?php endif; ?>
				<?php endforeach; ?>
            </div>
	
        </div><!-- Billboard Container -->
	<?php endif; ?>
</div> 

<div class="info-txt">

<?php echo the_content(); ?>

</div>

</div>

</div>
<?php if($is_enabled_leadership): ?>
<div class="page-content fullwidth leadership">

   <div class="holder">

   

   <div class="title"><h2><?php echo $leadership_title ; ?></h2></div>

<div class="content-slider">
   <div id="billboard">
            <div class="slides slick-slider">
			
				<?php
			$team = new WP_Query( [
				'post_type'      => 'team',
				'posts_per_page' => - 1
			] );
			if ( $team->have_posts() ): ?>
<?php while ( $team->have_posts() ): $team->the_post();
							$post_id     = get_the_ID();
							$designation = get_post_meta( $post_id, '_qwl_team_designation', 1 ); ?>
					
                            <article class="col">

	  <figure>

	  
											<?php if ( has_post_thumbnail() ) :
												the_post_thumbnail();
											else: ?>
                                                <img src="<?php echo get_theme_file_uri('assets/images/avtar-4.jpg'); ?>" alt="<?php the_title(); ?>">
											<?php endif; ?>
                                        

	  <h4 class="name"><?php the_title(); ?></h4> 

	  <figcaption>

	  <a href="<?php the_permalink(); ?>"><?php echo $designation; ?><span><img src="<?php echo get_theme_file_uri('assets/images/leader-arrow.png'); ?>">  </span></a>

	  </figcaption> 

	  </figure>

      </article>
					
				<?php endwhile; 
				wp_reset_postdata(); ?>
									
<?php endif; ?>			
			
            </div>
						<div class="slider-arrows">
							<i class="fa fa-arrow-left slick-arrow" style="display: inline-block;"></i>
							<i class="fa fa-arrow-right slick-arrow" style="display: inline-block;"></i>
							</div>	    			
			
            </div>
	
       
</div> 

   
					

<div class="clearfix"></div>

<div class="info-txt">

<?php echo $leadership_desc; ?>

</div>

	  

	  

   </div>

</div>
<?php endif; ?>
<?php if($is_company_enabled): ?>
<div class="page-content fullwidth timeline">

   <div class="holder">

<div class="title"><h2><?php echo $company_title; ?></h2></div>	
<?php 

function sortById($x, $y) {
    return $x['_ttm_company_year'] - $y['_ttm_company_year'];
}
usort($comapny_group, 'sortById');

?>
	<section id="cd-timeline" class="cd-container">
	
<?php 
$j=0;
$k=0;
$res = array();
foreach($comapny_group as $key=>$vals){

$k++;
  //foreach($val as $kk => $v){
	  $res[$vals['_ttm_company_year']][$k] =$vals;
 // }
  

}
foreach($res as $key=>$val){
	
	  	//echo "<pre>";
//print_r($val);

?>
<div class="year"><h3><?php echo $key; ?></h3></div>
<?php
foreach($val as $key=>$finalval){
		$j++;
if($j%2==1):
?>
	<div class="flex-box">

		<div class="cd-timeline-block">

			<div class="cd-timeline-img cd-picture">

			</div> <!-- cd-timeline-img -->



			<div class="cd-timeline-content"> 

				<h2><?php echo $finalval['_ttm_company_title']; ?></h2>

				<p><?php echo $finalval['_ttmcompany_desc']; ?></p>

			</div> <!-- cd-timeline-content -->

		</div> <!-- cd-timeline-block -->

		

		

			<div class="cd-timeline-block">

			<div class="cd-timeline-img cd-movie">

			</div> <!-- cd-timeline-img -->



			<div class="cd-timeline-content img">

			<?php
			if(!empty($finalval['_ttm_company_img_id'])):
			echo wp_get_attachment_image( $finalval['_ttm_company_img_id'], 'full' );
			endif;
			?>

			</div> <!-- cd-timeline-content -->

		</div> <!-- cd-timeline-block -->	



</div>	
<?php endif; 
if($j%2==0):
?>
	

	<div class="flex-box">

	

			<div class="cd-timeline-block">

			<div class="cd-timeline-img cd-movie">

			</div> <!-- cd-timeline-img -->



			<div class="cd-timeline-content img">

			<?php
			if(!empty($finalval['_ttm_company_img_id'])):
			echo wp_get_attachment_image( $finalval['_ttm_company_img_id'], 'full' );
			endif;
			?>

			</div> <!-- cd-timeline-content -->

		</div> <!-- cd-timeline-block -->		

	

	

		<div class="cd-timeline-block">

			<div class="cd-timeline-img cd-picture">

			</div> <!-- cd-timeline-img -->



			<div class="cd-timeline-content"> 

				<h2><?php echo $finalval['_ttm_company_title']; ?></h2>

				<p><?php echo $finalval['_ttmcompany_desc']; ?></p>

			</div> <!-- cd-timeline-content -->

		</div> <!-- cd-timeline-block -->
</div>	
<?php 
endif;
} } ?>


	</section> <!-- cd-timeline -->

</div>

</div>

<?php endif; ?>
<?php if($is_values_enabled || $is_philosophy_enabled): ?>
 <div class="page-content fullwidth our-values-wrap">

<div class="holder">


<?php if($is_values_enabled): ?>
<div class="our-values">

<div class="title"><h2><?php echo $values_title; ?></h2></div>

<table class="table">

  <tbody>
<?php foreach ( $values_group as $value_group ): ?>

    <tr>
<?php if ( array_key_exists( '_ttm_value_heading', $value_group ) ) : ?>
      <th scope="row"><?php echo $value_group['_ttm_value_heading'];  ?></th>
<?php endif; ?>
<?php if ( array_key_exists( '_ttm_value_para', $value_group ) ) : ?>
      <td><?php echo $value_group['_ttm_value_para'];  ?></td>
<?php endif; ?>
    </tr>

<?php endforeach; ?>
   
  </tbody>

</table>

</div>  
<?php endif; ?>



<?php if($is_philosophy_enabled): ?>
<div class="our-philosophy">

<div class="title"><h2><?php echo $philosophy_title; ?></h2></div>

<p><?php echo $philosophy_desc; ?></p>

</div>

<?php endif; ?>

</div>  

</div>  
<?php endif; ?>


<?php if($is_reviews_enabled): ?>
<div class="page-content fullwidth reviews">

<div class="holder">

<div class="title"><h2><?php echo $title_reviews; ?></h2></div>
<?php 
$testimonials = new WP_Query( [
	'post_type'      => 'testimonials',
	'post_status'    => 'publish',
	'posts_per_page' => $num_reviews,
] );
$i =0;
if ( $testimonials->have_posts() ): ?>
<?php $count =  count($testimonials);?>
<?php while ( $testimonials->have_posts() ): $testimonials->the_post();
						$post_id = get_the_ID(); ?>
<?php 
$i++;
if($i%2==1): ?>
<div class="review-box">

<div class="review-box-holder">

<div class="thumb"><?php if ( has_post_thumbnail() ): ?>
						<?php the_post_thumbnail(); ?>
						<?php else: ?>
						<img src="<?php echo get_theme_file_uri( 'assets/images/default_avatar.png' ); ?>" alt="<?php the_title(); ?>" width="90" height="90"/>
											<?php endif; ?></div>

<div class="content">

<?php echo the_content(); ?>
<div class="designation"><?php echo get_post_meta( $post_id, '_qwl_testimonial_author', 1 ); ?>, <span><?php echo get_post_meta( $post_id, '_qwl_testimonial_author_desc', 1 ); ?></span></div> 

</div>

</div>

</div>
<?php endif; ?>

<?php if($i%2==0): ?>
<div class="review-box right">

<div class="review-box-holder">

<div class="content">

<?php echo the_content(); ?>

<div class="designation"><?php echo get_post_meta( $post_id, '_qwl_testimonial_author', 1 ); ?>, <span><?php echo get_post_meta( $post_id, '_qwl_testimonial_author_desc', 1 ); ?></span></div> 

</div>

<div class="thumb"><?php if ( has_post_thumbnail() ): ?>
						<?php the_post_thumbnail(); ?>
						<?php else: ?>
						<img src="<?php echo get_theme_file_uri( 'assets/images/default_avatar.png' ); ?>" alt="<?php the_title(); ?>" width="90" height="90"/>
											<?php endif; ?></div>

</div>

</div>
<?php endif; ?>
<?php endwhile;
wp_reset_postdata(); ?>

<?php endif; ?>



</div>  

</div>  
<?php endif; ?>

<?php if($enable_video_section): ?>
<div class="page-content fullwidth col2-container videos">

<div class="holder">
<?php

				if ( is_array( $video_lists ) && count( $video_lists ) > 0 ):
				$k=0;
					foreach ( array_reverse($video_lists) as $list ):
					$k++;
						$video_image_link = esc_url( wp_get_attachment_image_src( $list['video_image'], 'full' )[0] );
						$video_image_alt = esc_html( get_post_meta( $list['video_image'], '_wp_attachment_image_alt', true ) );
						if($k<=2):
						?>
<article class="col">
<div onclick="thevid=document.getElementById('thevideo<?php echo $k; ?>'); thevid.style.display='block'; this.style.display='none'"><img src="<?php echo $video_image_link; ?>" style="cursor:pointer" /></div><div id="thevideo<?php echo $k; ?>" style="display:none">

<iframe width="560" height="315" src="<?php echo esc_url( $list['video_url'] ); ?>" frameborder="0" allowfullscreen></iframe>

</div>



</article>

						<?php
						endif;
					endforeach;
				endif; ?>


<article class="col video-content">

<div class="video-content-holder">

<div class="title"><h2><?php echo $video_aboutus_title; ?></h2></div>

<p><?php echo $video_aboutus_desc; ?></p>

</div>

</article>

<?php
				if ( is_array( $video_lists ) && count( $video_lists ) > 0 ):
				$k=0;
				
					foreach ( array_reverse($video_lists) as $list ):
					$k++;
						$video_image_link = esc_url( wp_get_attachment_image_src( $list['video_image'], 'full' )[0] );
						$video_image_alt = esc_html( get_post_meta( $list['video_image'], '_wp_attachment_image_alt', true ) );
						if($k==3):
						?>
<article class="col">
<div onclick="thevid=document.getElementById('thevideo<?php echo $k; ?>'); thevid.style.display='block'; this.style.display='none'"><img src="<?php echo $video_image_link; ?>" style="cursor:pointer" /></div><div id="thevideo<?php echo $k; ?>" style="display:none">

<iframe width="560" height="315" src="<?php echo esc_url( $list['video_url'] ); ?>" frameborder="0" allowfullscreen></iframe>
</article>

						<?php
						endif;
					endforeach;
				endif; ?>


</div>  

</div>  
<?php endif; ?>
<?php if($is_location_enabled): ?>
<div class="page-content fullwidth our-location">

<div class="holder">

<div class="title"><h2><?php echo $location_title; ?></h2></div>

<div id="map_wrapper">
    <div id="map_canvas" class="mapping"></div>
</div>

<div class="clearfix"></div>
<div class="col-row">
<?php 
$query_loc         = new WP_Query( [
			'post_type'      => 'location',
			'post_status'    => 'publish',
			'cat' => 'headquarters',
			//'posts_per_page' => 7,
		] ); 
		
		
if ( $query_loc->have_posts() ): ?>
<?php  while ( $query_loc->have_posts() ): $query_loc->the_post();
								$post_id      = get_the_ID();
								$address      = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_address', 1 ) );
								$city         = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_city', 1 ) );
								$state        = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_state', 1 ) );
								$zip          = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_zip', 1 ) );
								$latitude          = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_address_latitude', 1 ) );
								$logitude          = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_address_longitude', 1 ) );
								$main_phone   = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_main_phone', 1 ) );
								$full_address = [ $address, $city, $state, $zip ];  ?>
								
			
<article class="col">

<div class="col-holder">
<h3><?php the_title(); ?></h3>
<?php echo implode( ', ', $full_address ); ?>
<?php echo $main_phone != '' ? '<br/><b>Phone:</b> ' . $main_phone : ''; ?>

</div>

</article>
<?php endwhile; ?>
<?php endif; ?>
</div>  
</div>  

</div>  
<?php endif; ?>
<?php

endwhile;
?>


<script>
jQuery(function($) {
    // Asynchronously Load the map API 
    var script = document.createElement('script');
    script.src = "//maps.googleapis.com/maps/api/js?key=AIzaSyBgE83Q4Y-rLyuavMZhNQ9OmKnfggWwz-s&callback=initialize";
    document.body.appendChild(script);
});

function initialize() {
    var map;
    var bounds = new google.maps.LatLngBounds();
    var mapOptions = {
        mapTypeId: 'roadmap'
    };
                    
    // Display a map on the page
    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
    map.setTilt(45);
        
    // Multiple Markers

								
			


    var markers = [
		<?php 
$query_loc1         = new WP_Query( [
			'post_type'      => 'location',
			'post_status'    => 'publish',
			'cat' => 'headquarters',
			//'posts_per_page' => 7,
		] ); 
		
		
if ( $query_loc1->have_posts() ): ?>
<?php  while ( $query_loc1->have_posts() ): $query_loc1->the_post();
								$post_id      = get_the_ID();
								$address      = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_address', 1 ) );
								$city         = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_city', 1 ) );
								$state        = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_state', 1 ) );
								$zip          = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_zip', 1 ) );
								$main_phone   = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_main_phone', 1 ) );
								$full_address = [ $address, $city, $state, $zip ];
							$address1 = $address .','. $city.','. $state.','. $zip; // Address
					$geo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyDQlkgt45snz66UIhsaEjbCac82qM1W69M&address='.urlencode($address1).'&sensor=false');

				$geo = json_decode($geo, true); // Convert the JSON to an array
		
				$latitude = $geo['results'][0]['geometry']['location']['lat']; // Latitude
				$longitude = $geo['results'][0]['geometry']['location']['lng']; // Longitude	
								
								?>
        ['<?php echo the_title(); ?>', <?php echo $latitude; ?>,<?php echo $longitude; ?>],
		    <?php endwhile; ?>
			<?php endif; ?>
    ];
                        
    // Info Window Content
    var infoWindowContent = [
		<?php 
$query_loc2         = new WP_Query( [
			'post_type'      => 'location',
			'post_status'    => 'publish',
			'cat' => 'headquarters',
			//'posts_per_page' => 7,
		] ); 
		
		
if ( $query_loc2->have_posts() ): ?>
<?php  while ( $query_loc2->have_posts() ): $query_loc2->the_post();
								$post_id      = get_the_ID();
								$address      = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_address', 1 ) );
								$city         = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_city', 1 ) );
								$state        = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_state', 1 ) );
								$zip          = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_zip', 1 ) );
								$main_phone   = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_main_phone', 1 ) );
								$full_address = [ $address, $city, $state, $zip ];
							$address1 = $address .','. $city.','. $state.','. $zip; ?>
        ['<div class="info_content">' +
        '<h3><?php echo the_title(); ?></h3>' +
        '<p><?php echo implode( ', ', $full_address ); ?></p>' +        
		'</div>'],
        <?php endwhile; ?>
		<?php endif; ?>
    ];

    
    // Display multiple markers on a map
    var infoWindow = new google.maps.InfoWindow(), marker, i;
    
    // Loop through our array of markers & place each one on the map  
    for( i = 0; i < markers.length; i++ ) {
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
        bounds.extend(position);
        marker = new google.maps.Marker({
            position: position,
            map: map,
            title: markers[i][0]
        });
        
        // Allow each marker to have an info window    
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infoWindow.setContent(infoWindowContent[i][0]);
                infoWindow.open(map, marker);
            }
        })(marker, i));

        // Automatically center the map fitting all markers on the screen
        map.fitBounds(bounds);
    }

    // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
        this.setZoom(5);
        google.maps.event.removeListener(boundsListener);
    });
    
}
</script>
<script>
jQuery(document).ready(function(){
jQuery('.leadership .content-slider .slick-slider').slick({
    prevArrow: jQuery('.fa-arrow-left'),
    nextArrow: jQuery('.fa-arrow-right'),
 dots: false,
 arrows: true,
 slidesToShow: 6,
 slidesToScroll: 6,
   responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 6,
        slidesToScroll: 6,
        infinite: true,
        dots: false
      }
    },
    {
      breakpoint: 780,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
});
});
</script>
<?php
get_footer();
