<?php

/**
 * Created by PhpStorm.
 * User: Sidorenko Pavel
 * Date: 07.09.2021
 * Time: 10:05
 */

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\EventManager;
use Bitrix\Main\Context;

Loc::loadMessages(__FILE__);

class sp_tools extends CModule
{
	var $MODULE_ID = 'sp.tools';
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $PARTNER_NAME;
	var $PARTNER_URI;

	protected $module_path;
	protected $root_dir;

	/**
	 * $_SERVER
	 * @var
	 */
	private $server;


	public function __construct()
	{
		$arModuleVersion = [];

		include(__DIR__ . '/version.php');

		if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion)) {
			$this->MODULE_VERSION = $arModuleVersion['VERSION'];
			$this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
		}

		$this->MODULE_NAME = Loc::getMessage('SP_TOOLS_MODULE_NAME');
		$this->MODULE_DESCRIPTION = Loc::getMessage("SP_TOOLS_MODULE_DESCRIPTION");
		$this->PARTNER_NAME = Loc::getMessage("SP_TOOLS_MODULE_PARTNER_NAME");
		$this->PARTNER_URI = Loc::getMessage("SP_TOOLS_MODULE_PARTNER_URI");
		$this->module_path = dirname(__DIR__);
		$this->root_dir = (strpos($this->module_path, '/local/') !== false ? 'local' : 'bitrix');
		$this->server = Context::getCurrent()->getServer();
	}

	/**
	 * Установка модуля
	 */
	public function DoInstall()
	{
		global $APPLICATION;
		RegisterModule($this->MODULE_ID);
		$APPLICATION->IncludeAdminFile(Loc::getMessage("TQ_TOOLS_MODULE_INSTALL") . $this->MODULE_ID,
			$this->module_path . "/install/step.php");
	}

	/**
	 * Удаление модуля
	 */
	public function DoUninstall()
	{
		global $APPLICATION;
		UnRegisterModule($this->MODULE_ID);
		$APPLICATION->IncludeAdminFile(Loc::getMessage("TQ_TOOLS_MODULE_UNINSTALL") . $this->MODULE_ID,
			$this->module_path . "/install/unstep.php");
	}
}