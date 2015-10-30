
( function( exports, $ ) {

	/**
	 * Extend the WP Media Uploader, Select BackBone interface.
	 *
	 * @see /wp-includes/js/media-views.js
	 */

	// Extend wp.media.view.MediaFrame.Select

	var BackupWpMediaFrameSelect = wp.media.view.MediaFrame.Select,
		l10n = wp.media.view.l10n;

	wp.media.view.MediaFrame.Select = BackupWpMediaFrameSelect.extend({

	    initialize: function() {
	    	
	        BackupWpMediaFrameSelect.prototype.initialize.apply( this, arguments );
	        
	        this.on( 'content:render:layers_discover', this.layers_discoverContent, this );
	        
	        //console.log( this.options.state );
	    },
	    
	    /**
		 * Render callback for the router region in the `browse` mode.
		 *
		 * @param {wp.media.view.Router} routerView
		 */
		browseRouter: function( routerView ) {
			
			routerView.set( 'layers_discover', {
				text:     'Discover More Photos',
				priority: 60
			} );
			
			BackupWpMediaFrameSelect.prototype.browseRouter.apply( this, arguments );
		},
		
		/**
		 * Render callback for the content region in the `layers_discover` mode.
		 */
		layers_discoverContent: function() {
			
			this.$el.removeClass( 'hide-toolbar' );
			
			this.content.set( new LayersDiscoverMorePhotos({
				controller: this
			}) );
		},

	});

	// Create a simple default view. based on wp.media.view.UploaderInline.

	var LayersDiscoverMorePhotos;
	LayersDiscoverMorePhotos = wp.media.View.extend({
		
		template:  wp.template('layers-discover-more-photos')
		
	});

} )( wp, jQuery );
