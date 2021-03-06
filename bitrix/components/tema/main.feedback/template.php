<?
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */
?>
<style>
    #bl_tema {display: none;};
</style>



<?if($_GET['AB'] == '1'){?>

<div class="bl_tema">
 <a class="fancybox" href="#bl_tema">Предложить тему</a>
</div>

<div id="bl_tema">
     <div class="txt_head_name">
          <h2>Предложить тему</h2>
     </div>


    <div class="mfeedback">
    <?if(!empty($arResult["ERROR_MESSAGE"]))
    {
        foreach($arResult["ERROR_MESSAGE"] as $v)
            ShowError($v);
    }
    if(strlen($arResult["OK_MESSAGE"]) > 0)
    {
        ?><div class="mf-ok-text"><?=$arResult["OK_MESSAGE"]?></div><?
    }
    ?>

    <form action="<?=POST_FORM_ACTION_URI?>" method="POST">
    <?=bitrix_sessid_post()?>
        <div class="mf-name">
            <div class="mf-text">
                <?=GetMessage("MFT_NAME")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("NAME", $arParams["REQUIRED_FIELDS"])):?><span class="mf-req">*</span><?endif?>
            </div>
            <input type="text" name="user_name" value="<?=$arResult["AUTHOR_NAME"]?>">
        </div>

        <div class="mf-message">
            <div class="mf-text">
               О чем статья?<?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("MESSAGE", $arParams["REQUIRED_FIELDS"])):?><span class="mf-req">*</span><?endif?>
            </div>
            <textarea name="MESSAGE" rows="5" cols="40"><?=$arResult["MESSAGE"]?></textarea>
        </div>

        <div class="mf-name">
            <div class="mf-text">
                Ссылка на подобную статью
            </div>
            <input type="text" name="pod_tema" value="<?=$arResult["AUTHOR_NAME"]?>">
        </div>


        <?if($arParams["USE_CAPTCHA"] == "Y"):?>
        <div class="mf-captcha">
            <div class="mf-text"><?=GetMessage("MFT_CAPTCHA")?></div>
            <input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
            <img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="180" height="40" alt="CAPTCHA">
            <div class="mf-text"><?=GetMessage("MFT_CAPTCHA_CODE")?><span class="mf-req">*</span></div>
            <input type="text" name="captcha_word" size="30" maxlength="50" value="">
        </div>
        <?endif;?>
        <input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">
        <input type="submit" name="submit" value="<?=GetMessage("MFT_SUBMIT")?>">
    </form>
    </div>
</div>

<?}?>