
			<div id="back-to-top">
				<a href="#top"><?php _e( 'Back to top' , 'layerswp' ); ?></a>
			</div> <!-- back-to-top -->

			<?php if ( 'header-sidebar' == layers_get_theme_mod( 'header-menu-layout' ) ) { ?>
				<?php get_template_part( 'partials/footer' , 'standard' ); ?>
			<?php } ?>

		</section>


		<?php if ( 'header-sidebar' == layers_get_theme_mod( 'header-menu-layout' ) ) { ?>
			</div><!-- /header side wrapper -->
		<?php } else {
			get_template_part( 'partials/footer' , 'standard' );
		}?>

	</div><!-- END / MAIN SITE #wrapper -->
	<?php do_action( 'layers_after_site_wrapper' ); ?>
	<?php wp_footer(); ?>
</body>
</html>