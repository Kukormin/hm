<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<? $this->setFrameMode(true); ?>
<?if(count($arResult["ITEMS"])>0):?>
	<?foreach($arResult["ITEMS"] as $key => $arItem):?>
	<? if (isset($arItem['OFFERS']) && !empty($arItem['OFFERS'])) { 
		$element = $arItem['OFFERS'][0];
	 } else {
		$element = $arItem;
	 } 
	 if (isset($arItem['OFFERS'][0]['QUICKBUY']) && !empty($arItem['OFFERS'][0]['QUICKBUY'])) { 
		$timer = $arItem['OFFERS'][0]['QUICKBUY'];
	 } else {
		$timer = $arItem['QUICKBUY'];
	 } ?>
				<!-- first view -->
		<div class="daysarticle light_wrap view1" id="<?=$element['ID']?>">
			<div class="left_part">
				<div class="title">
					<h4><?=GetMessage("QUICK_BLOCK_TITLE")?></h4>
					<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a>
				</div>
				<div class="prices_wrap">
					<span class="price"><?=$element["PRICES"][$arParams["PRICE_CODE"]]["PRINT_VALUE"]?></span>
					<span class="discount_price"><?=$element["PRICES"][$arParams["PRICE_CODE"]]["PRINT_DISCOUNT_VALUE"]?></span>
					<span class="discount"><?=GetMessage("DISCOUNT_VALUE")?> <span><?=$element["PRICES"][$arParams["PRICE_CODE"]]["PRINT_DISCOUNT_DIFF"]?></span></span>
					<div class="triangle"></div>
				</div>
				<div class="time_wrap">
					<span><?=GetMessage("QUICK_TIME")?></span>
					<? if ($timer["TIMER"]["DAYS"]==0) { ?>
						<div class="digits" data-dateto="<? echo strtotime($timer['DATE_TO']); ?>">
							<div class="digit" id="hours"><span class="number js-hours" data-time=""></span><div class="digit_outter"></div></div>
							<div class="digit" id="minutes"><span class="number js-minutes" data-time=""></span><div class="digit_outter"></div></div>
							<div class="digit" id="seconds"><span class="number js-seconds" data-time=""></span><div class="digit_outter"></div></div>
							<div class="digit progress"><span class="number"><?=$timer["QUANTITY"]?></span><div class="digit_outter"></div></div>
						</div>
						<div class="digit_titles">
							<span class="digit_title"><?=GetMessage("QUICK_TIME_HOUR")?></span>
							<span class="digit_title"><?=GetMessage("QUICK_TIME_MIN")?></span>
							<span class="digit_title"><?=GetMessage("QUICK_TIME_SEC")?></span>
							<span class="digit_title percent"><?=GetMessage("QUICK_QUANT")?></span>
						</div>
					<? } else { ?>
						<div class="digits" data-dateto="<? echo strtotime($timer['DATE_TO']); ?>">
							<div class="digit" id="days"><span class="number js-days" data-time=""></span><div class="digit_outter"></div></div>
							<div class="digit" id="hours"><span class="number js-hours" data-time=""></span><div class="digit_outter"></div></div>
							<div class="digit" id="minutes"><span class="number js-minutes" data-time=""></span><div class="digit_outter"></div></div>
							<div class="digit progress"><span class="number"><?=$timer["QUANTITY"]?></span><div class="digit_outter"></div></div>
						</div>
						<div class="digit_titles">
							<span class="digit_title"><?=GetMessage("QUICK_TIME_DAY")?></span>
							<span class="digit_title"><?=GetMessage("QUICK_TIME_HOUR")?></span>
							<span class="digit_title"><?=GetMessage("QUICK_TIME_MIN")?></span>
							<span class="digit_title percent"><?=GetMessage("QUICK_QUANT")?></span>
						</div>
					<? } ?>
					<div class="progress_bar">
						<div class="progress" style="width: <? echo round($timer['TIMER']['TIME_LIMIT']/(strtotime($timer['DATE_TO']) - strtotime($timer['DATE_FROM']))*100); ?>%;"></div>
					</div>
				</div>
			</div>
			<div class="right_part">
				<div class="circle_progress">
					<input id="circle_progress_input" type="text" value="<? echo round($timer['TIMER']['TIME_LIMIT']/(strtotime($timer['DATE_TO']) - strtotime($timer['DATE_FROM']))*100); ?>" class="circle" data-width="90" data-quant="<?=$timer["QUANTITY"]?>" data-fgColor="#85a959" data-displayPrevious=true  data-readOnly=true data-thickness="0.05">
					<label class="progress_caption" for="circle_progress_input"><?=GetMessage("QUICK_TO_THE_END")?> <span><?=GetMessage("QUICK_CIRCLE_TITLE")?></span></label>
				</div>
				<div class="img_wrap">
					<?if($arItem["PREVIEW_PICTURE"]["SRC"]!=""):?>
						<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
							<img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" border="" alt="" />
						</a>
					<?elseif($arItem["DETAIL_PICTURE"]["SRC"]!=""):?>
						<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
							<img src="<?=$arItem["DETAIL_PICTURE"]["SRC"]?>" border="" alt="" />
						</a>
					<?endif;?>
				</div>
				<span class="article"><h4><?=GetMessage("QUICK_DISCOUNT_TITLE")?></h4></span>
			</div>
		</div>
		<!-- /first view -->
	    <script>
	    	$(document).ready(function() {
	    		$(".circle").knob();
	    	});
	    </script>
	<? endforeach; ?>
<? endif; ?>