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
	function encode_url($string, $key="", $url_safe=TRUE)
	{
		if($key==null || $key=="")
	 	{
			 $key="tyz_mydefaulturlencryption";
	 	}
		$CI =& get_instance();
		$CI->load->library('encrypt' );
	 	$ret = $CI->encrypt->encode($string, $key);

	 if ($url_safe)
	 {
		 $ret = strtr(
					 $ret,
					 array(
							 '+' => '.',
							 '=' => '-',
							 '/' => '~'
					 )
			 );
	 	}

	 	return $ret;
	}

	function decode_url($string, $key="")
	{
		if($key==null || $key=="") {
			$key="tyz_mydefaulturlencryption";
	 	}
	 	$CI =& get_instance();
	 	$CI->load->library('encrypt' );

	 	$string = strtr(
	  	$string,
	 		array(
			 '.' => '+',
			 '-' => '=',
			 '~' => '/'
	 		)
		);

	 return $CI->encrypt->decode($string, $key);
	}
