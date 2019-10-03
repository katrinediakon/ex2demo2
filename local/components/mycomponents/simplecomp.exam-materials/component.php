<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;

if(!Loader::includeModule("iblock"))
{
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}

$this->AddIncludeAreaIcon(
    array(

        'URL'   => 'http://bx/bitrix/admin/iblock_element_admin.php?IBLOCK_ID=1&type=news&lang=ru&apply_filter=Y&back_url_pub=%2F',

        'TITLE' => "ИБ в админке",
				"IN_PARAMS_MENU" => true, //показать в контекстном меню
    )
);


$count=0;
if(intval($arParams["PRODUCTS_IBLOCK_ID"]) > 0)
{
			if($USER->GetID())
			{
				if ($this->StartResultCache())
				{
						$arResult= array();
						// user
						global $USER;
						$group_user="";
						$filter = Array("ID" => $USER->GetID());
						$rsUsers = CUser::GetList(($by = "NAME"), ($order = "desc"), $filter, array("SELECT"=>array("UF_NEWS_LINK")));
						while ($arUser = $rsUsers->GetNext()) {
							if($arUser["UF_NEWS_LINK"])
							  $group_user=$arUser["UF_NEWS_LINK"];
						}
						$user= array();
						$filter = Array("UF_NEWS_LINK" => $group_user);
						$rsUsers = CUser::GetList(($by = "NAME"), ($order = "desc"), $filter);
						while ($arUser = $rsUsers->GetNext()) {
							if($arUser["ID"]!=$USER->GetID())
							{
									$arResult[$arUser["ID"]]["ID"]=$arUser["ID"];
								  $arResult[$arUser["ID"]]["NAME"]=$arUser["LOGIN"];
							}
							$user[]=$arUser["ID"];
					}
						$new=array();
						$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM", "PROPERTY_AUTHOR");
						$arFilter = Array("IBLOCK_ID"=>$arParams["PRODUCTS_IBLOCK_ID"], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "PROPERTY_AUTHOR"=>$user);
						$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);
						while($ob = $res->GetNext())
						{

								$new[$ob["ID"]]["NAME"]=$ob["NAME"];
								$new[$ob["ID"]]["ID"]=$ob["ID"];
								$new[$ob["ID"]]["PROPERTY_AUTHOR"][]=$ob["PROPERTY_AUTHOR_VALUE"];

						}

						foreach ($new as $key => $value)
						 {
								if(!in_array($USER->GetID(),$value["PROPERTY_AUTHOR"]) )
								{
									foreach ($value["PROPERTY_AUTHOR"] as $key => $news) {
										$arResult[$news]["NEWS"][]=$value["NAME"];
										$count++;
									}
								}
						}
						$APPLICATION->SetTitle("Новостей ".$count);
						$this->includeComponentTemplate();
				}
		}
}

?>
