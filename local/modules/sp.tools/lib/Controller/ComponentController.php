<?php

namespace SP\Tools\Controller;

use Bitrix\Main\Application;
use SP\Tools\Component;

/**
 * Class ComponentController
 * @package SP\Tools\Controller
 */
class ComponentController extends \Bitrix\Main\Engine\Controller
{
	/**
	 * @return array
	 */
	public function configureActions()
	{
		return [
			'getLocationsHtml' => [
				'prefilters' => []
			],
		];
	}

	/**
	 * @return string
	 */
	public function getLocationsHtmlAction()
	{
		$request = Application::getInstance()->getContext()->getRequest()->toArray();

		return Component::getHtmlComponent('bitrix:news.list', 'map',
			[
				'IS_AJAX' => 'Y',
				"ACTIVE_DATE_FORMAT" => "d.m.Y",
				"ADD_SECTIONS_CHAIN" => "N",
				"AJAX_MODE" => "N",
				"AJAX_OPTION_ADDITIONAL" => "",
				"AJAX_OPTION_HISTORY" => "N",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "Y",
				"CACHE_FILTER" => "N",
				"CACHE_GROUPS" => "Y",
				"CACHE_TIME" => "36000000",
				"CACHE_TYPE" => "A",
				"CHECK_DATES" => "Y",
				"DETAIL_URL" => "",
				"DISPLAY_BOTTOM_PAGER" => "N",
				"DISPLAY_DATE" => "Y",
				"DISPLAY_NAME" => "Y",
				"DISPLAY_PICTURE" => "Y",
				"DISPLAY_PREVIEW_TEXT" => "Y",
				"DISPLAY_TOP_PAGER" => "N",
				"FIELD_CODE" => ["", ""],
				"FILTER_NAME" => "locationFilter",
				"HIDE_LINK_WHEN_NO_DETAIL" => "N",
				"IBLOCK_ID" => "10",
				"IBLOCK_TYPE" => "content",
				"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
				"INCLUDE_SUBSECTIONS" => "Y",
				"MESSAGE_404" => "",
				"NEWS_COUNT" => "20",
				"PAGER_BASE_LINK_ENABLE" => "N",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_TEMPLATE" => ".default",
				"PAGER_TITLE" => "Новости",
				"PARENT_SECTION" => "",
				"PARENT_SECTION_CODE" => "",
				"PREVIEW_TRUNCATE_LEN" => "",
				"PROPERTY_CODE" => ["ADRESS", "WORK_TIME", "CITY", "METRO", "PHONE", "MAP", ""],
				"SET_BROWSER_TITLE" => "N",
				"SET_LAST_MODIFIED" => "N",
				"SET_META_DESCRIPTION" => "Y",
				"SET_META_KEYWORDS" => "N",
				"SET_STATUS_404" => "N",
				"SET_TITLE" => "N",
				"SHOW_404" => "N",
				"SORT_BY1" => "SORT",
				"SORT_BY2" => "ID",
				"SORT_ORDER1" => "DESC",
				"SORT_ORDER2" => "ASC",
				"STRICT_SECTION_CHECK" => "N"
			],
			['PROPERTY_CITY' => $request['id']]
		);
	}
}