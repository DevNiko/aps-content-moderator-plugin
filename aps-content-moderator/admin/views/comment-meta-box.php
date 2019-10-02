<?php
/**
 * This is the template of the comment meta box class.
 * @see APS_Content_Moderator_Admin_Partials_CommentMetaBox
 */
?>
<script>
  jQuery( function($) {
    $( "#aps-content-moderator__comment-meta-box__accordion" ).accordion();
  });
</script>
<div style="padding:10px">
  <?php if (isset($post_meta['classification']['review_recommended'])
    && $post_meta['classification']['review_recommended'] == true):?>
    <h2 class="aps-content-moderator__comment-meta-box__review-recommended">
      <strong><?php echo __('Review Recommended', APS_Content_Moderator::PLUGIN_NAME)?></strong>
    </h2>
  <?php endif;?>
  <p id="js-aps-content-moderator__original-text" class="aps-content-moderator__comment-meta-box__original-text">
    <?php echo $post_meta['original_text']?>
  </p>
</div>
<div id="aps-content-moderator__comment-meta-box__accordion">
  <h3><?php echo __('Translation', APS_Content_Moderator::PLUGIN_NAME)?></h3>
  <div>
    <p>
      <?php if (isset($post_meta['indetified_language'])
        && strlen($post_meta['indetified_language']) > 0):?>
        <h2 class="aps-content-moderator__comment-meta-box__indetified-language">
          <?php echo __('Indetified Lang', APS_Content_Moderator::PLUGIN_NAME)?>: <?php echo $post_meta['indetified_language']?>
        </h2>
      <?php endif;?>
      <?php echo $post_meta['translated_text']?></p>
  </div>
  <h3><?php echo __('Auto corrected text', APS_Content_Moderator::PLUGIN_NAME)?></h3>
  <div>
    <p><?php echo $post_meta['auto_corrected_text']?></p>
  </div>
  <h3><?php echo __('Classification', APS_Content_Moderator::PLUGIN_NAME)?></h3>
  <div>
    <p>
      <?php echo __('Score is between 0 and 1. The higher the score, the higher the model is predicting that the category may be applicable. This feature relies on a statistical model rather than manually coded outcomes. We recommend testing with your own content to determine how each category aligns to your requirements.', APS_Content_Moderator::PLUGIN_NAME)?>
    </p>
    <?php if (isset($post_meta['classification']) && is_array($post_meta['classification'])):?>
      <ul>
      <?php foreach($post_meta['classification'] as $categoryKey => $score):?>
        <li>
          <?php if ($categoryKey != 'review_recommended' && isset($score['score'])): ?>
          <strong>Score <?php echo ucfirst($categoryKey);?>: <?php echo round($score['score'], 2);?></strong>
          <?php if ($categoryKey === 'category1'): ?>
            <br/><span><?php echo __('Category1 refers to potential presence of language that may be considered sexually explicit or adult in certain situations', APS_Content_Moderator::PLUGIN_NAME)?></span>
          <?endif;?>
          <?php if ($categoryKey === 'category2'): ?>
            <br/><span><?php echo __('Category2 refers to potential presence of language that may be considered sexually suggestive or mature in certain situations.', APS_Content_Moderator::PLUGIN_NAME)?></span>
          <?endif;?>
          <?php if ($categoryKey === 'category3'): ?>
            <br/><span><?php echo __('Category3 refers to potential presence of language that may be considered offensive in certain situations.', APS_Content_Moderator::PLUGIN_NAME)?></span>
          <?endif;?>
          <?php endif;?>
        </li>
      <?php endforeach;?>
      </ul>
    <?php endif;?>
  </div>
  <h3><?php echo __('Profanity', APS_Content_Moderator::PLUGIN_NAME)?></h3>
  <div>
    <p>
        <strong><?php echo __('Terms', APS_Content_Moderator::PLUGIN_NAME)?></strong>
    </p>
    <?php if (isset($post_meta['profanity']) && is_array($post_meta['profanity'])):?>
      <ul>
        <?php foreach($post_meta['profanity'] as $profanityItem):?>
          <li><?php echo $profanityItem['term'];?> (at pos. <?php echo $profanityItem['original_index'];?>)</li>
        <?php endforeach;?>
      </ul>
    <?php endif;?>
  </div>
  <h3><?php echo __('Personal Information', APS_Content_Moderator::PLUGIN_NAME)?></h3>
  <div>
    <p>
    </p>
    <?php if (isset($post_meta['personal_information']) && is_array($post_meta['personal_information'])):?>
        <?php foreach($post_meta['personal_information'] as $piiType => $piiData):?>
          <h3><?php echo ucfirst($piiType);?></h3>
          <?php if (is_array($piiData) && count($piiData) > 0):?>
            <ul>
              <?php foreach($piiData as $piiDataKey => $piiDataValue):?>
                <?php if ($piiType == 'address' && is_array($piiDataValue)):?>
                    <li><?php echo $piiDataValue['text'];?> (at pos. <?php echo $piiDataValue['index'];?>)</li>
                <?php endif;?>
                <?php if ($piiType == 'email'):?>
                  <li><?php echo $piiDataValue['detected'];?> (at pos. <?php echo $piiDataValue['index'];?>)</li>
                <?php endif;?>
                <?php if ($piiType == 'phone'):?>
                  <li><?php echo $piiDataValue['country_code'];?> <?php echo $piiDataValue['text'];?> (at pos. <?php echo $piiDataValue['index'];?>)</li>
                <?php endif;?>
                <?php if ($piiType == 'ipa'):?>
                  <li><?php echo $piiDataValue['sub_type'];?> <?php echo $piiDataValue['text'];?> (at pos. <?php echo $piiDataValue['index'];?>)</li>
                <?php endif;?>
                <?php if ($piiType == 'ssn'):?>
                  <li><?php echo $piiDataValue['text'];?> (at pos. <?php echo $piiDataValue['index'];?>)</li>
                <?php endif;?>
              <?php endforeach;?>
            </ul>
          <?php endif;?>
        <?php endforeach;?>
    <?php endif;?>
  </div>
</div>
