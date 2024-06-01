let currentPage = 1;

jQuery('#load_more_button').on('click', function () {
    currentPage++;

    jQuery.ajax({
        url: load_ajax_url.ajaxurl,
        type: 'POST',
        dataType: 'html',
        data: {
            paged: currentPage,
            action: 'load_more_action',
            'nonce': ajax_form.ajax_nonce,
        },
        success: function(data) {
            jQuery('#load_more').append(data);
        }
    })
});
