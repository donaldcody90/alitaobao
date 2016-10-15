<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Site (by CI Bootstrap 3)
| -------------------------------------------------------------------------
| This file lets you define default values to be passed into views when calling 
| MY_Controller's render() function. 
|
| Each of them can be overrided from child controllers.
|
*/

$config['site'] = array(

	// Site name
	'name' => 'Việt Trung',

	// Default page title
	// (set empty then MY_Controller will automatically generate one based on controller / action)
	'title' => 'Việt Trung',

	// Default meta data (name => content)
	'meta'	=> array(
		'author'		=> 'Donald Cody',
		'description'	=> 'vt application'
	),

	// Default scripts to embed at page head / end
	'scripts' => array(
		'head'	=> array(
		'static/js/jquery-1.9.1.min.js',
		'static/js/ajax_handle.js',
		'static/js/custom.js',
		'static/js/skype.js',
		'static/js/w2ui-1.4.3.min.js',	
		'static/js/jquery.dialog.js'	
		),
		'foot'	=> array(
			'static/js/jquery-min.js',
			'static/js/bootstrap.min.js',
			'static/js/profile.js',
		),
	),
	// Default stylesheets to embed at page head
	'stylesheets' => array(
		'screen' => array(
			'static/css/none-responsive.css',
			'static/css/bootstrap.css',
			'static/css/slick.css',
			'static/css/jquery-ui.css',
			'static/css/font-awesome.css',
			
			
			'static/css/main.css',
			'static/css/profile.css',
			'static/css/general-style.css',
			
			'static/css/site.css',
			'static/css/sign-up.css',
			
			'static/css/skin-red.css',
			'static/css/style.css',
		)
	),
	// Multilingual settings (set empty array to disable this)
	'multilingual' => array(
		'default'		=> 'en',			// to decide which of the "available" languages should be used
		'available'		=> array(			// availabe languages with names to display on site (e.g. on menu)
			'en' => array(					// abbr. value to be used on URL, or linked with database fields
				'label'	=> 'English',		// label to be displayed on language switcher
				'value'	=> 'english',		// to match with CodeIgniter folders inside application/language/
			),
			'zh' => array(
				'label'	=> '繁體中文',
				'value'	=> 'traditional-chinese',
			),
			'cn' => array(
				'label'	=> '简体中文',
				'value'	=> 'simplified-chinese',
			),
		),
		'autoload'		=> array('general'),	// language files to autoload
	),

	// Google Analytics User ID (UA-XXXXXXXX-X)
	'ga_id' => '',
	
	// Menu items
	// (or directly update view file: applications/views/_partials/navbar.php)
	'menu' => array(
		'home' => array(
			'name'		=> 'Home',
			'url'		=> '',
		),
		
		// end of demo
		'sign_up' => array(
			'name'		=> 'Sign Up',
			'url'		=> 'auth/sign_up',
		),
		'login' => array(
			'name'		=> 'Login',
			'url'		=> 'auth/login',
		),
	),

	// default page when redirect non-logged-in user
	'login_url' => 'auth/login',

	// restricted pages to specific groups of users, which will affect sidemenu item as well
	// pages out of this array will have no restriction
	'page_auth' => array(
		'account'		=> array('members')
	),

	// For debug purpose (available only when ENVIRONMENT = 'development')
	'debug' => array(
		'view_data'		=> FALSE,	// whether to display MY_Controller's mViewData at page end
		'profiler'		=> FALSE,	// whether to display CodeIgniter's profiler at page end
	),

);