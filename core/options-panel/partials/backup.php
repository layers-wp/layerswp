<?php $user = wp_get_current_user(); ?>
<?php $builder_pages = layers_get_builder_pages(); ?>
<section class="l_admin-area-wrapper">

	<?php $this->header( __( 'Transfer' , 'layerswp' ) ); ?>

	<div class="l_admin-row layers-well layers-content">
		<div class="l_admin-container-large">
			<div class="l_admin-row">

				<div class="l_admin-column layers-panel layers-span-8">
					<div class="l_admin-content layers-push-bottom">
						<div class="l_admin-section-title layers-small">
							<h3 class="l_admin-heading"><?php _e( 'Transfer your pages' , 'layerswp' ); ?></h3>
							<p class="l_admin-excerpt">
								<?php _e( 'Convert your Layers pages into regular WordPress pages, preserving the content you have worked so hard to create.' , 'layerswp' ); ?>
							</p>
						</div>
						<div class="l_admin-load-bar">
							<span class="l_admin-progress zero"><?php _e( '0%', 'layerswp' ); ?></span>
						</div>
					</div>
					<div class="l_admin-button-well">
						<a id="layers-backup-pages" class="l_admin-button btn-large btn-primary"><?php _e( 'Transfer my Pages Now' , 'layerswp' ); ?></a>
					</div>
				</div>
				<div class="l_admin-column layers-span-4">
					<div class="l_admin-panel layers-push-bottom">
						<div class="l_admin-panel-title">
							<h4 class="l_admin-heading"><?php _e( 'Transferred Up Pages:' , 'layerswp' ); ?></h4>
						</div>
						<ul class="l_admin-list">
							<?php foreach( $builder_pages as $post ){ ?>
								<li data-page_id="<?php echo $post->ID; ?>" class="<?php echo ( in_array( $post->ID , array() ) ? 'tick' : 'cross' ); ?>">
									<?php echo $post->post_title; ?>
								</li>
							<?php } // foreach builder_page ?>
						</ul>
					</div>
				</div>

			</div>
		</div>
	</div>
</section>

<?php $this->footer(); ?>