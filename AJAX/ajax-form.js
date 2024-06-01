jQuery('#create_post_form').submit(function(e){
    e.preventDefault();
    
    var title = jQuery('#title').val();
    var details = jQuery('#post_content').val();

    jQuery.ajax({
        url: ajax_form.ajaxurl,
        type: 'POST',
        data:{
            'title': title,
            'post_content': details,
            'nonce': ajax_form.ajax_nonce,
            'action': 'send_post_data'
        },
        success: function(data) {
            alert('Post Added Success.');
            jQuery('#title').val('');
            jQuery('#post_content').val('');
        },
    });
});