<?php

return [
	'settings'    => 'Settings',
	'general'     => 'General',
	'timer'       => 'Timer',
	'data'        => 'Data',
	'ctfName'     => 'Cite Name',
	'memberLimit' => 'Member Limit',
	'theme'       => 'Theme',
	'default'     => 'Default',

	'updatedSuccessfully' => 'Settings updated successfully',

	// general settings
	'ctfNameTitle'         => 'Cite Name',
	'ctfNameDesc'          => 'The name of the Competition. Or the name of the cite.',
	'teamMemberLimitTitle' => 'Team Member Limit',
	'teamMemberLimitDesc'  => 'Max team member.',
	'themeTitle'           => 'Theme',
	'themeDesc'            => 'The theme of the cite',
	'allowRegister'        => 'Allow Register',
	'disallowRegister'     => 'Dissallow Register',
	'allowRegisterTitle'   => 'Allow Register',
	'allowRegisterDesc'    => 'New user register allow or dissallow',
	'needHash'             => 'Need hash for flags',
	'noNeedHash'           => 'No need hash for flags',
	'needHashTitle'        => 'Need hash for flags',
	'needHashDesc'         => 'New user register allow or dissallow',
	'needHashKeyDesc'      => 'This key adds end of the flag before hash.',
	'hashSecretKey'        => 'Hash Secret Key',
	'regenHashSecretKey'   => 'Regenerate Hash Secret Key',

	// timer settings
	'ctfTimer'             => 'Question Timer',
	'timerTitle'           => 'Timer',
	'timerDesc'            => 'Configure question timer',
	'startTime'            => 'Start Time',
	'endTime'              => 'End Time',

	// theme settings
	'themes'               => 'Themes',
	'deleteTheme'          => 'Delete the theme',
	'importTheme'          => 'Import a Theme',
	'themeChanged'         => 'Theme changed successfully',
	'defaultThemeErr'      => 'Default theme newer be deleted',
	'themeValidationErr'   => 'Theme not valid',
	'currentThemeErr'      => 'Current theme can not be deleted. Please change theme first',
	'themeDeleted'         => 'Theme successfully deleted',
	'themeImported'        => 'Theme Imported',

	// data settings
	'backup'               => 'Backup',
	'reset'                => 'Reset',
	'download'             => 'Download',
	'backupDesc'           => 'Backup files',
	'backupSuccessful'     => 'Taking backup successfull',
	'deletedSuccessfully'  => 'Deleted Successfully',
	'fileNotExist'         => 'File not exist {file}',
	'deleteError'          => 'File delete error happen',
	'reseted'              => 'Reset successfull',
	'resetConfirm'         => 'Are you sure you want to procedure. THIS ACTION IS NOT IRREVERSIBLE !!!',
	'confirmCheckbox'      => 'I am sure I want to reset the QUIZY',
	'resetWarningTitle'    => 'This action is <b>NOT irrevertible</b>. Do not make mistake.',
	'resetWarningList' => [
		'All categories, challenges flags hints will be deleted',
		'All users (except members of admin group) will be deleted',
		'All uploaded files will be deleted',
	],
	'resetWarning2' => 'Are you sure you want to continue ???',

	// home page settings
	'home'                 => 'Home Page',
	'pageChangeError'      => 'Can not write to disk',
	'pageChanged'          => 'Home page changed successfully',
	'note'                 => 'Note',
	'noteContent'          => 'You can use Jquery and Bootstrap 4 in here.',
	'warning'              => 'Warning',
	'jsWarning'            => 'Please be careful when you put javascript code in here! This content will NOT be escaped in homepage!',
];
