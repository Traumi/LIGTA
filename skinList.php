<?php
    require_once("parts/init.php");

    $result = file_get_contents('./ddragon/'.$version.'/data/en_US/champion.json');
    $champions = json_decode($result,true);
    $res = null;

    if(isset($_GET["champ"])){
        $champ = $_GET["champ"];
        foreach($champions["data"] as $key => $champion ){
            if(strtolower($champ) == strtolower($champion["name"])){
                $id = $champion["id"];
            }
        }
        if(isset($id)){
            $result = file_get_contents('./ddragon/'.$version.'/data/en_US/champion/'.$id.'.json');
            $res = json_decode($result,true);
        }

        if($res == null){
            echo "error";
        }else{
            $aff = "[";
            foreach($res["data"][$id]["skins"] as $key => $value){
                //var_dump($value["num"]);
                $aff .= '{"name":"'.$value["name"].'","num":"'.$value["num"].'"},';
            }
            $aff = rtrim($aff,',');
            $aff .= "]";
            echo $aff;
        }
    }else{
        echo "error";
    }

    

    //var_dump($champions["data"]["MasterYi"]);


?>