<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class Quizy extends BaseConfig
{
	/**
	 * The current version of Quizy Platform
	 */
	const QUIZY_VERSION = null;

	/**
	 * List of available locales.
	 * Default English
	 */
	public $locales = [
		'en' => 'English',
		'tr' => 'Türkçe',
	];

	/**
	 * Team's auth code size in bytes
	 */
	public $authCodeSize = 16;
}
