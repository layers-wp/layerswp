<?php $user = wp_get_current_user(); ?>
<?php $builder_pages = new WP_Query( array( 'post_type' => 'page' , 'posts_per_page' => -1 , 'meta_key' => '_wp_page_template', 'meta_value' => HATCH_BUILDER_TEMPLATE ) ); ?>

<section class="hatch-container hatch-content-large">

	<div class="hatch-row hatch-well hatch-content-large hatch-push-bottom">
		<div class="hatch-section-title">
			<h4 class="hatch-heading"><?php _e(' Hatch Page Backup' , HATCH_THEME_SLUG ); ?></h4>
			<p class="hatch-excerpt">
				<?php _e( 'This page will convert your Hatch Builder pages into regular WordPress pages, preserving the content you have worked so hard to curate.' , HATCH_THEME_SLUG ); ?>
			</p>
				<a id="hatch-backup-pages" class="hatch-button btn-large btn-primary"><?php _e( 'Backup my Pages Now' , HATCH_THEME_SLUG ); ?></a>
		</div>
		<div class="hatch-row">
			<div class="hatch-column hatch-span-12">
				<div class="hatch-section-title hatch-tiny">
					<h5 class="hatch-heading"><?php _e( 'Progress:' , HATCH_THEME_SLUG ); ?></h5>
				</div>
				<div class="hatch-load-bar hatch-push-bottom">
					<span class="hatch-progress zero">0%</span>
				</div>

				<div class="hatch-section-title hatch-tiny">
					<h5 class="hatch-heading"><?php _e( 'Backed Up Pages:' , HATCH_THEME_SLUG ); ?></h5>
				</div>
				<ul class="hatch-feature-list">
					<?php while( $builder_pages->have_posts() ){
						$builder_pages->the_post(); ?>
						<li data-id="<?php echo get_the_ID(); ?>" class="<?php echo ( in_array( array() , get_the_ID() ) ? 'tick' : 'cross' ); ?>">
							<?php echo the_title(); ?>
						</li>
					<?php } // foreach builder_page ?>
				</ul>
			</div>
		</div>
	</div>
	<footer class="hatch-row">
		<p>
			Hatch is a product of <a href="http://oboxthemes.com/">Obox Themes</a>. For questions and feedback please <a href="mailto:david@obox.co.za">email David directly</a>.
		</p>
	</footer>


</section>
<script>
	jQuery(function($) {
		$(document).on( 'click', '#hatch-backup-pages', function(){
			$total = $( '.hatch-feature-list li' ).length;
			var $complete = 1;
			var $i = 1;
			$( '.hatch-progress' ).removeClass( 'zero' ).css('width' , 0);
			$( '.hatch-feature-list li' ).each(function(){
				// "Hi Mom"
				var $that = $(this);

				setTimeout(function(){
					// Page tick
					$that.removeClass( 'cross' ).addClass( 'tick' );

					// Load Bar %
					var $load_bar_width = $complete/$total;
					var $load_bar_percent = 100*$load_bar_width;
					$( '.hatch-progress' ).animate({width: $load_bar_percent+"%"} ).text( Math.round($load_bar_percent)+'%');

					if( 100 == $load_bar_percent ) $( '.hatch-progress' ).delay(500).addClass( 'complete' ).text( 'Your pages have been successfully backed up!' );;

					// Set Complete count
					$complete++;

				}, 1000*$i);
	 			$i++;
			});
		});
	});
</script>
<?php $this->footer(); ?>