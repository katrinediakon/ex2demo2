<?php
AddEventHandler("main", "OnBuildGlobalMenu", "MyOnBuildGlobalMenu");
function MyOnBuildGlobalMenu(&$aGlobalMenu, &$aModuleMenu)
{

  global $USER;
  $arGroups = CUser::GetUserGroup($USER->GetID());
  if (in_array("5", $arGroups))
  {
    unset($aGlobalMenu["global_menu_desktop"]);
    unset($aGlobalMenu["global_menu_services"]);
    unset($aGlobalMenu["global_menu_marketplace"]);
    unset($aGlobalMenu["global_menu_settings"]);
    foreach ($aModuleMenu as $key => $value) {
      if($value["parent_menu"]=="global_menu_content")
      {
        $aModuleMenu=array();
        $aModuleMenu[]=$value;
        break;
      }
    }
  }


}

 ?>
