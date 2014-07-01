<!-- NOTE: If you need to make changes to this file, copy it to your current theme's main
	directory so your changes won't be overwritten when the plugin is upgraded. -->

<!-- Start of Post Wrap -->
<div class="post hentry ivycat-post">
	<div class="span2">
		<a href="<?php the_permalink(); ?>">
			<img src="<?php
$attachments = get_children( array('post_parent' => get_the_ID(), 'post_type' => 'attachment', 'post_mime_type' =>'image') );
foreach ( $attachments as $attachment_id => $attachment ) {
	echo wp_get_attachment_url( $attachment_id, 'medium' );
} ?>" />
		</a>
	</div>
	
	<div class="span9">

		<!-- This is the output of the post TITLE -->
		<h2 class="entry-title">
			<?php the_title(); ?>
		</h2>

		<!-- This is the output of the EXCERPT -->
		<?php /*
		
		<div class="entry-summary">
			<?php the_excerpt(); 
			?>
		</div>
		*/ ?>
		
		<!-- This is the output of the META information -->
		<div class="entry-utility">
			<?php if ( count( get_the_category() ) ) : ?>
				<span class="cat-links">
					<?php printf( __( '<span class="%1$s">Публикувано в</span> %2$s', 'twentyten' ), 'entry-utility-prep entry-utility-prep-cat-links', get_the_category_list( ', ' ) ); ?>
				</span>
				<span class="meta-sep">|</span>
			<?php endif; ?>
			<?php
				$tags_list = get_the_tag_list( '', ', ' );
				if ( $tags_list ):
			?>
				<span class="tag-links">
					<?php printf( __( '<span class="%1$s">Tagged</span> %2$s', 'twentyten' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list ); ?>
				</span>
				<span class="meta-sep">|</span>
			<?php endif; ?>
			<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'twentyten' ), __( '1 Comment', 'twentyten' ), __( '% Comments', 'twentyten' ) ); ?></span>
			<?php edit_post_link( __( 'Edit', 'twentyten' ), '<span class="meta-sep">|</span> <span class="edit-link">', '</span>' ); ?>
		</div>
	</div>
</div>
<!-- // End of Post Wrap -->
