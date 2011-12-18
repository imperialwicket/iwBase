<?php if ( !defined( 'HABARI_PATH' ) ) { die('No direct access'); } ?>
<?php $theme->display( 'header'); ?>
        <section id="entries">
            <?php $theme->display ( 'banner_top' ); ?>
            <?php foreach ( $posts as $post ) { ?>
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
                    </footer>
	            </article>
            <?php } ?>
            <section id="pager">
    	        <?php echo $theme->prev_page_link(_t('newer')); ?> <?php echo $theme->page_selector( null, array( 'leftSide' => 2, 'rightSide' => 2 ) ); ?> <?php echo $theme->next_page_link(_t('older')); ?>
	        </section>
        </section>	    
	    <?php $theme->display ( 'sidebar' ); ?>
<?php $theme->display ('footer'); ?>
