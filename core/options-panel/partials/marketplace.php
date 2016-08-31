<?php // Get the API up and running for the plugin listing
$api = new Layers_API();
$layers_migrator = new Layers_Widget_Migrator();
$current_page = $_GET[ 'page' ];
// Get Site to Ping
$marketplace = ( 'layers-envato-marketplace' == $_GET[ 'page' ] ? 'envato' : 'layerswp' );

// Get Product Type
$valid_types = array( 'stylekits' , 'extensions' , 'themes' );
$type = isset( $_GET[ 'type' ] ) ? $_GET[ 'type' ] : 'themes';
if( !in_array( $type, $valid_types ) ) return;

// Set link and header variables
switch( $type ){
	case 'stylekits' :
		$excerpt = __( 'Style Kits' , 'layerswp' );
		$site_key = 'cc';
		break;
	case 'extensions' :
		$excerpt = __( 'Extensions' , 'layerswp' );
		$site_key = 'cc';
		break;
	default :
		$excerpt = __( 'Themes' , 'layerswp' );
		$site_key = 'tf';
};

// Get product lists
$products = $api->get_product_list( $marketplace, $type );
$fallback_url = 'http://bit.ly/layers-' . $type;

wp_enqueue_script( 'accordion' );

$all_authors = array();
$all_tags = array();
$all_categories = array(); ?>

<section id="layers-marketplace" class="l_admin-area-wrapper">

	<?php $this->marketplace_header( 'Layers Add Ons', '', $marketplace ); ?>

	<div class="l_admin-well l_admin-content">
		<div class="l_admin-browser l_admin-row ">

			<div class="l_admin-column l_admin-span-3 l_admin-marketplace-filter">
				<div class="l_admin-section-title l_admin-tiny">
					<h3 class="l_admin-heading">
						<?php _e( 'Filters' , 'layerswp' ); ?>
					</h3>
					<?php if( !is_wp_error( $products ) ) { ?>
						<p class="l_admin-excerpt">
							<?php _e( 'You are viewing', 'layerswp' ); ?> <span id="intro-product-type"> <?php echo strtolower( $excerpt ); ?>,</span><span id="intro-author"></span> <?php _e( 'ordered', 'layerswp' ); ?> <span id="intro-sort"><?php _e( 'by last updated', 'layerswp' ); ?></span>.
						</p>
					<?php } ?>

					<input id="layers-marketplace-search" type="search" placeholder="<?php _e( 'Search...' , 'layerswp' ); ?>"/>
				</div>
				<?php if( 'layerswp' != $marketplace ) { ?>
					<div class="l_admin-panel">
						<div class="l_admin-panel-title">
							<h3 class="l_admin-heading"><?php _e( 'Product Type' , 'layerswp' ); ?></h3>
						</div>
						<ul class="l_admin-list l_admin-page-list">
							<li <?php if( 'themes' == $type ) { ?>class="active"<?php } ?>>
								<a href="<?php echo admin_url( 'admin.php?page=' . $current_page . '&type=themes&marketplace=' . $marketplace ); ?>">
									<?php _e( 'Themes' , 'layerswp' ); ?>
								</a>
							</li>
							<li <?php if( 'extensions' == $type ) { ?>class="active"<?php } ?>>
								<a href="<?php echo admin_url( 'admin.php?page=' . $current_page . '&type=extensions&marketplace=' . $marketplace ); ?>">
									<?php _e( 'Extensions' , 'layerswp' ); ?>
								</a>
							</li>
							<?php if( 'envato' == $marketplace ) { ?>
								<li <?php if( 'stylekits' == $type ) { ?>class="active"<?php } ?>>
									<a href="<?php echo admin_url( 'admin.php?page=' . $current_page . '&type=stylekits&marketplace=' . $marketplace ); ?>">
										<?php _e( 'Style Kits' , 'layerswp' ); ?>
									</a>
								</li>
							<?php } ?>
						</ul>

					</div>
				<?php } ?>
				<div class="accordion-container">
					<div class="l_admin-panel accordion-section open">
						<div class="l_admin-panel-title accordion-section-title">
							<h3 class="l_admin-heading">
								<?php _e( 'Categories' , 'layerswp' ); ?>
								<a href="#" class="l_admin-pull-right l_admin-label label-subtle l_admin-hide" id="layers-marketplace-categories-clear" data-type="categories"><?php _e( 'Clear', 'layerswp' ); ?></a>
							</h3>
						</div>
						<ul class="l_admin-list l_admin-page-list l_admin-scroll accordion-section-content" id="layers-marketplace-categories">
						</ul>
					</div>

					<div class="l_admin-panel accordion-section">
						<div class="l_admin-panel-title accordion-section-title">
							<h3 class="l_admin-heading">
								<?php _e( 'Tags' , 'layerswp' ); ?>
								<a href="#" class="l_admin-pull-right l_admin-label label-subtle l_admin-hide" id="layers-marketplace-tags-clear" data-type="tags"><?php _e( 'Clear', 'layerswp' ); ?></a>
							</h3>
						</div>
						<div class="l_admin-content-small l_admin-scroll l_admin-soft-hide accordion-section-content" style="display: none;" id="layers-marketplace-tags">
						</div>
					</div>
				</div>
			</div>
			<div class="l_admin-column l_admin-span-9 l_admin-marketplace-products">

				<?php if( is_wp_error( $products ) ) { ?>
					<div class="l_admin-section-title l_admin-large l_admin-content l_admin-t-center">
						<h3 class="l_admin-heading"><?php _e( 'Oh No!' , 'layerswp'); ?></h3>
						<div class="l_admin-media-body l_admin-push-bottom">
							<p class="l_admin-excerpt"><?php _e( sprintf( 'We had some trouble getting the list of %s, luckily though you can just browse the catalogue on Envato.', strtolower( $excerpt ) ) , 'layerswp'); ?></p>
						</div>
						<a href="<?php echo $fallback_url; ?>" class="l_admin-button btn-primary btn-large"><?php _e( 'Browse on Envato', 'layerswp' ); ?></a>
					</div>
				<?php } else { ?>
					<div class="l_admin-marketplace-loading l_admin-section-title l_admin-large l_admin-content l_admin-t-center">
						<h3 class="l_admin-heading"><?php _e( 'Loading...' , 'layerswp'); ?></h3>
						<div class="l_admin-media-body l_admin-push-bottom">
							<p class="l_admin-excerpt"><?php _e( sprintf( 'We\'re busy gathering and sorting the list of %s, hang tight.', strtolower( $excerpt ) ) , 'layerswp'); ?></p>
						</div>
					</div>
				<?php } ?>

				<?php if( !is_wp_error( $products ) ) { ?>

					<div id="layers-marketplace-sort" class="l_admin-row l_admin-hide">
						<div class="l_admin-column l_admin-column l_admin-pull-right">
							<label>
								<?php _e( 'Authors:', 'layerswp' ); ?>
								<select id="layers-marketplace-authors" class="push-right">
									<option value=""><?php _e( 'All Authors' , 'layerswp' ); ?></option>
								</select>
							</label>
							<label>
								<?php _e( 'Order:', 'layerswp' ); ?>
								<select id="layers-marketplace-sortby" name="sortby" data-action="<?php echo admin_url( 'admin.php?page=layers-marketplace&type=' . $type ); ?>" class="push-right">
									<?php if( is_array( $api->get_sort_options() ) ) { ?>
										<?php foreach( $api->get_sort_options() as $value => $info ) { ?>
											<option value="<?php echo $value; ?>" data-excerpt-label="<?php echo esc_attr( $info[ 'excerpt-label' ] ); ?>"><?php echo $info[ 'label' ]; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</label>
						</div>
					</div>

					<div class="l_admin-products l_admin-hide">

						<?php foreach( $products as $key => $details ) {

							if( FALSE === in_array(  ucfirst( strtolower( $details->author ) ), $all_authors ) ){
								$all_authors[] = ucfirst( strtolower( $details->author ) );
							}

							foreach( explode( ',', $details->categories ) as $c_value ){
								if( isset( $all_categories[$c_value] ) ) {
									$c_count = $all_categories[ $c_value ][ 'count' ];
								} else {
									$c_count = 0;
								}
								$all_categories[$c_value] = array(
									'count' => ( $c_count+1 )
								);
							}
							ksort( $all_categories );

							foreach( explode( ',', $details->tags ) as $t_key => $t_value ) {
								if( isset( $all_tags[$t_value] ) ) {
									$t_count = $all_tags[ $t_value ][ 'count' ];
								} else {
									$t_count = 0;
								}
								$all_tags[$t_value] = array(
									'count' => ( $t_count+1 )
								);
							}
							ksort( $all_tags );

							$envato_url = 'http://www.layerswp.com/go-envato/?id=' . esc_attr( $details->id ) . '&item=' . esc_attr( $details->name ) . '&site=' . $site_key; ?>
							<div
								id="product-details-<?php echo $details->id; ?>" class="l_admin-column l_admin-span-6 l_admin-product l_admin-animate" tabindex="0"
								data-id="<?php echo $details->id; ?>"
								data-url="<?php echo esc_attr( $details->url ); ?>"
								data-demo_url="<?php echo esc_attr( $details->demo_url ); ?>"
								data-tags="<?php echo strtolower( $details->tags ); ?>"
								data-categories="<?php echo strtolower( $details->categories ); ?>"
								data-slug="<?php echo sanitize_title( $details->name ); ?>"
								data-updated="<?php echo strtotime( $details->updated ); ?>"
								data-name="<?php echo esc_attr( $details->name ); ?>"
								data-sales="<?php echo esc_attr( $details->sales ); ?>"
								data-rating="<?php echo ( $details->rating ); ?>"
								data-author="<?php echo $details->author; ?>"
								data-price="<?php echo (float) ($details->price); ?>"
								data-trending="<?php echo ( isset( $details->trending ) && '1' == $details->trending ? 1 : 0 ); ?>">
								<label for="layers-preset-layout-<?php echo esc_attr( $details->id ); ?>-radio">
									<?php if( 10 < $details->sales || 3 < $details->rating_count ) { ?>
										<div class="l_admin-product-extra-info l_admin-animate">
											<?php if( 10 < $details->sales ) { ?>
												<span class="l_admin-pull-left l_admin-sales-count">
													<?php echo sprintf( _n( '%s sale', '%s sales', $details->sales, 'layerswp' ), $details->sales ); ?>
												</span>
											<?php } ?>
											<?php if( isset( $details->rating ) && 3 < $details->rating_count ) { ?>
												<div class="l_admin-pull-right theme-rating star-rating l_admin-push-left-small">
													<?php for( $i = 1; $i < 6; $i++ ){ ?>
														<?php if( ceil( $details->rating ) >= $i ) { ?>
															<span class="star star-full"></span>
														<?php } else { ?>
															<span class="star star-empty"></span>
														<?php } ?>
													<?php } ?>
												</div>
											<?php } ?>
										</div>
									<?php } ?>

									<?php if ( isset( $details->media_src ) ) { ?>
										<div class="l_admin-product-screenshot" data-view-item="product-details-<?php echo $details->id; ?>">
											<?php if( 1 == $details->is_img ) { ?>
												<img src="<?php echo esc_url( $details->media_src ); ?>" />
											<?php } else { ?>
												<?php layers_show_html5_video( esc_url( $details->media_src ) ); ?>
											<?php } ?>
										</div>
									<?php } ?>

									<h3 class="l_admin-product-name" id="<?php echo esc_attr( $details->id ); ?>">
										<?php echo esc_html( $details->name ); ?>
									</h3>
									<?php if( isset( $details->short_description ) ) { ?>
										<div class="l_admin-excerpt"><?php echo $details->short_description; ?></div>
									<?php } ?>
									<div class="l_admin-marketplace-actions">
										<a class="l_admin-pull-left button" data-item="<?php echo esc_attr( $details->name ); ?>" data-view-item="product-details-<?php echo $details->id; ?>" href="<?php echo $envato_url; ?>" target="_blank">
											<?php _e( 'Details' , 'layerswp' ); ?>
										</a>
										<a class="l_admin-pull-right button btn-secondary" href="<?php echo $details->url; ?>&type=purchase" target="_blank" data-item="<?php echo esc_attr( $details->name ); ?>" data-price="$ <?php echo (float) ($details->price); ?>">
											<span class="l_admin-price">
												$<?php echo (float) ($details->price); ?>
											</span>
											<?php _e( 'Buy Now' , 'layerswp' ); ?>
										</a>
									</div>
								</label>
								<input  class="l_admin-product-json" type="hidden" value="<?php echo htmlspecialchars( json_encode( $details ) ); ?>" />
							</div>
						<?php } // Get Preset Layouts ?>
					<?php } ?>
				</div>
			</div> <!-- /span-9 -->
		</div>
	</div>
	<?php if( !is_wp_error( $products ) ) { ?>
		<style>
			#layers-marketplace-tags{
				display: block;
			}

			#layers-marketplace-tags input[type="checkbox"] {
				display: none;
			}
			#layers-marketplace-tags input[type="checkbox"]:checked + label{
				background: rgb(46, 162, 204);
			}
			#layers-marketplace-tags input[type="checkbox"]:checked + label span{
				color: rgba( 255, 255, 255, 0.8 );
			}

			#layers-marketplace-tags  label:hover{
				background-color: #e5e5e5;
			}

			#layers-marketplace-tags label{
				background: #f5f5f5;
				border-radius: 0;
				border: 1px solid #ddd;
				box-shadow: none;
				display: block;
				float: left;
				margin: 3px 3px 3px 3px;
				max-width: none;
			}

			#layers-marketplace-tags label span{
				float: left;
			}

			#layers-marketplace-tags label span:first-child{
				border-right: 1px solid rgb(221, 221, 221);
				display: block;
				margin-right: 5px;
				padding: 5px 8px;
			}

			#layers-marketplace-tags label span.label-subtle{
				font-size: 11px;
				padding-top: 5px;
				padding-right: 5px;
			}
		</style>
		<script>
			<?php if( 1 < count( $all_authors ) ) { ?>
				// Fill the author select box
				var layers_market_authors = jQuery.parseJSON( '<?php echo json_encode( $all_authors ); ?>' );
				layers_market_authors.sort();

				jQuery.each( layers_market_authors, function( key, username ){
					jQuery( '#layers-marketplace-authors' ).append( jQuery( '<option value="'+ username.toString().toLowerCase() + '">' + username + '</option>') );
				});
			<?php } else { ?>
				jQuery( '#layers-marketplace-authors' ).parent().hide();
			<?php } ?>

			var layers_market_cats = jQuery.parseJSON( '<?php echo json_encode( $all_categories ); ?>' );

			jQuery.each( layers_market_cats, function( key, value ){
				var key_string = key.toString().toLowerCase();

				jQuery( '#layers-marketplace-categories' ).append(
					jQuery( '<li><label for="cat-' + key_string + '" class="l_admin-animate"><input type="checkbox" name="layers-marketplace-categories" id="cat-' + key_string + '" value="' + key_string + '" /><span class="l_admin-label">' + key_string + '</span> <span class="l_admin-label label-subtle">' + value.count + '</span></label>')
				);
			});

			var layers_market_tags = jQuery.parseJSON( '<?php echo json_encode( $all_tags ); ?>' );

			jQuery.each( layers_market_tags, function( key, value ){
				var key_string = key.toString().toLowerCase();

				jQuery( '#layers-marketplace-tags' ).append(
					jQuery( '<input type="checkbox" name="layers-marketplace-tags" id="tag-' + key_string + '" value="' + key_string + '" /><label for="tag-' + key_string + '"><span class="l_admin-label">' + key_string + '</span> <span class="l_admin-label label-subtle">' + value.count + '</span></label>')
				);
			});
		</script>
	<?php } ?>
	<div class="theme-overlay l_admin-hide">
		 <div class="theme-backdrop"></div>
		 <div class="theme-wrap">
			<div class="theme-header">
				<button class="left dashicons dashicons-no"><span class="screen-reader-text">Show previous</span></button>
				<button class="right dashicons dashicons-no"><span class="screen-reader-text">Show next</span></button>
				<button class="close dashicons dashicons-no"><span class="screen-reader-text">Close details dialog</span></button>
			</div>

			<div class="theme-preview l_admin-hide">
			</div>
			<div class="theme-about">
				<div class="theme-screenshots"><img /></div>
				<div class="theme-info">
					<h3 class="theme-name"></h3>
					<p class="l_admin-row">
						<span class="l_admin-pull-left l_admin-push-right-small">
							<img class="theme-author-img" />
						</span>
						<span class="theme-meta">
							<a class="theme-author" target="_blank"></a>
							<span class="theme-sales"></span>
						</span>
					</p>
					<p class="theme-rating star-rating"></p>
					<p class="theme-description"></p>
					<p class="theme-tags"></p>
				</div>
			</div>

			<div class="theme-actions">
				<div class="inactive-theme">
					<a href="" class="button button-secondary theme-details-link" target="_blank">
						<?php _e( 'More Info' , 'layerswp' ); ?>
					</a>
					<a href="" class="button button-secondary theme-demo-link" data-demo-url='' data-hide-preview-label="<?php _e( 'Hide Preview', 'layerswp' ); ?>" data-show-preview-label="<?php _e( 'Preview', 'layerswp' ); ?>" target="_blank">
						<?php _e( 'Preview' , 'layerswp' ); ?>
					</a>
					<a href="" class="button btn-secondary theme-buy-link" target="_blank">
						<span class="l_admin-price theme-price">
							$<?php echo (float) ($details->price); ?>
						</span>
						<?php _e( 'Buy Now', 'layerswp' ); ?>
					</a>
				</div>
			</div>
		 </div>
	</div>

</section>
<?php $this->footer(); ?>