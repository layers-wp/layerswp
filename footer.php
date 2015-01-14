
			<div id="back-to-top">
				<a href="#top"><?php _e( 'Back to top' , LAYERS_THEME_SLUG ); ?></a>
			</div> <!-- back-to-top -->
		</section>
		<?php do_action( 'layers_before_footer' ); ?>
		<?php
		// Apply customizer footer background settings.
		layers_inline_styles( 'footer', 'background', array(
			'background' => array(
				'color' => layers_get_theme_mod( 'footer-customization-background-background-color' ),
				'repeat' => layers_get_theme_mod( 'footer-customization-background-background-repeat' ),
				'position' => layers_get_theme_mod( 'footer-customization-background-background-position' ),
				'stretch' => layers_get_theme_mod( 'footer-customization-background-background-stretch' ),
				'image' => layers_get_theme_mod( 'footer-customization-background-background-image' ),
				'fixed' => false, // hardcode (not an option)
			),
		) );
		layers_inline_styles( 'footer', 'color', array( 'color' => layers_get_theme_mod( 'footer-customization-font-color-main' ) ) );
		layers_inline_styles( 'footer a', 'color', array( 'color' => layers_get_theme_mod( 'footer-customization-font-color-link' ) ) );
		?>
		<footer id="footer" class="footer-site well">
			<?php do_action( 'layers_before_footer_inner' ); ?>
			<div class="<?php if( 'layout-fullwidth' != layers_get_theme_mod( 'footer-layout-width' ) ) echo 'container'; ?>  content-vertical-large clearfix">
				<?php // Do logic related to the footer widget area count
				$footer_sidebar_count = layers_get_theme_mod( 'footer-layout-widget-area-count' ); ?>

				<?php if( 0 != $footer_sidebar_count ) { ?>
					<div class="row">
						<?php do_action( 'layers_before_footer_sidebar' ); ?>
						<?php // Default Sidebar count to 4
						if( '' == $footer_sidebar_count ) $footer_sidebar_count = 4;

						// Get the sidebar class
						$footer_sidebar_class = floor( 12/$footer_sidebar_count ); ?>
						<?php for( $footer = 1; $footer <= $footer_sidebar_count; $footer++ ) { ?>
							<div class="column span-<?php echo $footer_sidebar_class; ?> <?php if( $footer == $footer_sidebar_count ) echo 'last'; ?>">
								<?php dynamic_sidebar( LAYERS_THEME_SLUG . '-footer-' . $footer ); ?>
							</div>
						<?php } ?>
						<?php do_action( 'layers_after_footer_sidebar' ); ?>
					</div>
				<?php } // if 0 != sidebars ?>

				<?php do_action( 'layers_before_footer_copyright' ); ?>
				<div class="row copyright">
					<?php if( '' != layers_get_theme_mod( 'footer-text-copyright' ) ) {  ?>
						<div class="column span-6">
							<p class="site-text"><?php echo layers_get_theme_mod( 'footer-text-copyright' ); ?></p>
						</div>
					<?php } ?>
					<div class="column span-6 clearfix t-right">
						<?php wp_nav_menu( array( 'theme_location' => LAYERS_THEME_SLUG . '-footer' , 'container' => 'nav', 'container_class' => 'nav nav-horizontal pull-right', 'fallback_cb' => false )); ?>
					</div>
				</div>
				<?php do_action( 'layers_after_footer_copyright' ); ?>
			</div>
			<?php do_action( 'layers_after_footer_inner' ); ?>
		</footer><!-- END / FOOTER -->
		<?php do_action( 'layers_after_footer' ); ?>

	</section><!-- END / MAIN SITE #wrapper -->
	<?php do_action( 'layers_after_site_wrapper' ); ?>
	<?php wp_footer(); ?>
</body>
</html>