<?
/**
 * ----------------------------------------------------
 * | Автор: Андрей Рыжов (Dune) <info@rznw.ru>         |
 * | Сайт: www.rznw.ru                                 |
 * | Телефон: +7 (4912) 51-10-23                       |
 * | Дата: 04.12.2015                                     |
 * ----------------------------------------------------
 *
 * После устанвоки модуля скопироват этот файл в папку local
 * В репозиторий можно не добавлять - только для тестов.
 * Запускать так: /local/unit.php?module=<название модуля>
 */

use Rzn\Library\Registry;
use Bitrix\Main\Loader;

//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
Loader::includeModule('rzn.phpunit4');


if(isset($_REQUEST['module'])) {
    $modune = $_REQUEST['module'];
} else {
    ?>Нечего тестировать<?
    return;
}

//$_SERVER['argv'] = ['MyClassTest', 'test/MyClassTest.php'];
//$array = include(__DIR__ . '/modules/rzn.library/tests_map.php');
//$_SERVER['argv'] = ['', 'modules/rzn.library/tests/format'];
//$_SERVER['argv'] = $array['ArrayModification'];


$_SERVER['argv'] = ['', __DIR__ . '/modules/' . $modune  .'/tests'];

PHPUnit_TextUI_Command::main();

