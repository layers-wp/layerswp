<?php global $layers_page_title_shown; $layers_page_title_shown = 1; ?>
<?php $details = layers_get_page_title(); ?>
<?php if( isset( $details[ 'title' ] ) || isset( $details[ 'excerpt' ] ) ) { ?>
    <div class="title-container">
        <div class="title">
            <?php layers_bread_crumbs(); ?>

            <?php if( isset( $details[ 'title' ] ) && '' != $details[ 'title' ] ) { ?>
                <h3 class="heading"><?php echo $details[ 'title' ]; ?></h3>
            <?php } // if isset $title ?>
            <?php if( isset( $details[ 'excerpt' ] ) && '' != $details[ 'excerpt' ] ) { ?>
                <p class="excerpt"><?php echo $details[ 'excerpt' ]; ?></p>
            <?php } // if isset $excerpt ?>

        </div>
    </div>
<?php } ?>
