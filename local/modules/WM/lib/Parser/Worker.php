<?php


namespace WM\Parser;

\CModule::IncludeModule("iblock");

class Worker
{
	public $iblockId;
	public $sections;
	public $items;

	public function __construct($iblockId)
	{
		$this->iblockId = $iblockId;
	}

	public function getSections()
	{
		$iblockSection = new \CIBlockSection();
		$res = $iblockSection->GetList([], ['IBLOCK_ID' => $this->iblockId]);

		$this->sections = [];
		while ($section = $res->Fetch())
		{
			$this->sections[$section['XML_ID']] = [
				'ID' => $section['ID'],
				'NAME' => $section['NAME'],
				'XML_ID' => $section['XML_ID'],
			];
		}

		return $this->sections;
	}

	public function getProducts()
	{
		$iblockElement = new \CIBlockElement();
		$res = $iblockElement->GetList([], ['IBLOCK_ID' => $this->iblockId]);

		$this->items = [];
		while ($item = $res->Fetch())
			$this->items[$item['XML_ID']] = $item;

		return $this->items;
	}

	public function checkSections($sections)
	{
		foreach ($sections as $sectionID => $section)
		{
			$bs = new \CIBlockSection;
			$parent = false;
			$parentSection = null;

			$arFields = [
				"ACTIVE" => 'Y',
				"IBLOCK_ID" => $this->iblockId,
				"XML_ID" => $section['XML_ID'],
				"NAME" => $section['NAME'],
				"CODE" => \CUtil::translit($section['NAME'], 'ru'),
				"SORT" => 500,
				"PICTURE" => '',
				"DESCRIPTION" => '',
				"DESCRIPTION_TYPE" => '',
			];

			if (!isset($this->sections[$sectionID]))
			{
				if ($section['PARENT'])
				{
					$list = $bs->GetList([], ['XML_ID' => $section['PARENT']]);

					if ($item = $list->Fetch())
					{
						$parentSection = $item;
						$parent = true;
					}
				}

				$arFields["IBLOCK_SECTION_ID"] = ($parent) ? $parentSection['ID'] : 0;
				$id = $bs->Add($arFields);
				if (empty($id))
				{
					$arFields['CODE'] = \CUtil::translit($section['NAME'], 'ru') . mt_rand(10, 99);
					$id = $bs->Add($arFields);
				}
			}
			elseif ($this->sections[$sectionID]['NAME'] != $section['NAME'])
			{
				$bs->Update($this->sections[$sectionID]['ID'], $arFields);
			}
		}

	}

	public function checkProducts($products)
	{
		foreach ($products as $productId => $product)
		{
			$el = new \CIBlockElement();
			$arFields = [
				'ACTIVE' => 'Y',
				'IBLOCK_ID' => $this->iblockId,
				'IBLOCK_SECTION_ID' => $this->sections[$product['PARENT']]['ID'],
				'NAME' => $product['NAME'],
				'CODE' => \CUtil::translit($product['NAME'], 'ru'),
			    'XML_ID' => $product['XML_ID'],
			];
			$arFields['PROPERTY_VALUES'] = [];

			foreach ($product['PROP'] as $key => $value)
			{
				$arFields['PROPERTY_VALUES'][$key] = $value;
			}

			if (!isset($this->products[$productId]))
			{
				$id = $el->Add($arFields);
			}

			if(!empty($id))
			{
				if(\CCAtalogProduct::Add(array('ID' => $id, 'QUANTITY' => 1, 'VAT_ID' => 1, 'VAT_INCLUDED' => 'Y')))
				{
					$price = (string) $product['PRICE'];
					$price = false === strpos($price, '.') ? (int) $price : (double) $price;
					$priceFields = array(
						'PRODUCT_ID' => $id,
						'CATALOG_GROUP_ID' => 1,
						'PRICE' => $price,
						'CURRENCY' => 'RUB',
					);

					//set product price
					$res = \CPrice::GetList(array(), array('PRODUCT_ID' => $id, 'CATALOG_GROUP_ID' => 1));

					if ($arr = $res->Fetch())
						\CPrice::Update($arr['ID'], $priceFields);
					else
						\CPrice::Add($priceFields);
				}

			}
		}
	}
}