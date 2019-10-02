(function( $ ) {
  'use strict';

  $(function() {
    // highlight profanity
    var profanityTermsRanges = [];
    if (aps_comment_meta_data.profanity
        && aps_comment_meta_data.profanity !== 'None'
        && aps_comment_meta_data.profanity.length > 0) {
      $.each( aps_comment_meta_data.profanity, function( index, value ){
        profanityTermsRanges.push({start:(value.original_index+5), length: value.term.length})
      });
    }
    $("#js-aps-content-moderator__original-text").markRanges(
    profanityTermsRanges,
    {'className': 'aps-content-moderator__comment-meta-box__mark-profanity'});

    // highlight pii
    var piiTermsRanges = [];
    const piiEmailData = aps_comment_meta_data.personal_information.email;
    if (piiEmailData && piiEmailData.length > 0) {
      $.each( piiEmailData, function( index, value ) {
        piiTermsRanges.push({start:(value.index+5), length: value.text.length})
      });
    }
    const piiPhoneData = aps_comment_meta_data.personal_information.phone;
    if (piiPhoneData && piiPhoneData.length > 0) {
      $.each( piiPhoneData, function( index, value ) {
        piiTermsRanges.push({start:(value.index+5), length: value.text.length})
      });
    }
    const piiIpaData = aps_comment_meta_data.personal_information.ipa;
    if (piiIpaData && piiIpaData.length > 0) {
      $.each( piiIpaData, function( index, value ) {
        piiTermsRanges.push({start:(value.index+5), length: value.text.length})
      });
    }
    $("#js-aps-content-moderator__original-text").markRanges(
      piiTermsRanges,
      {'className': 'aps-content-moderator__comment-meta-box__mark-pii'});
  });

})( jQuery );