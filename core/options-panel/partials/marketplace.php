<?php // Get the API up and running for the plugin listing
$api = new Layers_API();
$layers_migrator = new Layers_Widget_Migrator();

$valid_types = array( 'stylekits' , 'extensions' , 'themes' );

$type = isset( $_GET[ 'type' ] ) ? $_GET[ 'type' ] : 'themes';

if( !in_array( $type, $valid_types ) ) return; ?>

<?php switch( $type ){
	case 'stylekits' :
		$excerpt = __( 'Style Kits' , 'layerswp' );
		$products = $api->get_stylekit_list();
		$fallback_url = 'http://bit.ly/layers-stylekits';
		break;
	case 'extensions' :
		$excerpt = __( 'Extensions' , 'layerswp' );
		$products = $api->get_extension_list();
		$fallback_url = 'http://bit.ly/layers-extensions';
		break;
	default :
		$excerpt = __( 'Themes' , 'layerswp' );
		$products = $api->get_theme_list();
		$fallback_url = 'http://bit.ly/layers-themes';
};

$all_authors = array(); ?>

<section id="layers-marketplace" class="layers-area-wrapper">

	<?php $this->marketplace_header( 'Marketplace' ); ?>

	<div class="layers-row layers-well layers-content-large">
		<div class="layers-browser">
			<div class="layers-products">
				<?php if( is_wp_error( $products ) ) { ?>
					<div class="layers-section-title layers-large layers-content-large layers-t-center">
						<h3 class="layers-heading"><?php _e( 'Oh No!' , 'layerswp'); ?></h3>
						<div class="layers-media-body layers-push-bottom">
							<p class="layers-excerpt"><?php _e( sprintf( 'We had some trouble getting the list of %s, luckily though you can just browse the catalogue on Envato.', strtolower( $excerpt ) ) , 'layerswp'); ?></p>
						</div>
						<a href="<?php echo $fallback_url; ?>" class="layers-button btn-primary btn-large"><?php _e( 'Go to Envato', 'layerswp' ); ?></a>
					</div>
				<?php } else { ?>
					<?php foreach( $products->matches as $key => $details ) {
						if( FALSE === array_search( $details->author_username, array_column( $all_authors, 'username' ) ) ){
							$all_authors[] = array(
								'username' => $details->author_username,
								'url' => $details->author_url
							);
						} ?>
						<!--
						<?php print_r( $details ); ?>
						-->
						<div id="product-details-<?php echo $key; ?>" class="layers-product layers-animate active" tabindex="0"  data-rating="<?php echo ( $details->rating->count > 0 ? $details->rating->rating : '' ) ; ?>" data-author="<?php echo $details->author_username; ?>">
							<input type="hidden" value='<?php echo htmlspecialchars( json_encode( $details ) ); ?>' />
							<label for="layers-preset-layout-<?php echo esc_attr( $key ); ?>-radio">
								<h3 class="layers-product-name" id="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $details->name ); ?></h3>

								<?php /**
								* Get images and/or video
								**/
								$previews = $details->previews;

								if ( isset( $previews->icon_with_landscape_preview->landscape_url ) && strpos( $previews->icon_with_landscape_preview->landscape_url, '//' ) ) {
									$is_img = 1;
									$image_src = $previews->icon_with_landscape_preview->landscape_url ;
								} else if ( isset( $previews->icon_with_video_preview->landscape_url ) && strpos( $previews->icon_with_video_preview->landscape_url, '//' ) ) {
									$is_img = 1;
                           			$image_src = $previews->icon_with_video_preview->landscape_url ;
								} else if ( isset( $previews->icon_with_video_preview->video_url ) && strpos( $previews->icon_with_video_preview->video_url, '//' ) ) {
									$is_img = 0;
									$video_src = $previews->icon_with_video_preview->video_url ;
								} ?>

								<?php if( isset( $image_src ) ) { ?>
									<div class="layers-product-screenshot" data-view-item="product-details-<?php echo $key; ?>">
										<?php if( 1 == $is_img ) { ?>
											<img src="<?php echo esc_url( $image_src ); ?>" />
										<?php } else { ?>
											<?php layers_show_html5_video( esc_url( $video_src ) ); ?>
										<?php } ?>
									</div>
								<?php } ?>

								<div class="layers-marketplace-actions">
									<?php if( isset( $details->rating ) && 2 <= $details->rating->count && 2<= $details->rating->rating ) { ?>
										<div class="layers-pull-left theme-rating star-rating layers-push-left-small" style="display: block;">
											<?php for( $i = 1; $i < 6; $i++ ){ ?>
												<?php if( $details->rating->rating >= $i ) { ?>
													<span class="star star-full"></span>
												<?php } else { ?>
													<span class="star star-empty"></span>
												<?php } ?>
											<?php } ?>
										</div>
									<?php } ?>
									<a class="layers-pull-right layers-button btn-primary layers-push-right-small" href="<?php echo esc_attr( $details->url ); ?>" target="_blank">
										<?php _e( 'Buy for ' , 'layerswp' ); ?>
										$<?php echo (float) ($details->price_cents/100); ?>
									</a>
									<a class="layers-pull-right layers-button btn-subtle layers-push-right-small" data-view-item="product-details-<?php echo $key; ?>" href="<?php echo esc_attr( $details->url ); ?>" target="_blank">
										<?php _e( 'Details' , 'layerswp' ); ?>
									</a>
								</div>
							</label>
						</div>
					<?php } // Get Preset Layouts ?>
					<script>
						// Fill the author select box
						var layers_market_authors = jQuery.parseJSON( '<?php echo json_encode( $all_authors ); ?>' );

						jQuery.each( layers_market_authors, function( key, value ){
							jQuery( '#layers-marketplace-authors' ).append( jQuery( '<option value="'+ value.username + '">' + value.username + '</option>') );
						});

					</script>
				<?php } ?>
			</div>
		</div>
	</div>

	<div class="theme-overlay layers-hide">
		 <div class="theme-backdrop"></div>
		 <div class="theme-wrap">
			  <div class="theme-header">
					<button class="left dashicons dashicons-no"><span class="screen-reader-text">Show previous</span></button>
					<button class="right dashicons dashicons-no"><span class="screen-reader-text">Show next</span></button>
					<button class="close dashicons dashicons-no"><span class="screen-reader-text">Close details dialog</span></button>
			  </div>
			  <div class="theme-about">
					<div class="theme-screenshots"><img /></div>
					<div class="theme-info">
						<h3 class="theme-name"></h3>
						<p class="layers-row">
							<span class="layers-pull-left layers-push-right-small">
								<img class="theme-author-img" />
							</span>
							<span class="theme-meta">
								<span class="theme-author"></span>
								<span class="theme-sales"></span>
							</span>
						</p>
						<p class="theme-rating star-rating"></p>
						<p class="theme-description"></p>
					</div>
			  </div>

			  <div class="theme-actions">
					<div class="inactive-theme">
						<a href="" class="button button-secondary theme-demo-link">
							<?php _e( 'View Demo' , 'layerswp' ); ?>
						</a>
						<a href="" class="button button-primary theme-buy-link">
							<?php _e( 'Buy for $', 'layerswp' ); ?> <span class="theme-price"></span>
						</a>
					</div>
			  </div>
		 </div>
	</div>

</section>
<?php $this->footer(); ?>