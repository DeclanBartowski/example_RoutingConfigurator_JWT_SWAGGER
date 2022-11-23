<?php

namespace SP\Tools;

/**
 * Class Component
 * @package SP\Tools
 */
class Component
{
	/**
	 * @param $name
	 * @param string $template
	 * @param array $params
	 * @param array $filter
	 * @return string
	 */
	public static function getHtmlComponent($name, $template = '.default', $params = [], $filter = [])
	{
		$html = '';
		ob_start();
		if ($filter && $params['FILTER_NAME']) {
			$GLOBALS[$params['FILTER_NAME']] = $filter;
		}
		$GLOBALS['APPLICATION']->IncludeComponent($name, $template, $params);
		$html .= ob_get_contents();
		ob_end_clean();
		return $html;
	}
}