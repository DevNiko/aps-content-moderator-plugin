<?php

/**
 * Creates the submenu page for the plugin.
 *
 * Provides the functionality necessary for rendering the page corresponding
 * to the submenu with which this page is associated.
 *
 * @package APS_Content_Moderator_Admin
 */
if (!class_exists('APS_Content_Moderator_Admin_Settings_Page')) {
    class APS_Content_Moderator_Admin_Settings_Page
    {

        /**
         * This function renders the contents of the page associated with the Submenu
         * that invokes the render method. In the context of this plugin, this is the
         * Submenu class.
         */
        public function render()
        {
            include_once('views/aps-content-moderator-cm-settings.php');
        }
    }
}