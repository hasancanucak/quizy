<?php

use Config\Services;

//--------------------------------------------------------------------

/**
 * Markdown parser
 */
if (! function_exists('markdown'))
{
	/**
	 * Convert markdown text to HTML
	 *
	 * @param  string $text - markdown text
	 * @return string
	 */
	function markdown(string $text): string
	{
		$parser = Services::markdown();
		return $parser->convertToHtml($text);
	}
}

//--------------------------------------------------------------------
