<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?></b></p>


<?php foreach ($arResult as $key => $value): ?>

  <p>[<?=$value["ID"]?>] - <?=$value["NAME"]?></p>
  <ul>

<?foreach ($value["NEWS"] as $key1 => $news):?>
<li> - <?=$news?></li>
<?endforeach?>
</ul>
<?php endforeach; ?>
