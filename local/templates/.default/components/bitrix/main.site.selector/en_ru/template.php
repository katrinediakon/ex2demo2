<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<select name="formal" onchange="javascript:handleSelect(this)">
<?foreach ($arResult["SITES"] as $key => $arSite):?>

<?if ($arSite["CURRENT"] == "Y"):?>
	<option selected value="<?=$arSite["DIR"]?>"><?=$arSite["LANG"]?></option>
<?else:?>
<option value="<?=$arSite["DIR"]?>">  <?=$arSite["LANG"]?></option></a>
<?endif?>

<?endforeach;?>
</select>


<script type="text/javascript">
function handleSelect(elm)
{
window.location = elm.value;
}
</script>
