<?php $user = wp_get_current_user(); ?>
<section class="hatch-container hatch-content-large">

	<div class="hatch-section-title hatch-large invert hatch-content-massive" style="background: url(<?php echo get_template_directory_uri(); ?>/images/beta-zero.jpg) top repeat;">
		<div class="hatch-container">
			<h2 class="hatch-heading">Welcome <?php echo ( ( '' == $user->user_firstname ) ? $user->display_name : $user->user_firstname ); ?>, thank you for beta testing Hatch!</h2>
			<p class="hatch-excerpt">
				Hatch is a powerful site builder that gives you the tools to create not only the site you want but the site you need.
				The aim of Hatch is to turn the task of making a website into a joyful and easy experience.
			</p>
			<a href="<?php echo admin_url( 'customize.php' ); ?>" class="hatch-button btn-massive btn-primary">Get Started</a>
		</div>
	</div>

	<div class="hatch-row hatch-well hatch-content-large hatch-push-bottom">
		<div class="hatch-section-title">
			<h4 class="hatch-heading">What you can and can't do</h4>
			<p class="hatch-excerpt">
				We are calling this release 'Beta Zero,' as it's just grown up to be out of private Alpha.
				However, it's not yet fully functional. We have high ambitions and much to add, but for now we have set some limits:
			</p>
		</div>
		<div class="hatch-row">
			<div class="hatch-column hatch-span-6">
				<div class="hatch-section-title hatch-tiny">
					<h5 class="hatch-heading">What you can do:</h5>
				</div>
				<ul class="hatch-feature-list">
					<li class="tick">Create a page builder template</li>
					<li class="tick">Mess around with the design bar</li>
					<li class="tick">Configure: Slider widget</li>
					<li class="tick">Configure: Portfolio widget</li>
					<li class="tick">Configure: Modules widget</li>
					<li class="tick">Configure: Contact widget</li>
				</ul>
			</div>
			<div class="hatch-column hatch-span-6">
				<div class="hatch-section-title hatch-tiny">
					<h5 class="hatch-heading">What you can't do:</h5>
				</div>
				<ul class="hatch-feature-list">
					<li class="cross">Change headers</li>
					<li class="cross">Change footers</li>
					<li class="cross">Switch fonts</li>
					<li class="cross">Edit colors</li>
					<li class="cross">Edit the blog layout</li>
					<li class="cross">Use WooCommerce</li>
				</ul>
			</div>
		</div>
	</div>

	<div class="hatch-row hatch-well hatch-content-large hatch-push-bottom">
		<div class="hatch-section-title">
			<h3 class="hatch-heading">Getting Started</h3>
			<p class="hatch-excerpt">
				Our intention of Beta Zero is to gather feedback around the page building interface.
				In order to get started please follow the steps below:
			</p>
		</div>
		<p>To get you started we have added some demo content to this theme so that you don't start from a blank page. If you would like a fresh start, click here.</p>
		<ol>
			<li>Create a new Page</li>
			<li>Choose "Page Builder" under the Template drop down</li>
			<li>Click Publish</li>
			<li>Click "Build your Page"</li>
			<li>Click the "Page Builder" accordion</li>
		</ol>
		<a href="/wp-admin/customize.php" class="hatch-button btn-primary">Create a Page</a>
	</div>

	<footer class="hatch-row">
		<p>
			Hatch is a product of <a href="http://oboxthemes.com/theme/">Obox Themes</a>. For questions and feedback please <a href="mailto:david@obox.co.za">email David directly</a>.
		</p>
	</footer>


</section>

<?php $this->footer(); ?>