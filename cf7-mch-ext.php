<?php
/*
Plugin Name: Contact Form 7 MailChimp Extension
Plugin URI: http://renzojohnson.com/contributions/contact-form-7-mailchimp-extension
Description: Integrate Contact Form 7 with MailChimp. Automatically add form submissions to predetermined lists in MailChimp, using its latest API.
Author: Renzo Johnson
Author URI: http://renzojohnson.com
Text Domain: contact-form-7
Domain Path: /languages/
Version: 0.1.17
*/

/*  Copyright 2013-2014 Renzo Johnson (email: renzojohnson at gmail.com)

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

require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'lib/functions.php');
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'lib/enqueue.php');

