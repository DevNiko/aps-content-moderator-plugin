
(function( $ ) {
  'use strict';

    $.aipwrd_sanitize = function(input) {
        var regex = /(<[^>]+>|<[^>]>|<\/[^>]>)/g;
        return input.replace(regex , '');
    };
    $.aipwrd_setCommentValidation = function() {
        $('#commentform').validate({
        lang: aps_config.site_lang,
        rules: {
            comment: {
            normalizer: function(value) {
                return $.trim(value);
            },
            rangelength: [3, 1024],
            },
        },
        });
    };
    $.aipwrd_displayCommentChars = function(elm) {
        $(elm).after('<br/><label class="info" id="comment-chars-text">'+aps_config.comment_counter_text+'</label>');
        $(elm).on('input', function(event) {
            $.aipwrd_countAndUpdateCommentChars($(this));
        });
    };
    $.aipwrd_countAndUpdateCommentChars = function(elm) {
        var aipwrd_len = $.aipwrd_sanitize($(elm).val()).length;
        var aipwrd_maxlength = 1024;
        var aipwrd_remainLength = aipwrd_maxlength - aipwrd_len;
        $('#comment-chars-text').html(aipwrd_remainLength + ' of a maximum of 1024 characters left');
    };
	 $(function() {
        if ('1' === aps_config.js_validation_enabled) {
            // check, if validation plugin is already available for this site
            if ($.fn.validate) {
                $.aipwrd_setCommentValidation();
            } else {
            $.getScript(aps_config.base_url+'/wp-content/plugins/aps-content-moderator/public/js/lib/jquery-1.12/jquery.validate.min.js',
                function(data, textStatus, jqxhr) {
                if (jqxhr.status != 200) {
                    return;
                }
                $.aipwrd_setCommentValidation();
            });
        }

        var commentFieldId = aps_config.comment_input_field_id;
        if ($(commentFieldId).length > 0 && aps_config.display_comment_counter_text === '1') {
            $.aipwrd_displayCommentChars($(commentFieldId));
            $.aipwrd_countAndUpdateCommentChars($(commentFieldId));
        }
    }
   });
})( jQuery );
