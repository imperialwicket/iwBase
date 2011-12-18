<?php if ( !defined( 'HABARI_PATH' ) ) { die('No direct access'); } ?>
<?php

/**
 * IWBase is a starter theme class meant to expedite Habari theme creation
 *
 *  IWBase borrows from the K2, Charcoal, and Mzingi Habari themes, and the Skeleton responsive framework.
 *
 * @package Habari
 */

class IWBase extends Theme
{
    /**
     * Default option for the style sheet
     */
    var $defaults = array(
		    'theme_style' => 'style_fluid.css',
		    );

	/**
	 * Do stuff when your theme is activated - usually add a custom, theme-specific block, or something like that.
	 */
	public function action_theme_activated()
	{
	    $opts = Options::get_group( strtolower( get_class( $this ) ) );
		if ( empty( $opts ) ) {
			Options::set_group( strtolower( get_class( $this ) ), $this->defaults );
		}
	}
    

	/**
	 * Execute on theme init to apply these filters to output
	 */
	public function action_init_theme()
	{
		// Apply Format::autop() to comment content...
		Format::apply( 'autop', 'comment_content_out' );
		// Apply Format::tag_and_list() to post tags...
		Format::apply( 'tag_and_list', 'post_tags_out' );
		
		// Remove the comment on the following line to limit post length on the home page to 1 paragraph or 100 characters
		//Format::apply_with_hook_params( 'more', 'post_content_out', _t('more'), 100, 1 );
	}

	/**
	 * Add additional template variables to the template output.
	 *
	 *  You can assign additional output values in the template here, instead of
	 *  having the PHP execute directly in the template.  The advantage is that
	 *  you would easily be able to switch between template types (RawPHP/Smarty)
	 *  without having to port code from one to the other.
	 *
	 *  Note that the variables added here should possibly *always* be added,
	 *  especially 'user'.
	 *
	 *  Also, this function gets executed *after* regular data is assigned to the
	 *  template.  So the values here, unless checked, will overwrite any existing
	 *  values.
	 */
	public function add_template_vars ( ) {
		
		parent::add_template_vars();
		
		$this->home_tab = 'Blog';
		$this->show_author = false;
		
		$this->add_template( 'k2_text', dirname( __FILE__ ) . '/formcontrol_text.php' );
		
		if ( !isset( $this->pages ) ) {
			$this->pages = Posts::get( array( 'content_type' => 'page', 'status' => 'published', 'nolimit' => true ) );
		}
		
		if ( User::identify()->loggedin ) {
			Stack::add( 'template_header_javascript', Site::get_url('scripts') . '/jquery.js', 'jquery' );
		}
		
		if ( ( $this->request->display_entry || $this->request->display_page ) && isset( $this->post ) && $this->post->title != '' ) {
			$this->page_title = $this->post->title . ' - ' . Options::get('title');
		}
		else {
			$this->page_title = Options::get('title');
		}
		
		if ( $this->request->display_entries_by_tag ) {
			if ( count($this->include_tag) && count($this->exclude_tag) == 0 ) {
				$this->tags_msg = _t('Posts tagged: %s', array(Format::tag_and_list($this->include_tag)));
			}
			else if ( count($this->exclude_tag) && count($this->include_tag) == 0 ) {
				$this->tags_msg = _t('Posts not tagged: %s', array(Format::tag_and_list($this->exclude_tag)));
			}
			else {
				$this->tags_msg = _t('Posts tagged: %s and not %s', array(Format::tag_and_list($this->include_tag), Format::tag_and_list($this->exclude_tag)));
			}
		}
		
		$this->theme_style = Options::get( strtolower( get_class( $this )) . '__theme_style');
		
	}
    
    public function action_theme_ui()
    {
        $ui = new FormUI( strtolower( get_class( $this ) ) );      
        $ui->append( 'fieldset', 'style_fs', _t( 'Style' ) );
        $ui->style_fs->append( 'select', 'theme_style', 
                                strtolower( get_class( $this ) ) . '__theme_style', 
                                _t( 'Theme style:' ), 
                                array(  'style_fluid.css' => 'fluid',
                                        'style_fixed.css' => 'fixed',
			                          ),
			                    'formcontrol_select' );
		// Save
		$ui->append( 'submit', 'save', _t( 'Save' ) );
		$ui->set_option( 'success_message', _t( 'Options saved' ) );
		$ui->out();
    }

	public function k2_comment_class( $comment, $post )
	{
		$class = 'class="comment';
		if ( $comment->status == Comment::STATUS_UNAPPROVED ) {
			$class.= '-unapproved';
		}
		// check to see if the comment is by a registered user
		if ( $u = User::get( $comment->email ) ) {
			$class.= ' byuser comment-author-' . Utils::slugify( $u->displayname );
		}
		if ( $comment->email == $post->author->email ) {
			$class.= ' bypostauthor';
		}

		$class.= '"';
		return $class;
	}

/**
 * If comments are enabled, or there are comments on the post already, output a link to the comments.
 *
 */
	public function comments_link( $post )
	{
		if ( !$post->info->comments_disabled || $post->comments->approved->count > 0 ) {
			$comment_count = $post->comments->approved->count;
			echo "<span class=\"commentslink\"><a href=\"{$post->permalink}#comments\" title=\"" . _t('Comments on this post') . "\">{$comment_count} " . _n( 'Comment', 'Comments', $comment_count ) . "</a></span>";
		}

	}

	/**
	 * Customize comment form layout. Needs thorough commenting.
	 */
	public function action_form_comment( $form ) { 
		$form->cf_commenter->caption = '<small><strong>' . _t('Name') . '</strong></small><span class="required">' . ( Options::get('comments_require_id') == 1 ? ' *' . _t('Required') : '' ) . '</span>';
		$form->cf_commenter->template = 'k2_text';
		$form->cf_email->caption = '<small><strong>' . _t('Mail') . '</strong> ' . _t( '(will not be published)' ) .'</small><span class="required">' . ( Options::get('comments_require_id') == 1 ? ' *' . _t('Required') : '' ) . '</span>';
		$form->cf_email->template = 'k2_text';
		$form->cf_url->caption = '<small><strong>' . _t('Website') . '</strong></small>';
		$form->cf_url->template = 'k2_text';
	        $form->cf_content->caption = '';
		$form->cf_submit->caption = _t( 'Submit' );
	}
}

?>
