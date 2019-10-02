<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <form action="<?php echo esc_html(admin_url('admin-post.php')); ?>" method="post">
        <input type="hidden" name="action" value="update">
        <h2><?php echo __('General Settings', APS_Content_Moderator::PLUGIN_NAME)?></h2>
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label for="Rapid-API Key">Rapid-API Key</label></th>
                    <td>
                        <input class="regular-text" type="text" name="aps-content-moderator-cm-settings-data_access_key"
                            value="<?php echo esc_html(get_option('aps-content-moderator-cm-settings-data_access_key')); ?>"/>
                        <p class="description" id="aipwrd_access_url-description">
                            Visit the <a href="https://rapidapi.com/dev.nico/api/ai-powered-content-moderator/pricing"
                                        target="_blank">API-Site</a> for a key.
                        </p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="Rapid-API Url">Rapid-API Url</label></th>
                    <td>
                        <input class="regular-text" type="text" name="aps-content-moderator-cm-settings-data_access_url"
                            value="<?php echo esc_html(get_option('aps-content-moderator-cm-settings-data_access_url')); ?>"/>
                        <p class="description" id="aipwrd_access_url-description">
                        
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
        <h2><?php echo __('Fine Tuning', APS_Content_Moderator::PLUGIN_NAME)?></h2>
        <table class="form-table">
            <tbody>
                <tr>
                <th scope="row"><label for=""><?php echo __('Classification Score', APS_Content_Moderator::PLUGIN_NAME)?></label></th>
                <td>
                    <p>
                        <?php echo __('Score is between 0 and 1. The higher the score, the higher the model is predicting that the category may be applicable. This feature relies on a statistical model rather than manually coded outcomes. We recommend testing with your own content to determine how each category aligns to your requirements.', APS_Content_Moderator::PLUGIN_NAME)?>
                    </p>
                </td>
                </tr>
                <tr>
                    <th scope="row"><label for=""><?php echo __('Category 1', APS_Content_Moderator::PLUGIN_NAME)?></label></th>
                    <td>
                        <div id="aps-content-moderator__category1-slider">
                            <div id="aps-content-moderator__category1-slider-handle" class="ui-slider-handle"></div>
                            <?php $categoryValue = get_option('aps-content-moderator-cm-settings_category1-value') ? esc_html(get_option('aps-content-moderator-cm-settings_category1-value')) : 0.00;?>
                            <input type="hidden" name="aps-content-moderator-cm-settings_category1-value" id="aps-content-moderator__category1-input" value="<?php echo $categoryValue?>"/>
                        </div>
                        <p class="description" id="aipwrd_comment_length-description">
                            <?php echo __('Category1 refers to potential presence of language that may be considered sexually explicit or adult in certain situations', APS_Content_Moderator::PLUGIN_NAME)?>
                        </p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="Category 2"><?php echo __('Category 2', APS_Content_Moderator::PLUGIN_NAME)?></label></th>
                    <td>
                        <div id="aps-content-moderator__category2-slider">
                            <div id="aps-content-moderator__category2-slider-handle" class="ui-slider-handle"></div>
                            <?php $categoryValue2 = get_option('aps-content-moderator-cm-settings_category2-value') ? esc_html(get_option('aps-content-moderator-cm-settings_category2-value')) : 0.00;?>
                            <input type="hidden" name="aps-content-moderator-cm-settings_category2-value" id="aps-content-moderator__category2-input" value="<?php echo $categoryValue2;?>"/>
                        </div>
                        <p class="description" id="aipwrd_comment_length-description">
                            <?php echo __('Category2 refers to potential presence of language that may be considered sexually suggestive or mature in certain situations.', APS_Content_Moderator::PLUGIN_NAME)?>
                        </p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="Category 3"><?php echo __('Category 3', APS_Content_Moderator::PLUGIN_NAME)?></label></th>
                    <td>
                        <div id="aps-content-moderator__category3-slider">
                            <div id="aps-content-moderator__category3-slider-handle" class="ui-slider-handle"></div>
                            <?php $categoryValue3 = get_option('aps-content-moderator-cm-settings_category3-value') ? esc_html(get_option('aps-content-moderator-cm-settings_category3-value')) : 0.00;?>
                            <input type="hidden" name="aps-content-moderator-cm-settings_category3-value" id="aps-content-moderator__category3-input" value="<?php echo $categoryValue3?>"/>
                        </div>
                        <p class="description" id="aipwrd_comment_length-description">
                            <?php echo __('Category3 refers to potential presence of language that may be considered offensive in certain situations.', APS_Content_Moderator::PLUGIN_NAME)?>
                        </p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label><?php echo __('Ignore personal data', APS_Content_Moderator::PLUGIN_NAME)?></label></th>
                    <td>
                        <div id="aps-content-moderator__pii">
                            <?php $ignorePii = get_option('aps-content-moderator-cm-settings_ignore-pii', false) ? true : false;?>
                            <input type="checkbox" name="aps-content-moderator-cm-settings_ignore-pii" id="aps-content-moderator__ignore-pii" <?php echo $ignorePii ? 'checked="checked"' : ''?>/>
                        </div>
                        <p class="description" id="aipwrd_comment_length-description">
                            <?php echo __('Ignore personal data when checking and only consider the classification.', APS_Content_Moderator::PLUGIN_NAME)?>
                        </p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label><?php echo __('Enabled Comment Max-Length', APS_Content_Moderator::PLUGIN_NAME)?></label></th>
                    <td>
                        <div id="aps-content-moderator__comment-threshold">
                            <?php $commentThreshold = get_option('aps-content-moderator-cm-settings_comment-threshold', 0) ? true : false;?>
                            <input type="checkbox" name="aps-content-moderator-cm-settings_comment-threshold" id="aps-content-moderator__comment-threshold" <?php echo $commentThreshold ? 'checked="checked"' : ''?>/>
                        </div>
                        <p class="description" id="aipwrd_comment-threshold">
                            <?php echo __('The APS Content Moderator API can handle a maximum of 1024 characters per request. The comment field will be interactively checked for a maximum length of 1024 characters. If you deactivate the limitation, only the first 1024 characters of the comment are checked.', APS_Content_Moderator::PLUGIN_NAME)?>
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
        <script>
            jQuery( function() {
                var sliderHandleCat1 = jQuery( "#aps-content-moderator__category1-slider-handle" );
                var sliderInputCat1 = jQuery( "#aps-content-moderator__category1-input" );
                jQuery( "#aps-content-moderator__category1-slider" ).slider({
                    value: <?php echo $categoryValue; ?>,
                    step: 0.01,
                    min: 0,
                    max: 1,
                    create: function() {
                      sliderHandleCat1.text( jQuery( this ).slider( 'value' ) );
                    },
                    slide: function( event, ui ) {
                      sliderHandleCat1.text( ui.value );
                      sliderInputCat1.attr('value', ui.value);
                    }
                });
                var sliderHandleCat2 = jQuery( "#aps-content-moderator__category2-slider-handle" );
                var sliderInputCat2 = jQuery( "#aps-content-moderator__category2-input" );
                jQuery( "#aps-content-moderator__category2-slider" ).slider({
                    value: <?php echo $categoryValue2; ?>,
                    step: 0.01,
                    min: 0,
                    max: 1,
                    create: function() {
                      sliderHandleCat2.text( jQuery( this ).slider( 'value' ) );
                    },
                    slide: function( event, ui ) {
                      sliderHandleCat2.text( ui.value );
                      sliderInputCat2.attr('value', ui.value);
                    }
                });
                var sliderHandleCat3 = jQuery( "#aps-content-moderator__category3-slider-handle" );
                var sliderInputCat3 = jQuery( "#aps-content-moderator__category3-input" );
                jQuery( "#aps-content-moderator__category3-slider" ).slider({
                    value: <?php echo $categoryValue3; ?>,
                    step: 0.01,
                    min: 0,
                    max: 1,
                    create: function() {
                      sliderHandleCat3.text( jQuery( this ).slider( 'value' ) );
                    },
                    slide: function( event, ui ) {
                      sliderHandleCat3.text( ui.value );
                      sliderInputCat3.attr('value', ui.value);
                    }
                });
            });
        </script>
        <?php
            wp_nonce_field('aipwrd-settings-save', 'aipwrd-settings-save_nonce');
            submit_button();
        ?>
    </form>
</div>
