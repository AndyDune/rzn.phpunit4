<?
/**
 * ----------------------------------------------------
 * | Автор: Андрей Рыжов (Dune) <info@rznw.ru>         |
 * | Сайт: www.rznw.ru                                 |
 * | Телефон: +7 (4912) 51-10-23                       |
 * | Дата: 04.12.2015                                     |
 * ----------------------------------------------------
 *
 * Почитать про тесты: https://phpunit.de/manual/4.8/en/
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
$moduleDir = __DIR__ . '/modules/' . $modune;
if (!is_dir(__DIR__ . '/modules/' . $modune)) {
    ?>Нет модуля<?
    return;
}

if(isset($_REQUEST['class'])) {
    $class = $_REQUEST['class'];
    $mapFile = $moduleDir . '/tests_map.php';
    if (!is_file($mapFile)) {
        ?>Нет файла с картой классов<?
        return;
    }
    $classMap = include($mapFile);
    if(!array_key_exists($class, $classMap)) {
        ?>Нет соответствия для ключа класса<?
        return;
    }
    $class = $classMap[$class];
    if (!isset($class[0]) or !isset($class[1])) {
        ?>Неверный формат описания инструкции для запуска<?
        return;
    }
    $class[1] = $moduleDir . '/' . ltrim($class[1], '/');
    if (!is_file($class[1])) {
        ?>Нет файла с классом для тестирования: <?
        echo $class[1];
        return;
    }
} else {
    $class = false;
}


//$_SERVER['argv'] = ['MyClassTest', 'test/MyClassTest.php'];
//$array = include(__DIR__ . '/modules/rzn.library/tests_map.php');
//$_SERVER['argv'] = ['', 'modules/rzn.library/tests/format'];
//$_SERVER['argv'] = $array['ArrayModification'];


if ($class) {
    $_SERVER['argv'] = $class;
} else {
    $_SERVER['argv'] = ['', $moduleDir . '/tests'];
}

PHPUnit_TextUI_Command::main();

