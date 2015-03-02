<?php $user = wp_get_current_user(); ?>
<?php $builder_pages = layers_get_builder_pages(); ?>
<section class="layers-area-wrapper">

	<?php $this->header( __( 'Backup' , 'layerswp' ) ); ?>

	<div class="layers-row layers-well layers-content-large">
		<div class="layers-container-large">
			<div class="layers-row">

				<div class="layers-column layers-panel layers-span-8">
					<div class="layers-content layers-push-bottom">
						<div class="layers-section-title layers-small">
							<h3 class="layers-heading"><?php _e( 'Backup your pages' , 'layerswp' ); ?></h3>
							<p class="layers-excerpt">
								<?php _e( 'Convert your Layers pages into regular WordPress pages, preserving the content you have worked so hard to create.' , 'layerswp' ); ?>
							</p>
						</div>
						<div class="layers-load-bar">
							<span class="layers-progress zero"><?php _e( '0%', 'layerswp' ); ?></span>
						</div>
					</div>
					<div class="layers-button-well">
						<a id="layers-backup-pages" class="layers-button btn-large btn-primary"><?php _e( 'Backup my Pages Now' , 'layerswp' ); ?></a>
					</div>
				</div>
				<div class="layers-column layers-span-4">
					<div class="layers-panel layers-push-bottom">
						<div class="layers-panel-title">
							<h4 class="layers-heading"><?php _e( 'Backed Up Pages:' , 'layerswp' ); ?></h4>
						</div>
						<ul class="layers-list">
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