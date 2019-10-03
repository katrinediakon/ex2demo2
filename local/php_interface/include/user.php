<?php

AddEventHandler("main", "OnBeforeUserUpdate", Array("MyCUser", "OnBeforeUserUpdateHandler"));

class MyCUser
{
 function OnBeforeUserUpdateHandler(&$arFields)
    {
      $arGroupsBefore=array();
        //Список групп пользователя после изменения
        $arGroupsAfter=array();

        $arGroupsBefore = CUser::GetUserGroup($arFields["ID"]);

        foreach($arFields["GROUP_ID"] as $aGroup){
            $arGroupsAfter[]=$aGroup["GROUP_ID"];
        }

        //Если до изменения не было группы контент-менеджеров, а после изменения есть
        if((!in_array("5", $arGroupsBefore)) && (in_array("5", $arGroupsAfter))){

            //Получаем ID всех пользователей группы
            //$arContentUsers = CGroup::GetGroupUser(CONTENT_GID);

            //Получаем список электронных адресов и отправляем письма
            $DBUsers=CUser::GetList(($by="id"), ($order="asc"), array("GROUPS_ID" => CONTENT_GID), array("FIELDS" => array("NAME", "LAST_NAME", "EMAIL")));

            while ($arUser = $DBUsers->Fetch())
            {
                //Формируем поля для отправки
                $aSendFields=array(
                    "TEXT" =>"Новый редактор ",
                    "MEMBER_EMAIL" => $arUser["EMAIL"],
                    "MEMBER_NAME" => $arUser["NAME"]." ".$arUser["LAST_NAME"],
                    "NEW_NAME" => $arFields["NAME"]." ".$arFields["LAST_NAME"],
                );

               CEvent::Send("NEW_CONTENT_USER", "s1", $arSendFields);
            }
        }

    }
}

 ?>
