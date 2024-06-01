jQuery(document).ready(function($) {

    // Single Post Delete 
    $( '.delete-post' ).on( 'click', function() {

        var self   = jQuery(this).parent().parent().parent().children()[0];
        var PostId = jQuery(self).attr( 'data-post-id' );
    
        let ajaxurl = wlt.ajax_url;
        
        let data = {
          'action'  : 'delete_post',
          'post_id' : PostId
        }
    
        jQuery.post( ajaxurl, data, function( responce ) {
            location.reload( true );
        });
    
    });

    // Multiple Post Delete 
    $( '.action' ).on( 'click', function() {

        let self = $(this);
        
        let postIDs = [];
        $.each( $( '.post-selected' ), function( index, elem ) {    
            
            if( $( elem ).prop( 'checked' ) ) {

              let postID = $( elem ).parents( 'tr' ).find( '.wlt_id a' ).attr( 'data-post-id' );
              
              postIDs.push( postID );
            }
        });

        // console.log(postIDs);
        let ajaxurl = wlt.ajax_url;
        let data = {
          'action'      : 'multiple_delete_post',
          'post_ids'     : postIDs
        }
  
        jQuery.post( ajaxurl, data, function( responce ) {
            location.reload( true );
        });
    });

    // Update Post Data
    $( '.own_edit' ).on( 'click', function() {

        var self        = jQuery(this).parent().parent().parent().children()[0];
        var PostId      = jQuery(self).attr( 'data-post-id' );
        var PostTitle   = jQuery(self).attr( 'data-post-title' );
        var PostContent = jQuery(self).attr( 'data-post-content' );
        var PostImage   = jQuery(self).attr( 'data-post-img' );
        var PostEmail   = jQuery(self).attr( 'data-post-email' );

        $( '.wlt_edit_post_title' ).val( PostTitle );
        $( '.wlt_edit_post_title' ).attr( 'post_id', PostId );
        $( '.wlt_edit_post_content' ).val( PostContent );
        $( '.wlt_edit_post_email' ).val( PostEmail );
        $( '.wlt_edit_post_featured_img' ).attr( 'src', PostImage );

        
        console.log(PostId, PostContent, PostTitle, PostImage);

        $( '.wlt-update-post' ).on( 'click', function() {

            let PostId      = $( '.wlt_edit_post_title' ).attr( 'post_id' );
            let PostContent = $( '.wlt_edit_post_content' ).val();
            let PostTitle   = $( '.wlt_edit_post_title' ).val();
            let PostEmail   = $( '.wlt_edit_post_email' ).val();
            let PostImage   = $( '.wlt_edit_post_featured_img' ).attr( 'src' );
            
            console.log(PostId, PostTitle, PostContent, PostImage);

            let ajaxurl = wlt.ajax_url;
            let data = {
                'action'      : 'wlt_edit_update_post',
                'post_id'     : PostId,
                'post_content': PostContent,
                'post_name'   : PostTitle,
                'post_image'  : PostImage,
                'post_email'  : PostEmail,
            }

            jQuery.post( ajaxurl, data, function( responce ) {
                location.reload( false );
            });
        });
    });

});