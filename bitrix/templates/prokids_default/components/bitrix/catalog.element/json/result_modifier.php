<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();

use Bitrix\Main\Loader;

if (!Loader::includeModule('catalog'))
    return;
if (!Loader::includeModule('redsign.devfunc'))
    return;

$arElementsIDs = array($arResult['ID']);

if (is_array($arResult['OFFERS']) && count($arResult['OFFERS']) > 0) {
    foreach ($arResult['OFFERS'] as $iOfferKey => $arOffer) {
        // USE_PRICE_COUNT fix
        if (!in_array($arOffer['ID'], $arElementsIDs)) {
            $arElementsIDs[] = $arOffer['ID'];
        } else {
            unset($arResult['OFFERS'][$iOfferKey]);
        }
    }
}

$params = array(
    'SKU_MORE_PHOTO_CODE' => $arParams['PROP_SKU_MORE_PHOTO'],
    'SIZES' => array(
        'WIDTH' => 210,
        'HEIGHT' => 140
    ),
    'SKU_ARTICLE_CODE' => $arParams['PROP_SKU_ARTICLE']
);

if ($arParams['USE_PRICE_COUNT']) {

    $arPriceTypeID = array();
    foreach ($arResult['CAT_PRICES'] as $value) {
        $arPriceTypeID[] = $value['ID'];
    }

    $params['USE_PRICE_COUNT'] = $arParams['USE_PRICE_COUNT'];
    $params['FILTER_PRICE_TYPES'] = $arPriceTypeID;
    $params['CURRENCY_PARAMS'] = $arResult['CONVERT_CURRENCY'];
}

$arResult['JSON_EXT'] = RSDevFuncOffersExtension::GetJSONElement(
    $arResult,
    $arParams['PROPS_ATTRIBUTES'],
    $arParams['PRICE_CODE'],
    $params
);
