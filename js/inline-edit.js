/*
 * This script populates the radio button with the checked category
 * on the Quick Edit form in edit.php
 * https://codex.wordpress.org/Plugin_API/Action_Reference/quick_edit_custom_box
 */

(function($) {

	// we create a copy of the WP inline edit post function
	var $wp_inline_edit = inlineEditPost.edit;

	// and then we overwrite the function with our own code
	inlineEditPost.edit = function( id ) {

		// "call" the original WP edit function
		// we don't want to leave WordPress hanging
		$wp_inline_edit.apply( this, arguments );

		// now we take care of our business

		// get the post ID
		var $post_id = 0;
		if ( typeof( id ) == 'object' ) {
			$post_id = parseInt( this.getId( id ) );
		}

		if ( $post_id > 0 ) {
			// define the edit row
			var $edit_row = $( '#edit-' + $post_id );
			var $post_row = $( '#post-' + $post_id );

			// hierarchical taxonomies
			$('.post_category', $post_row).each(function(){
				var taxname,
					term_ids = $(this).text();

				if ( term_ids ) {
					taxname = $(this).attr('id').replace('_'+id, '');
					$('ul.cat-checklist :radio', $edit_row).val(term_ids.split(','));
				}
			});

		}

	};

})(jQuery);
