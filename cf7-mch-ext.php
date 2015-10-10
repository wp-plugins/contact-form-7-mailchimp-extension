<?php
/*
Plugin Name: Contact Form 7 MailChimp Extension
Plugin URI: http://renzojohnson.com/contributions/contact-form-7-mailchimp-extension
Description: Integrate Contact Form 7 with MailChimp. Automatically add form submissions to predetermined lists in MailChimp, using its latest API.
Author: Renzo Johnson
Author URI: http://renzojohnson.com
Text Domain: contact-form-7
Domain Path: /languages/
Version: 0.4.16
*/

/*  Copyright 2013-2015 Renzo Johnson (email: renzojohnson at gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

define( 'SPARTAN_MCE_VERSION', '0.4.16' );
define( 'SPARTAN_MCE_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'SPARTAN_MCE_PLUGIN_NAME', trim( dirname( SPARTAN_MCE_PLUGIN_BASENAME ), '/' ) );
define( 'SPARTAN_MCE_PLUGIN_DIR', untrailingslashit( dirname( __FILE__ ) ) );
define( 'SPARTAN_MCE_PLUGIN_URL', untrailingslashit( plugins_url( '', __FILE__ ) ) );
define( 'SPARTAN_MCE_PLUGIN_MODULES_DIR', SPARTAN_MCE_PLUGIN_DIR . '/modules' );

require_once( SPARTAN_MCE_PLUGIN_DIR . '/lib/mailchimp.php' );

function mce_error() {

  if( !file_exists(WP_PLUGIN_DIR.'/contact-form-7/wp-contact-form-7.php') ) {

    $mce_error_out = '<div class="error" id="messages"><p>';
    $mce_error_out .= __('The Contact Form 7 plugin must be installed for the <b>MailChimp Extension</b> to work. <b><a href="'.admin_url('plugin-install.php?tab=plugin-information&plugin=contact-form-7&from=plugins&TB_iframe=true&width=600&height=550').'" class="thickbox" title="Contact Form 7">Install Contact Form 7  Now.</a></b>', 'mce_error');
    $mce_error_out .= '</p></div>';

  } else if ( !class_exists( 'WPCF7') ) {

    $mce_error_out = '<div class="error" id="messages"><p>';
    $mce_error_out .= __('The Contact Form 7 is installed, but <strong>you must activate Contact Form 7</strong> below for the <b>MailChimp Extension</b> to work.','mce_error');
    $mce_error_out .= '</p></div>';

  }

  echo $mce_error_out;

}
add_action('admin_notices', 'mce_error');