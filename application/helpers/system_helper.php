<?php defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! function_exists('antinull'))
{
	/**
	 * Site URL
	 *
	 * Create a local URL based on your basepath. Segments can be passed via the
	 * first parameter either as a string or an array.
	 *
	 * @param	string	$uri
	 * @param	string	$protocol
	 * @return	string
	 */
	function antinull($value = '', $default = 0)
	{
		if ($value == '' OR is_null($value)) {
		  return $default;
		} else {
      return $value;
    }
	}
}
