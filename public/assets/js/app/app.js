jQuery(document).foundation();

jQuery(document).ready(function () {
    var table = jQuery('.callout.table h4');

    table.append('<svg class="toggle" width="20" height="20"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#large-arrow"><svg viewBox="0 0 20 20" id="large-arrow" width="100%" height="100%"><path d="M13.25 10L6.109 2.58c-.268-.27-.268-.707 0-.979.268-.27.701-.27.969 0l7.83 7.908c.268.271.268.709 0 .979l-7.83 7.908c-.268.271-.701.27-.969 0-.268-.269-.268-.707 0-.979L13.25 10z"></path></svg></use></svg>');

    table.parents('div').addClass('is-open');

    jQuery(document).on('click', '.callout.table h4 svg.toggle', function () {
        if(jQuery(this).parent().parent().hasClass('is-open')) {
            jQuery(this).parent().parent().removeClass('is-open');

            jQuery(this).parent().siblings().slideUp();
        } else {
            jQuery(this).parent().parent().addClass('is-open');

            jQuery(this).parent().siblings().slideDown();
        }
    })
});

jQuery(document).ready(function () {
    jQuery('.search_at').on('keyup', function () {
        var content = jQuery(this).val();

        if(content.length < 3) {
            jQuery('.search_results').html('');
        } else {
            jQuery.get('/view/search?content=' + content, function (data) {
                jQuery('.search_results').html(data);
            })
        }
    });
});