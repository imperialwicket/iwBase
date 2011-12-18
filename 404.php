<?php if ( !defined( 'HABARI_PATH' ) ) { die('No direct access'); } ?>
<?php $theme->display ( 'header' ); ?>
<!-- error -->
        <section id="entries">
        <?php $theme->display ( 'banner_top' ); ?>
        <article class="<?php echo $post->statusname; ?>">
	            <header class="entry">
	            <h3 class="error"><?php _e('CDIV'); ?></h3>
	            </header>
	            <section class="entry">
	                <p><?php _e('The requested post was not found.'); ?></p>
	            </section>
            </article>
	    </section>	    
	    <?php $theme->display ( 'sidebar' ); ?>
<?php $theme->display ('footer'); ?>
