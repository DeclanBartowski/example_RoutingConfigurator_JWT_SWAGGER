<?php

namespace SP\Tools\Services;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\Loader;
use nav\IblockOrm\ElementTable;

Loader::includeModule('iblock');

class IblockService
{

	/**
	 * @param ElementTable $entity
	 * @param int $limit
	 * @param int $offset
	 * @param string[] $arOrder
	 * @param string[] $arSelect
	 * @param array $arFilter
	 * @param array $arGroup
	 * @param array $cache
	 * @return mixed
	 * @throws ArgumentException
	 */
	public function getList(
		ElementTable $entity,
		$limit = 25,
		$offset = 0,
		$arOrder = ['SORT' => 'ASC'],
		$arSelect = ['ID', 'NAME', 'CODE', 'SORT'],
		$arFilter = [],
		$arGroup = [],
		$cache = [/*'ttl' => 3600, 'cache_joins' => true*/]
	) {

		$rsElement = $entity::getList([
			'order' => $arOrder,
			'select' => $arSelect,
			'filter' => $arFilter,
			'group' => $arGroup,
			'limit' => $limit,
			'offset' => $offset,
			'count_total' => 1,
			'runtime' => [],
			'data_doubling' => false,
			'cache' => $cache,
		]);

		$result['ITEMS'] = $entity::fetchAllWithProperties($rsElement);
		$result['NAV_RESULT'] = $rsElement->oldCDBResult;

		return $result;
	}

}