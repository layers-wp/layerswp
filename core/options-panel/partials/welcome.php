<?php $this->header(
	array(
		'title' => "Welcome David",
		'intro'	=> "An introduction",
	)
); ?>

<section>

	<img src="<?php echo get_template_directory_uri(); ?>/images/1.jpg" />
	
	<div class="hatch-section-title">
		<h2 class="hatch-heading">Welcome {name}, thank you for testing Hatch!</h2>
		<p class="hatch-excerpt">
			Hatch is a powerful site builder that gives you the tools to create not only the site you want but the site you need.
			The aim of Hatch is to turn the task of making a website into a joyful and easy experience.
		</p>
	</div>


</section>

<?php $this->footer(); ?>