		<div id="back-to-top">
			<a href="#top"><?php _e( 'Back to top' , HATCH_THEME_SLUG ); ?></a>
		</div> <!-- back-to-top -->

		<?php do_action( 'hatch_before_footer' ); ?>
		<footer id="footer">
			<div class="container content-main clearfix">

				<div class="row">
					<div class="column span-4 offset-2">
						<div class="marketing">
							<h4><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="Obox Themes" /></h4>
							<p>Our mission is to give you the best designed, most user friendly WordPress themes that the world has to offer. It is our mission to fulfil your requirements as a business owner, freelancer or writer.</p>
						</div>
					</div>
					<div class="column span-2">
						<h5 class="section-nav-title">Support</h5>
						<ul class="link-list">
							<li><a href="">Documentation</a></li>
							<li><a href="">Get Support</a></li>
							<li><a href="">Contact Us</a></li>
							<li><a href="">Support Policy</a></li>
							<li><a href="">Terms and Conditions</a></li>
						</ul>
					</div>
					<div class="column span-2">
						<h5 class="section-nav-title">Themes &amp; Extensions</h5>
						<ul class="link-list">
							<li><a href="">Pricing</a></li>
							<li><a href="">WordPress Themes</a></li>
							<li><a href="">WordPress Plugins</a></li>
							<li><a href="">eCommerce Plugin</a></li>
							<li><a href="">Theme Modifications</a></li>
						</ul>
					</div>
					<div class="column span-2">
						<h5 class="section-nav-title">We Recommend</h5>
						<ul class="link-list">
							<li><a href="">Theme Modifiers</a></li>
							<li><a href="">WordPress Hosting</a></li>
							<li><a href="">Become an Affiliate</a></li>
							<li><a href="">WordPress.com</a></li>
						</ul>
					</div>
				</div>

				<div class="row copyright">
					<div class="column span-6">
						<p class="madeinafrica">Made at the tip of Africa. &copy; {year} {site name}.</p>
					</div>
					<div class="column span-6 clearfix t-right">
						 <nav class="nav nav-horizontal pull-right">
							<?php wp_nav_menu( array( 'theme_location' => 'footer' ) ); ?>
						</nav>
					</div>
				</div>
			</div>

		</footer><!-- END / FOOTER -->
		<?php do_action( 'hatch_after_footer' ); ?>

	</section><!-- END / MAIN SITE #wrapper -->
	<?php do_action( 'hatch_after_site_wrapper' ); ?>
	<?php wp_footer(); ?>
</body>
</html>