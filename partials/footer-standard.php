<?php do_action( 'layers_before_footer' ); ?>

<section id="footer" <?php layers_wrapper_class( 'footer_site', 'footer-site' ); ?>>
	<?php do_action( 'layers_before_footer_inner' ); ?>
	<div class="<?php if( 'layout-fullwidth' != layers_get_theme_mod( 'footer-width' ) ) echo 'container'; ?> content clearfix">
		<?php // Do logic related to the footer widget area count
		$footer_sidebar_count = layers_get_theme_mod( 'footer-sidebar-count' ); ?>

		<?php if( 0 != $footer_sidebar_count ) { ?>
			<?php do_action( 'layers_before_footer_sidebar' ); ?>
			<div class="grid">
				<?php // Default Sidebar count to 4
				if( '' == $footer_sidebar_count ) $footer_sidebar_count = 4;

				// Get the sidebar class
				$footer_sidebar_class = floor( 12/$footer_sidebar_count ); ?>
				<?php for( $footer = 1; $footer <= $footer_sidebar_count; $footer++ ) { ?>
					<div class="column span-<?php echo esc_attr( $footer_sidebar_class ); ?> <?php if( $footer == $footer_sidebar_count ) echo 'last'; ?>">
						<?php dynamic_sidebar( LAYERS_THEME_SLUG . '-footer-' . $footer ); ?>
					</div>
				<?php } ?>
			</div>
			<?php do_action( 'layers_after_footer_sidebar' ); ?>
		<?php } // if 0 != sidebars ?>

		<?php do_action( 'layers_before_footer_copyright' ); ?>
		<div class="grid copyright">
			<?php if( '' != layers_get_theme_mod( 'footer-copyright-text' ) ) {  ?>
				<div class="column span-6">
					<p class="site-text"><?php echo layers_get_theme_mod( 'footer-copyright-text' ); ?></p>
				</div>
			<?php } ?>
			<div class="column span-6 clearfix t-right">
				<?php wp_nav_menu( array( 'theme_location' => LAYERS_THEME_SLUG . '-footer' , 'container' => 'nav', 'container_class' => 'nav nav-horizontal pull-right', 'fallback_cb' => false )); ?>
			</div>
		</div>
		<?php do_action( 'layers_after_footer_copyright' ); ?>
	</div>
	<?php do_action( 'layers_after_footer_inner' ); ?>

	<?php if( false != layers_get_theme_mod( 'show-layers-badge' ) ) { ?>
		<?php _e( sprintf( '<a class="created-using-layers" target="_blank" tooltip="Built with Layers" href="%s"><span>Built with Layers</span></a>', 'http://www.layerswp.com' ) , 'layerswp' ); ?>
	<?php } ?>
</section><!-- END / FOOTER -->


<?php do_action( 'layers_after_footer' ); ?>