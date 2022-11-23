<?php
/**
 * Created by PhpStorm.
 * User: 2qucick
 * Date: 04.01.2018
 * Time: 10:05
 * @var string $mid
 * @var string $REQUEST_METHOD
 */

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\HttpApplication;
use Bitrix\Main\Config\Option;

$server = HttpApplication::getInstance()->getContext()->getServer()->toArray();
Loc::loadMessages($server["DOCUMENT_ROOT"] . BX_ROOT . "/modules/main/options.php");
Loc::loadMessages($server["DOCUMENT_ROOT"] . "/local/modules/" . $module_id . "/include.php");
Loc::loadMessages(__FILE__);

$request = HttpApplication::getInstance()->getContext()->getRequest();
$post = $request->getPostList()->toArray();
$module_id = htmlspecialcharsbx($request["mid"] != "" ? $request["mid"] : $request["id"]);
$allModuleOptions = Option::getForModule($module_id);
$defSettings = $allModuleOptions['tq_default_settings'];
if(strlen($defSettings)>0){
	$arDefSettings = unserialize($defSettings);
}
/*Settings Tab Start*/
$arAllOptions = [
	[
		'DIV' => 'settings',
		'TAB' => Loc::getMessage("TQ_TOOLS_MAIN_TAB_TAB"),
		'TITLE' => Loc::getMessage("TQ_TOOLS_MAIN_TAB_TITLE"),
		'OPTIONS' => [
			Loc::getMessage("TQ_TOOLS_MAIN_TAB_CREATE_TAB"),
			[
				'tab_name',
				Loc::getMessage("TQ_TOOLS_MAIN_TAB_NAME_FIELD"),
				'',
				[
					'text',
					50,
				],
			],
			[
				'tab_title',
				Loc::getMessage("TQ_TOOLS_MAIN_TAB_TITLE_FIELD"),
				'',
				[
					'text',
					50,
				],
			],
			[
				'',
				'',
				'<input type="submit" value="'.Loc::getMessage("TQ_TOOLS_ADD").'" name="new_tab_action">',
				[
					'statichtml',
				],
			],
		],
	],
];
/*Settings Tab End*/
/*Tabs Start*/
foreach ($arDefSettings['TABS'] as $key => $arTab) {
	$fields = [];
	if(!empty($arTab['OPTIONS'])) {
		$counter =0;
		foreach ($arTab['OPTIONS'] as $optCode => $OPTION) {

			$optionName = '<input type="submit" name="remove_'.$key.'_'.$OPTION['CODE'].'" value="Удалить"><span id="hint_'.$OPTION['CODE'].'"></span>
                     <script type="text/javascript">BX.hint_replace(BX("hint_'.$OPTION['CODE'].'"), "'.CUtil::JSEscape(Loc::getMessage("TQ_TOOLS_TABS_NOTIFICATION").'tq_module_param_'.$key.'_'.$OPTION['CODE']).'");</script>
                    <label for="'.'tq_module_param_'.$key.'_'.$OPTION['CODE'].'">'.$OPTION['NAME'].':</label>';

			if($counter ==0) {
				$fields[] =Loc::getMessage("TQ_TOOLS_TABS_FIELDS");
			}
			$counter++;
			$fields[]=[
				'tq_module_param_'.$key.'_'.$OPTION['CODE'],
				$optionName,
				Option::get($module_id, 'tq_module_param_'.$key.'_'.$OPTION['CODE']),
				[
					'text',
					50
				],
			];
		}
		unset($optionName);
	}
	$addFieldConstructor = [
		Loc::getMessage("TQ_TOOLS_TABS_ADD_FIELD"),
		[
			$key.'_field_code',
			Loc::getMessage("TQ_TOOLS_TABS_CODE_FIELD"),
			'',
			[
				'text',
				50
			],
		],
		[
			$key.'_field_name',
			Loc::getMessage("TQ_TOOLS_TABS_NAME_FIELD"),
			'',
			[
				'text',
				50
			],
		],
		[
			'create_field',
			'',
			'<input type="submit" value="'.Loc::getMessage("TQ_TOOLS_ADD").'" name="new_field">',
			[
				'statichtml',
			],
		],
		Loc::getMessage("TQ_TOOLS_TABS_TAB"),
		[
			'create_field',
			Loc::getMessage("TQ_TOOLS_TABS_REMOVE_TAB"),
			'<input type="submit" value="'.Loc::getMessage("TQ_TOOLS_REMOVE").'" name="remove_tab_'.$key.'">',
			[
				'statichtml',
			],
		],
	];
	$arAllOptions[] =[
		'DIV' =>$key,
		'TAB' => $arTab['TAB'],
		'TITLE' => $arTab['TITLE'],
		'OPTIONS' => array_merge($fields,$addFieldConstructor),
	];
}
/*Tabs End*/
$tabControl = new CAdminTabControl("tabControl", $arAllOptions);
// =====================================================================================================================
// ====================================== [START][SetOption][RemoveDeletedOptions][CreateRemoveTabs][SetMainModuleSettings] ===========================================================
// =====================================================================================================================
if ($REQUEST_METHOD == "POST" && check_bitrix_sessid()) {
	if(strlen($request['tab_name'])>0) {
		$code = CUtil::translit($request['tab_name'],'ru');
		$arDefSettings['TABS'][$code]['TAB'] = $request['tab_name'];
		$arDefSettings['TABS'][$code]['TITLE'] = $request['tab_title'];
	}

	$activeTab = $request["tabControl_active_tab"];

	$optionCode = CUtil::translit($request[$activeTab.'_field_code'],'ru');
	if(strlen($optionCode)>0) {
		Option::set($module_id, "tq_module_param_".$activeTab.'_'.$optionCode, '');
		$arDefSettings['TABS'][$activeTab]['OPTIONS'][$optionCode]['CODE'] = $optionCode;
		$arDefSettings['TABS'][$activeTab]['OPTIONS'][$optionCode]['NAME'] = $request[$activeTab.'_field_name'];
	}

	foreach ($arDefSettings['TABS'] as $tabKey => $arTab) {
		$remove_tab = $request['remove_tab_'.$tabKey];
		if($arTab['OPTIONS']) {
			foreach ($arTab["OPTIONS"] as $optCode => $option) {
				$param_value = $request['tq_module_param_'.$tabKey.'_'.$option['CODE']];
				$remove_param = $request['remove_'.$tabKey.'_'.$option['CODE']];
				if(!empty($remove_tab)) {
					Option::delete($module_id, ['name'=>"tq_module_param_".$tabKey.'_'.$option['CODE'],'site_id'=>'']);
					unset($arDefSettings['TABS'][$tabKey]['OPTIONS'][$option['CODE']]);
				}else{
					if(!empty($remove_param)) {
						Option::delete($module_id, ['name'=>"tq_module_param_".$tabKey.'_'.$option['CODE'],'site_id'=>'']);
						unset($arDefSettings['TABS'][$tabKey]['OPTIONS'][$option['CODE']]);
					} else {
						if(strlen($param_value)>0){
							Option::set($module_id, "tq_module_param_".$tabKey.'_'.$option['CODE'], $param_value);
						}
					}
				}
			}
		}
		if(!empty($remove_tab)) {
			unset($arDefSettings['TABS'][$tabKey]);
		}
	}
	$serrializeDefSettings = serialize($arDefSettings);
	Option::set($module_id, "tq_default_settings", $serrializeDefSettings);

	LocalRedirect($APPLICATION->GetCurPage() . "?mid=" . urlencode($mid) . "&lang=" . urlencode(LANGUAGE_ID) . "&back_url_settings=" . urlencode($request['back_url_settings']) . "&" . $tabControl->ActiveTabParam());
}?>

<form method="POST"
      action="<? echo $APPLICATION->GetCurPage() ?>?mid=<?= htmlspecialchars($mid) ?>&lang=<?= LANGUAGE_ID ?>"
      enctype="multipart/form-data">
	<? $tabControl->Begin(); ?>

	<?
	foreach ($arAllOptions as $aTab) {

		if ($aTab["OPTIONS"]) {

			$tabControl->BeginNextTab();

			__AdmSettingsDrawList($module_id, $aTab["OPTIONS"]);
		}
	}
	$tabControl->Buttons();
	?>
	<input class="adm-btn-save" type="submit" name="Apply" value="<?= Loc::getMessage("MAIN_OPT_APPLY") ?>" title="<?= Loc::getMessage("MAIN_OPT_APPLY_TITLE") ?>">
	<?= bitrix_sessid_post(); ?>

	<? $tabControl->End(); ?>
</form>