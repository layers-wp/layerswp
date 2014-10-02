		<div id="back-to-top">
			<a href="#top"><?php _e( 'Back to top' , HATCH_THEME_SLUG ); ?></a>
		</div> <!-- back-to-top -->

		<?php do_action( 'hatch_before_footer' ); ?>
		<footer id="footer" class="well">
			<?php do_action( 'hatch_before_footer_inner' ); ?>
			<div class="container content-main clearfix">

				<div class="row">
					<?php do_action( 'hatch_before_footer_sidebar' ); ?>
					<?php for( $footer = 1; $footer < 5; $footer++ ) { ?>
						<?php dynamic_sidebar( HATCH_THEME_SLUG . '-footer-' . $footer ); ?>
					<?php } ?>
					<?php do_action( 'hatch_after_footer_sidebar' ); ?>
				</div>

				<?php do_action( 'hatch_before_footer_copyright' ); ?>
				<div class="row copyright">
					<div class="column span-6">
						<p class="site-text"><?php echo get_theme_mod( 'hatch-footer-layout-copyright' ); ?></p>
					</div>
					<div class="column span-6 clearfix t-right">
						<?php wp_nav_menu( array( 'theme_location' => HATCH_THEME_SLUG . '-footer' , 'container' => 'nav', 'container_class' => 'nav nav-horizontal pull-right', 'fallback_cb' => false )); ?>
					</div>
				</div>
				<?php do_action( 'hatch_after_footer_copyright' ); ?>
			</div>
			<?php do_action( 'hatch_after_footer_inner' ); ?>
		</footer><!-- END / FOOTER -->
		<?php do_action( 'hatch_after_footer' ); ?>

	</section><!-- END / MAIN SITE #wrapper -->
	<?php do_action( 'hatch_after_site_wrapper' ); ?>
	<?php wp_footer(); ?>
</body>
</html>