<?php if ( !defined( 'HABARI_PATH' ) ) { die('No direct access'); } ?>
    </section>
    <footer class="main">
        <?php $theme->display ( 'banner_bottom' ); ?>
        <?php $theme->area('footer'); ?>
        <p><?php Options::out('title'); _e(' is powered by'); ?> <a href="http://www.habariproject.org/" title="Habari">Habari</a></p>
        <p><a href="<?php URL::out( 'atom_feed', array( 'index' => '1' ) ); ?>"><?php _e('Atom Entries'); ?></a> <?php _e('and'); ?> <a href="<?php URL::out( 'atom_feed_comments' ); ?>"><?php _e('Atom Comments'); ?></a></p>
        <?php $theme->footer(); ?>
    </footer>
    <?php
    /* In order to see DB profiling information:
        1. Insert this line in your config file: define( 'DEBUG', true );
        2.Uncomment the followng line
    */
    // include 'db_profiling.php';
    ?>
</body>
</html>
