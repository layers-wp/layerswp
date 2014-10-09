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
						<li data-page_id="<?php echo get_the_ID(); ?>" class="<?php echo ( in_array( get_the_ID() , array() ) ? 'tick' : 'cross' ); ?>">
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
	jQuery(function($){
		var $total_pages = $( '.hatch-feature-list li' ).length;
		var $complete_pages = 1;

		function hatch_backup_builder_page( $pageid, $page_li ){
			$.post(
				'<?php echo admin_url( "admin-ajax.php" ); ?>',
				{
					action: 'hatch_backup_builder_pages',
					pageid: $pageid,
				},
				function(data){

					console.log( data );
					// Check off this page
					$page_li.removeClass( 'cross' ).addClass( 'tick' );

					// Load Bar %
					var $load_bar_width = $complete_pages/$total_pages;
					var $load_bar_percent = 100*$load_bar_width;
					$( '.hatch-progress' ).animate({width: $load_bar_percent+"%"} ).text( Math.round($load_bar_percent)+'%');

					if( 100 == $load_bar_percent ) $( '.hatch-progress' ).delay(500).addClass( 'complete' ).text( 'Your pages have been successfully backed up!' );;

					// Set Complete count
					$complete_pages++;

					if( $complete_pages <= $total_pages ){
						var $next_page_li = $page_li.next();
						var $pageid = $next_page_li.data( 'page_id' );

						hatch_backup_builder_page( $pageid, $next_page_li );
					}
				}
			) // $.post
		}

		$(document).on( 'click', '#hatch-backup-pages', function(){

			// Adjust progress bar
			$( '.hatch-progress' ).removeClass( 'zero complete' ).css('width' , 0);

			// "Hi Mom"
			var $that = $( '.hatch-feature-list li' ).eq(0);
			var $pageid = $that.data( 'page_id' );

			hatch_backup_builder_page( $pageid, $that );
		});
	});
</script>
<?php $this->footer(); ?>