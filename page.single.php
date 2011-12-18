<?php if ( !defined( 'HABARI_PATH' ) ) { die('No direct access'); } ?>
<?php $theme->display ( 'header'); ?>
        <section id="entries">
            <?php $theme->display ( 'banner_top' ); ?>
            <section id="navigation">
	            <?php if ( $previous = $post->descend() ): ?>
	            <div class="left"> &laquo; <a href="<?php echo $previous->permalink ?>" title="<?php echo $previous->slug ?>"><?php echo $previous->title ?></a></div>
	            <?php endif; ?>
	            <?php if ( $next = $post->ascend() ): ?>
	            <div class="right"><a href="<?php echo $next->permalink ?>" title="<?php echo $next->slug ?>"><?php echo $next->title ?></a> &raquo;</div>
	            <?php endif; ?>

	            <div class="clear"></div>
            </section>
            <article class="<?php echo $post->statusname; ?>">
	            <header class="entry">
	            <h3 class="entry-title"><a href="<?php echo $post->permalink; ?>" title="<?php echo $post->title; ?>"><?php echo $post->title_out; ?></a></h3>
	            <span class="published"><?php echo $post->pubdate->text_format('{Y}-{m}-{d}'); ?>
	            <?php if ( $show_author ) { 
	                    echo '<span class="author">';
	                    _e( 'by %s', array( $post->author->displayname ) ); 
	                    echo '</span>';
	                } 
	            ?>
	            </header>
	            <section class="entry">
	            <?php echo $post->content_out; ?>
	            </section>
	            <footer>
	                <?php if ( count( $post->tags ) > 0 ) { ?>
		                    <p class="entry-tags"><?php echo $post->tags_out; ?></p>
                    <?php } ?>
                    <?php echo $theme->comments_link($post); ?>
                    <?php if ( $loggedin ) { ?>
		                    <br /><span class="entry-edit"><a href="<?php echo $post->editlink; ?>" title="<?php _e('Edit post'); ?>"><?php _e('Edit'); ?></a></span>
                    <?php } ?>
                    <?php $theme->display ( 'comments' ); ?>
                </footer>
            </article>
        </section>	    
	    <?php $theme->display ( 'sidebar' ); ?>
<?php $theme->display ( 'footer' ); ?>
