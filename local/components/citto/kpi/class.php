<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
  die();
}


//use Bitrix\Main\Loader;
use Bitrix\Main\Data\Cache;
//use Monolog\Logger;
//use Monolog\Handler\StreamHandler;
use Bitrix\Main\Engine\Contract\Controllerable;







/**
 * Класс для работы c KPI
 *
 * Class CittoKPIComponent
 */
class CittoKPIComponent extends CBitrixComponent implements Controllerable
{
  /**
   * Конфигурация аякс запросов
   *
   * @return array
   */
  public function configureActions(): array
  {
    return [
      'test'                => ['prefilters' => []],
    ];
  }


  /**
   * Для работы компонента
   *
   * @return array|mixed
   * @throws Exception Коментарий.
   */
  public function executeComponent()
  {
    global $APPLICATION;
    global $USER;

    $cacheId = implode('|', [
      SITE_ID,
      $APPLICATION->GetCurPage(),
      $USER->GetGroups()
    ]);

    foreach ($this->arParams as $k => $v) {
      if (strncmp('~', $k, 1)) {
        $cacheId .= ',' . $k . '=' . $v;
      }
    }

    $cacheDir = '/' . SITE_ID . $this->GetRelativePath();
    $cache    = Cache::createInstance();

    $templateCachedData = $this->GetTemplateCachedData();

    if ($cache->startDataCache($this->arParams['CACHE_TIME'], $cacheId, $cacheDir)) {
      $this->IncludeComponentTemplate();

      $cache->endDataCache([
        'arResult'           => $this->arResult,
        'templateCachedData' => $templateCachedData,
      ]);
    } else {
      extract($cache->GetVars());
      $this->SetTemplateCachedData($templateCachedData);
    }

    $this->strTemplatePath = $this->__template->GetFolder();

    return $this->arResult;
  }




  public function testAction()
  {

    $arRes = [
      'title' => 'Bitrix',
      'subtitle' => 'Vue',
    ];

    return $arRes;
  }



}
