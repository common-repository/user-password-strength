<?php

/*
 * Plugin Name: User Password Strength
 * Description: Enforce a specific individual password strength. Set password length, number of symbols, numbers and lower/upper characters for your minimum user-passwords specification
 * Version: 1.0
 * Plugin URI: http://wordpress.org/extend/plugins/user-password-strength/
 * Author: Steve Günther
 * Author URI: http://seitenhype.com/
 */

class Password_Strength
{
	const strOptionKey      = 'seitenhypePasswordStrength';
	const intPasswordLength = 6;
	const intNumbers        = 0;
	const intLowerChar      = 1;
	const intUpperChar      = 1;
	const intSymbols        = 0;

	// #########################################################################################
	// # INIT
	// #########################################################################################
	public static function init()
	{
		// # MENU
		add_action('admin_menu', array( __CLASS__, 'addMenu'));

		// # PLUGIN SETTING LINK
		add_action('plugin_action_links_'.plugin_basename( __FILE__ ),  array( __CLASS__, 'pluginSettingLink'));

		// # CHECK PASSWORD
		add_action('user_profile_update_errors', array( __CLASS__, 'checkEditPassword'));
	}

	// #########################################################################################
	// # ADMIN MENU
	// #########################################################################################
	public static function addMenu()
	{
		add_options_page(__( 'Password Strength', 'Seitenhype Password Strength' ), __( 'Password Strength', 'Seitenhype Password Strength' ), 'manage_options', __FILE__, array( __CLASS__, 'addMenuPage' ));
	}

	// #########################################################################################
	// # ADMIN MENU PAGE
	// #########################################################################################
	public static function addMenuPage()
	{
		// # EDIT POST
		if (isset( $_POST['submit']) && isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'update_password_strength'))
		{
			if(intval($_POST['intPasswordLength']) >= intval($_POST['intNumbers']) + intval($_POST['intLowerChar']) + intval($_POST['intUpperChar']) + intval($_POST['intSymbols']))
			{
				update_option(self::strOptionKey . "_intPasswordLength", $_POST['intPasswordLength']);
				update_option(self::strOptionKey . "_intNumbers"       , $_POST['intNumbers']);
				update_option(self::strOptionKey . "_intLowerChar"     , $_POST['intLowerChar']);
				update_option(self::strOptionKey . "_intUpperChar"     , $_POST['intUpperChar']);
				update_option(self::strOptionKey . "_intSymbols"       , $_POST['intSymbols']);

				$bolUpdated    = true;
			}
			else
			{
				$bolError      = true;
			}
		}

		// # VARIABLES
		$objVar = array(
			'intPasswordLength' => get_option(self::strOptionKey . "_intPasswordLength", self::intPasswordLength),
			'intNumbers'        => get_option(self::strOptionKey . "_intNumbers", self::intNumbers),
			'intLowerChar'      => get_option(self::strOptionKey . "_intLowerChar", self::intLowerChar),
			'intUpperChar'      => get_option(self::strOptionKey . "_intUpperChar", self::intUpperChar),
			'intSymbols'        => get_option(self::strOptionKey . "_intSymbols", self::intSymbols)
		);

		include plugin_dir_path( __FILE__ ) . 'view/admin.php';
	}

	// #########################################################################################
	// # CHECK EDIT PASSWORD
	// #########################################################################################
	public static function checkEditPassword($errors)
	{
		$password           = isset($_POST['pass1']) ? $_POST['pass1'] : '';
		$intPasswordLength  = get_option(self::strOptionKey . "_intPasswordLength", self::intPasswordLength);
		$intNumbers         = get_option(self::strOptionKey . "_intNumbers", self::intNumbers);
		$intLowerChar       = get_option(self::strOptionKey . "_intLowerChar", self::intLowerChar);
		$intUpperChar       = get_option(self::strOptionKey . "_intUpperChar", self::intUpperChar);
		$intSymbols         = get_option(self::strOptionKey . "_intSymbols", self::intSymbols);

		// # EXISTING USER | NEW USER
		if(isset($_POST['user_id']))
		{
			// # EXISTING USER
			$user_id    = intval($_POST['user_id']);
			$user       = get_userdata($user_id);
			$username   = $user->user_login;
		}
		else
		{
			// # NEW USER
			$username = $_POST['user_login'];
		}

		if(empty($password))
			return;

		// # ERRORS
		if(strlen($password) < $intPasswordLength)
			$errors->add('error-password', sprintf(__('Password Length should be minimum "%s" signs', 'Seitenhype Password Strength'), $intPasswordLength), array('form-field' => 'pass1'));

		if(strlen(preg_replace('![^a-z]+!', '', $password)) < $intLowerChar)
			$errors->add('error-password', sprintf(__('Password should contain at least "%s" lowercase character(s)', 'Seitenhype Password Strength'), $intLowerChar), array('form-field' => 'pass1'));

		if(strlen(preg_replace('![^A-Z]+!', '', $password)) < $intUpperChar)
			$errors->add('error-password', sprintf(__('Password should contain at least "%s" uppercase character(s)', 'Seitenhype Password Strength'), $intUpperChar), array('form-field' => 'pass1'));

		if(strlen(preg_replace('![^0-9]+!', '', $password)) < $intNumbers)
			$errors->add('error-password', sprintf(__('Password should contain at least "%s" number(s)', 'Seitenhype Password Strength'), $intNumbers), array('form-field' => 'pass1'));

		if(strlen(preg_replace('![^_]+!', '',preg_replace ('/[^\p{L}\p{N}]/u', '_', $password))) < $intSymbols)
			$errors->add('error-password', sprintf(__('Password should contain at least "%s" symbol(s)', 'Seitenhype Password Strength'), $intSymbols), array('form-field' => 'pass1'));
	}

	// #########################################################################################
	// # PLUGIN SETTING LINK
	// #########################################################################################
	public static function pluginSettingLink($links)
	{
		$settings_link = '<a href="options-general.php?page=user-password-strength%2Fuser-password-strength.php">' . __( 'Settings' ) . '</a>';
		array_push($links, $settings_link);

		return $links;
	}
}

// #########################################################################################
// # INIT
// #########################################################################################
Password_Strength::init();