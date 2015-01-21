<?php

define( 'WPCF7_SPARTAN_VERSION', '0.1.6' );

if ( ! defined( 'WPCF7_SPARTAN_PLUGIN_BASENAME' ) )
	define( 'WPCF7_SPARTAN_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );


function wpcf7_cm_save_campaignmonitor($args) {
	update_option( 'cf7_cm_'.$args->id, $_POST['wpcf7-campaignmonitor'] );
}
add_action( 'wpcf7_after_save', 'wpcf7_cm_save_campaignmonitor' );


function add_cm_meta () {
	if ( wpcf7_admin_has_edit_cap() ) {
		add_meta_box( 'cf7cmdiv', __( 'Campaign Monitor: Subscriber List Details <a href="http://renzojohnson.com/contributions/contact-form-7-campaign-monitor-extension" class="helping-hand" target="_blank">Need Help?</a>', 'wpcf7' ),
			'wpcf7_cm_add_campaignmonitor', 'cfseven', 'cf7_cm', 'core',
			array(
				'id' => 'wpcf7-cf7',
				'name' => 'cf7_cm',
				'use' => __( 'Use Campaign Monitor', 'wpcf7' ) ) );
	}
}
add_action( 'wpcf7_add_meta_boxes', 'add_cm_meta' );


function show_cm_metabox($cf) {
	do_meta_boxes( 'cfseven', 'cf7_cm', $cf );
}
add_action( 'wpcf7_admin_after_mail_2', 'show_cm_metabox' );


function wpcf7_cm_add_campaignmonitor($args) {
	$cf7_cm_defaults = array();
	$cf7_cm = get_option( 'cf7_cm_'.$args->id, $cf7_cm_defaults );
?>

<div class="mail-fields">
	<div class="half-left">
		<div class="mail-field">
			<label for="wpcf7-campaignmonitor-email"><?php echo esc_html( __( 'Subscriber Email:', 'wpcf7' ) ); ?></label><br />
			<input type="text" id="wpcf7-campaignmonitor-email" name="wpcf7-campaignmonitor[email]" class="wide" size="70" value="<?php echo esc_attr( $cf7_cm['email'] ); ?>" />
		</div>

		<div class="mail-field">
		<label for="wpcf7-campaignmonitor-name"><?php echo esc_html( __( 'Subscriber Name:', 'wpcf7' ) ); ?></label><br />
		<input type="text" id="wpcf7-campaignmonitor-name" name="wpcf7-campaignmonitor[name]" class="wide" size="70" value="<?php echo esc_attr( $cf7_cm['name'] ); ?>" />
		</div>

		<div class="mail-field"><br/>
		<input type="checkbox" id="wpcf7-campaignmonitor-cf-active" name="wpcf7-campaignmonitor[cfactive]" value="1"<?php echo ( $cf7_cm['cfactive'] ) ? ' checked="checked"' : ''; ?> />
		<label for="wpcf7-campaignmonitor-cfactive"><?php echo esc_html( __( 'Use Custom Fields', 'wpcf7' ) ); ?></label><br/><br/>
		</div>
	</div>

	<div class="half-right">
		<div class="mail-field">
		<label for="wpcf7-campaignmonitor-api"><?php echo esc_html( __( 'API Key:', 'wpcf7' ) ); ?></label><br />
		<input type="text" id="wpcf7-campaignmonitor-api" name="wpcf7-campaignmonitor[api]" class="wide" size="70" value="<?php echo esc_attr( $cf7_cm['api'] ); ?>" />
		</div>

		<div class="mail-field">
		<label for="wpcf7-campaignmonitor-list"><?php echo esc_html( __( 'List ID:', 'wpcf7' ) ); ?></label><br />
		<input type="text" id="wpcf7-campaignmonitor-list" name="wpcf7-campaignmonitor[list]" class="wide" size="70" value="<?php echo esc_attr( $cf7_cm['list'] ); ?>" />
		</div>

		<div class="mail-field"><br/>
		<input type="checkbox" id="wpcf7-campaignmonitor-resubscribeoption" name="wpcf7-campaignmonitor[resubscribeoption]" value="1"<?php echo ( $cf7_cm['resubscribeoption'] ) ? ' checked="checked"' : ''; ?> />
		<label for="wpcf7-campaignmonitor-resubscribeoption"><?php echo esc_html( __( 'Allow Users to Resubscribe after being Deleted or Unsubscribed? (checked = true)', 'wpcf7' ) ); ?></label><br/><br/>
		</div>
	</div>

	<br class="clear" />

	<div class="campaignmonitor-custom-fields">
		<?php for($i=1;$i<=4;$i++){ ?>
			<div class="half-left">
				<div class="mail-field">
				<label for="wpcf7-campaignmonitor-CustomKey<?php echo $i; ?>"><?php echo esc_html( __( 'Custom Field Name '.$i.':', 'wpcf7' ) ); ?></label><br />
				<input type="text" id="wpcf7-campaignmonitor-CustomKey<?php echo $i; ?>" name="wpcf7-campaignmonitor[CustomKey<?php echo $i; ?>]" class="wide" size="70" value="<?php echo esc_attr( $cf7_cm['CustomKey'.$i] ); ?>" />
				</div>
			</div>
			<div class="half-right">
				<div class="mail-field">
				<label for="wpcf7-campaignmonitor-CustomValue<?php echo $i; ?>"><?php echo esc_html( __( 'Form Value '.$i.':', 'wpcf7' ) ); ?></label><br />
				<input type="text" id="wpcf7-campaignmonitor-CustomValue<?php echo $i; ?>" name="wpcf7-campaignmonitor[CustomValue<?php echo $i; ?>]" class="wide" size="70" value="<?php echo esc_attr( $cf7_cm['CustomValue'.$i] ); ?>" />
				</div>
			</div>
			<br class="clear" />
		<?php } ?>

	</div>
</div>

<?php

}


add_action( 'wpcf7_before_send_mail', 'wpcf7_cm_subscribe' );

function wpcf7_cm_subscribe($obj)
{
	$cf7_cm = get_option( 'cf7_cm_'.$obj->id() );
	$submission = WPCF7_Submission::get_instance();

	if( $cf7_cm )
	{
		$subscribe = false;

		$regex = '/\[\s*([a-zA-Z_][0-9a-zA-Z:._-]*)\s*\]/';
		$callback = array( &$obj, 'cf7_cm_callback' );

		$email = cf7_cm_tag_replace( $regex, $cf7_cm['email'], $submission->get_posted_data() );
		$name = cf7_cm_tag_replace( $regex, $cf7_cm['name'], $submission->get_posted_data() );

		$lists = cf7_cm_tag_replace( $regex, $cf7_cm['list'], $submission->get_posted_data() );
		$listarr = explode(',',$lists);

		if( isset($cf7_cm['accept']) && strlen($cf7_cm['accept']) != 0 )
		{
			$accept = cf7_cm_tag_replace( $regex, $cf7_cm['accept'], $submission->get_posted_data() );
			if($accept != $cf7_cm['accept'])
			{
				if(strlen($accept) > 0)
					$subscribe = true;
			}
		}
		else
		{
			$subscribe = true;
		}

		for($i=1;$i<=20;$i++){

			if( isset($cf7_cm['CustomKey'.$i]) && isset($cf7_cm['CustomValue'.$i]) && strlen(trim($cf7_cm['CustomValue'.$i])) != 0 )
			{
				$CustomFields[] = array('Key'=>trim($cf7_cm['CustomKey'.$i]), 'Value'=>cf7_cm_tag_replace( $regex, trim($cf7_cm['CustomValue'.$i]), $submission->get_posted_data() ) );
			}

		}

		if( isset($cf7_cm['resubscribeoption']) && strlen($cf7_cm['resubscribeoption']) != 0 )
		{
			$ResubscribeOption = true;
		}
			else
		{
			$ResubscribeOption = false;
		}

		if($subscribe && $email != $cf7_cm['email'])
		{

			require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'../api/csrest_subscribers.php');

			$wrap = new SPARTAN_CS_REST_Subscribers( trim($listarr[0]), $cf7_cm['api'] );
			foreach($listarr as $listid)
			{
				$wrap->set_list_id(trim($listid));
				$wrap->add(array(
					'EmailAddress' => $email,
					'Name' => $name,
					'CustomFields' => $CustomFields,
					'Resubscribe' => $ResubscribeOption
				));
			}

		}

	}
}

function cf7_cm_tag_replace( $pattern, $subject, $posted_data, $html = false ) {
	if( preg_match($pattern,$subject,$matches) > 0)
	{

		if ( isset( $posted_data[$matches[1]] ) ) {
			$submitted = $posted_data[$matches[1]];

			if ( is_array( $submitted ) )
				$replaced = join( ', ', $submitted );
			else
				$replaced = $submitted;

			if ( $html ) {
				$replaced = strip_tags( $replaced );
				$replaced = wptexturize( $replaced );
			}

			$replaced = apply_filters( 'wpcf7_mail_tag_replaced', $replaced, $submitted );

			return stripslashes( $replaced );
		}

		if ( $special = apply_filters( 'wpcf7_special_mail_tags', '', $matches[1] ) )
			return $special;

		return $matches[0];
	}
	return $subject;
}

function wpcf7_spartan_plugin_url( $path = '' ) {
	return plugins_url( $path, WPCF7_SPARTAN_PLUGIN_BASENAME );
}