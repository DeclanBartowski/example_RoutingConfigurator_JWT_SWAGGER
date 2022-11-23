<?
$arLibs = [
    $_SERVER['DOCUMENT_ROOT'].'/local/php_interface/include/defines.php',
	__DIR__.'/../vendor/autoload.php',
];

foreach($arLibs as $lib){
    if(file_exists($lib)){
        require_once($lib);
    }
}

\Bitrix\Main\Loader::registerAutoLoadClasses(null, [
	'nav\\IblockOrm\\MultiplePropertyElementTable' => '/local/lib/nav/IblockOrm/MultiplePropertyElementTable.php',
	'nav\\IblockOrm\\SinglePropertyElementTable' => '/local/lib/nav/IblockOrm/SinglePropertyElementTable.php',
	'nav\\IblockOrm\\ElementTable' => '/local/lib/nav/IblockOrm/ElementTable.php',
]);