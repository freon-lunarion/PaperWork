<?php
if ( ! function_exists('form_open'))
{
	/**
	 * Form Declaration
	 *
	 * Creates the opening portion of the form.
	 *
	 * @param	string	the URI segments of the form destination
	 * @param	array	a key/value pair of attributes
	 * @param	array	a key/value pair hidden data
	 * @return	string
	 */
	function form_open($action = '', $attributes = array(), $hidden = array())
	{
		$CI =& get_instance();

		// If no action is provided then set to the current url
		if ( ! $action)
		{
			$action = $CI->config->site_url($CI->uri->uri_string());
		}
		// If an action is not a full URL then turn it into one
		elseif (strpos($action, '://') === FALSE)
		{
			$action = $CI->config->site_url($action);
		}

		$attributes = _attributes_to_string($attributes);

		if (stripos($attributes, 'method=') === FALSE)
		{
			$attributes .= ' method="post"';
		}

		if (stripos($attributes, 'accept-charset=') === FALSE)
		{
			$attributes .= ' accept-charset="'.strtolower(config_item('charset')).'"';
		}

		$form = '<form class="form" action="'.$action.'"'.$attributes.">\n";

		// Add CSRF field if enabled, but leave it out for GET requests and requests to external websites
		if ($CI->config->item('csrf_protection') === TRUE && strpos($action, $CI->config->base_url()) !== FALSE && ! stripos($form, 'method="get"'))
		{
			$hidden[$CI->security->get_csrf_token_name()] = $CI->security->get_csrf_hash();
		}

		if (is_array($hidden))
		{
			foreach ($hidden as $name => $value)
			{
				$form .= '<input type="hidden" name="'.$name.'" value="'.html_escape($value).'" style="display:none;" />'."\n";
			}
		}

		return $form;
	}
}

if ( ! function_exists('form_input'))
{
	/**
	 * Text Input Field
	 *
	 * @param	mixed
	 * @param	string
	 * @param	mixed
	 * @return	string
	 */
	function form_input($data = '', $value = '', $extra = '')
	{
		if (strpos($extra,'class')) {
			$defaults = array(
				'type'  => 'text',
				'name'  => is_array($data) ? '' : $data,
				'id'    => is_array($data) ? '' : $data,
				'value' => $value
			);
		} else {
			$defaults = array(
				'type'  => 'text',
				'name'  => is_array($data) ? '' : $data,
				'id'    => is_array($data) ? '' : $data,
				'class' => 'form-control',
				'value' => $value
			);
		}

		return '<input '._parse_form_attributes($data, $defaults)._attributes_to_string($extra)." />\n";
	}
}

if ( ! function_exists('form_number'))
{
	/**
	 * Number Field
	 *
	 * Identical to the input function but adds the "number" type
	 *
	 * @param	mixed
	 * @param	string
	 * @param	mixed
	 * @return	string
	 */
	function form_number($data = '', $value = '', $extra = '')
	{
		is_array($data) OR $data = array('name' => $data ,'id' => $data);
		$data['type'] = 'number';
		return form_input($data, $value, $extra);
	}
}

if ( ! function_exists('form_date'))
{
	/**
	 * Date Field
	 *
	 * Identical to the input function but adds the "date" type
	 *
	 * @param	mixed
	 * @param	string
	 * @param	mixed
	 * @return	string
	 */
	function form_date($data = '', $value = '', $extra = '')
	{
		$CI =& get_instance();
		$CI->load->library('user_agent'); // load library

		if ( $CI->agent->is_mobile()) {
			is_array($data) OR $data = array('name' => $data ,'id' => $data);
			$data['type']  = 'date';
			return form_input($data, $value, $extra);
		} else {
			is_array($data) OR $data = array('name' => $data ,'id' => $data);
			$data['type']  = 'text';
			$return = "<div class='input-group datepicker'>";
      $return .= form_input($data, $value, $extra);
			$return .= '<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span></div>';
			return $return;

		}
	}
}

if ( ! function_exists('form_password'))
{
	/**
	 * Password Field
	 *
	 * Identical to the input function but adds the "password" type
	 *
	 * @param	mixed
	 * @param	string
	 * @param	mixed
	 * @return	string
	 */
	function form_password($data = '', $value = '', $extra = '')
	{
		is_array($data) OR $data = array('name' => $data ,'id' => $data);
		$data['type'] = 'password';
		return form_input($data, $value, $extra);
	}
}

if ( ! function_exists('form_dropdown'))
{
	/**
	 * Drop-down Menu
	 *
	 * @param	mixed	$data
	 * @param	mixed	$options
	 * @param	mixed	$selected
	 * @param	mixed	$extra
	 * @return	string
	 */
	function form_dropdown($data = '', $options = array(), $selected = array(), $extra = '')
	{
		$defaults = array();

		if (is_array($data))
		{
			if (isset($data['selected']))
			{
				$selected = $data['selected'];
				unset($data['selected']); // select tags don't have a selected attribute
			}

			if (isset($data['options']))
			{
				$options = $data['options'];
				unset($data['options']); // select tags don't use an options attribute
			}
		}
		else
		{
			$defaults = array('name' => $data, 'id' => $data);
			if(strpos($extra,'class') == FALSE) {
				$defaults['class'] = 'form-control';
			}
		}

		is_array($selected) OR $selected = array($selected);
		is_array($options) OR $options = array($options);

		// If no selected state was submitted we will attempt to set it automatically
		if (empty($selected))
		{
			if (is_array($data))
			{
				if (isset($data['name'], $_POST[$data['name']]))
				{
					$selected = array($_POST[$data['name']]);
				}
			}
			elseif (isset($_POST[$data]))
			{
				$selected = array($_POST[$data]);
			}
		}

		$extra = _attributes_to_string($extra);

		$multiple = (count($selected) > 1 && stripos($extra, 'multiple') === FALSE) ? ' multiple="multiple"' : '';

		$form = '<select '.rtrim(_parse_form_attributes($data, $defaults)).$extra.$multiple.">\n";

		foreach ($options as $key => $val)
		{
			$key = (string) $key;

			if (is_array($val))
			{
				if (empty($val))
				{
					continue;
				}

				$form .= '<optgroup label="'.$key."\">\n";

				foreach ($val as $optgroup_key => $optgroup_val)
				{
					$sel = in_array($optgroup_key, $selected) ? ' selected="selected"' : '';
					$form .= '<option value="'.html_escape($optgroup_key).'"'.$sel.'>'
						.(string) $optgroup_val."</option>\n";
				}

				$form .= "</optgroup>\n";
			}
			else
			{
				$form .= '<option value="'.html_escape($key).'"'
					.(in_array($key, $selected) ? ' selected="selected"' : '').'>'
					.(string) $val."</option>\n";
			}
		}

		return $form."</select>\n";
	}
}

if ( ! function_exists('form_textarea'))
{
	/**
	 * Textarea field
	 *
	 * @param	mixed	$data
	 * @param	string	$value
	 * @param	mixed	$extra
	 * @return	string
	 */
	function form_textarea($data = '', $value = '', $extra = '')
	{

		$defaults = array(
      'name'  => is_array($data) ? '' : $data,
      'id'    => is_array($data) ? '' : $data,
		);

		if (strpos($extra,'class') == FALSE) {
			$defaults['class'] = 'form-control';
		}

		if (strpos($extra,'cols') == FALSE) {
			$defaults['cols'] = '40';
		}

		if (strpos($extra,'rows') == FALSE) {
			$defaults['rows'] = '5';
		}

		if ( ! is_array($data) OR ! isset($data['value']))
		{
			$val = $value;
		}
		else
		{
			$val = $data['value'];
			unset($data['value']); // textareas don't use the value attribute
		}

		return '<textarea '._parse_form_attributes($data, $defaults)._attributes_to_string($extra).'>'
			.html_escape($val)
			."</textarea>\n";
	}
}
