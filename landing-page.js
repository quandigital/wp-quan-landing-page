jQuery(document).ready(function($) {
    $('#contact').on('submit', function(e) {
        e.preventDefault();

        $('#send').attr('disabled', 'disabled').parent().append($('<div>').addClass('spinner'));

        var data = {
            'action': 'submitLp',
            'name': $('[name="name"]').val(),  
            'phone': $('[name="phone"]').val(),  
            'email': $('[name="email"]').val(),  
            'company': $('[name="company"]').val(),  
            'website': $('[name="website"]').val(),
            'security': $('[name="_wpnonce"]').val(),
            'referer': $('[name="referer"]').val(),
            'url': $('#contact').data('page')  
        }

       $.post(ajaxurl, data, function(response) {
            console.log(response);
            if (response && response > 0) {
                // _gaq.push(['_trackEvent', 'lp-form-success', 'submit-contact', data.url]);
                $('.spinner').remove();
                $('#send').text(thankYou).addClass('sent');
            }
       });
    });
});
