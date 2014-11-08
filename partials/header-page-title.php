<?php global $page_title_shown; $page_title_shown = 1; ?>
<?php $details = hatch_get_page_title(); ?>
<div class="title-container">
    <div class="title">
            <?php hatch_bread_crumbs(); ?>

            <?php if( isset( $details[ 'title' ] ) ) { ?>
                <h3 class="heading"><?php echo $details[ 'title' ]; ?></h3>
            <?php } // if isset $title ?>
            <?php if( isset( $details[ 'excerpt' ] ) ) { ?>
                <p class="excerpt"><?php echo $details[ 'excerpt' ]; ?></p>
            <?php } // if isset $excerpt ?>
        </div>
</div>