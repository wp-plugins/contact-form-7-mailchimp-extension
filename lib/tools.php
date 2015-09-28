<?php
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



function mce_author($mce_author) {

	$author_pre = 'Contact form 7 Mailchimp extension by ';
	$author_name = 'Renzo Johnson';
	$author_url = 'http://renzojohnson.com';
	$author_title = 'Renzo Johnson - Web Developer';

	$mce_author .= '<p style="display: none !important">';
  $mce_author .= $author_pre;
  $mce_author .= '<a href="'.$author_url.'" ';
  $mce_author .= 'title="'.$author_title.'" ';
  $mce_author .= 'target="_blank">';
  $mce_author .= ''.$author_title.'';
  $mce_author .= '</a>';
  $mce_author .= '</p>'. "\n";

  return $mce_author;
}



function mce_referer($mce_referer) {

	$mce_referer_url = $_SERVER['HTTP_REFERER'];

	$mce_referer .= '<p style="display: none !important"><span class="wpcf7-form-control-wrap referer-page">';
  $mce_referer .= '<input type="text" name="referer-page" ';
  $mce_referer .= 'value="'.$mce_referer_url.'" ';
  $mce_referer .= 'size="40" class="wpcf7-form-control wpcf7-text referer-page" aria-invalid="false">';
  $mce_referer .= '</span></p>'. "\n";

  return $mce_referer;
}



function mce_getRefererPage( $form_tag )
{
        if ( $form_tag['name'] == 'referer-page' ) {
                $form_tag['values'][] = $_SERVER['HTTP_REFERER'];
        }
        return $form_tag;
}

if ( !is_admin() ) {
        add_filter( 'wpcf7_form_tag', 'mce_getRefererPage' );
}