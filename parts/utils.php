<?php

    function create_banner($champion){
        switch($champion){

            default :
                echo '<image xlink:href="ddragon/img/champion/splash/'.$champion.'_0.jpg" x="0" y="-10%" width="100%"/>';
                break;
        }
    }
    
    function getQueueType($number){
        $sr = [2,4,6,14,42,61,400,410,420,430,440,700];
        $tt = [8,9,41,460,470];
        $ha = [65,100,450];
        $rotation = [16,17,70,72,73,75,76,78,83,91,92,93,96,98,300,310,313,315,317,318,325,600,610,900,910,920,940,950,960,980,990,1000,1010,1020,1030,1040,1050,1060,1070,1200];
        $ai = [7,25,31,32,33,52,800,810,820,830,840,850];

        if(in_array($number,$sr)) return "SR";
        if(in_array($number,$tt)) return "TT";
        if(in_array($number,$ha)) return "HA";
        if(in_array($number,$ai)) return "AI";
        if(in_array($number,$rotation)) return "RO";
        return "";
    }

    function isSRGame($number){
        $true = [2,4,6,14,42,61,400,410,420,430,440,700];
        return in_array($number,$true);
    }

    function imgToBase64($path){
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $imgdata = file_get_contents($path);
        return 'data:image/' . $type . ';base64,' . base64_encode($imgdata);
    }

    //https://www.commentcamarche.net/contents/489-caracteres-speciaux-html
    function cleanWord($pseudo){
        $pseudo = str_replace("ÿ","&#255;",$pseudo);
        $pseudo = str_replace("þ","&#254;",$pseudo);
        $pseudo = str_replace("ý","&#253;",$pseudo);
        $pseudo = str_replace("ü","&#252;",$pseudo);
        $pseudo = str_replace("û","&#251;",$pseudo);
        $pseudo = str_replace("û","&#251;",$pseudo);
        $pseudo = str_replace("ú","&#250;",$pseudo);
        $pseudo = str_replace("ù","&#249;",$pseudo);
        $pseudo = str_replace("ø","&#248;",$pseudo);
        $pseudo = str_replace("÷","&#247;",$pseudo);
        $pseudo = str_replace("ö","&#246;",$pseudo);
        $pseudo = str_replace("õ","&#245;",$pseudo);
        $pseudo = str_replace("ô","&#244;",$pseudo);
        $pseudo = str_replace("ó","&#243;",$pseudo);
        $pseudo = str_replace("ò","&#242;",$pseudo);
        $pseudo = str_replace("ñ","&#241;",$pseudo);
        $pseudo = str_replace("ð","&#240;",$pseudo);
        $pseudo = str_replace("ï","&#239;",$pseudo);
        $pseudo = str_replace("î","&#238;",$pseudo);
        $pseudo = str_replace("í","&#237;",$pseudo);
        $pseudo = str_replace("ì","&#236;",$pseudo);
        $pseudo = str_replace("ë","&#235;",$pseudo);
        $pseudo = str_replace("ê","&#234;",$pseudo);
        $pseudo = str_replace("é","&#233;",$pseudo);
        $pseudo = str_replace("è","&#232;",$pseudo);
        $pseudo = str_replace("ç","&#231;",$pseudo);
        $pseudo = str_replace("æ","&#230;",$pseudo);
        $pseudo = str_replace("å","&#229;",$pseudo);
        $pseudo = str_replace("ä","&#228;",$pseudo);
        $pseudo = str_replace("ã","&#227;",$pseudo);
        $pseudo = str_replace("â","&#226;",$pseudo);
        $pseudo = str_replace("á","&#225;",$pseudo);
        $pseudo = str_replace("à","&#224;",$pseudo);
        $pseudo = str_replace("ß","&#223;",$pseudo);
        $pseudo = str_replace("Þ","&#222;",$pseudo);
        $pseudo = str_replace("Ý","&#221;",$pseudo);
        $pseudo = str_replace("Ü","&#220;",$pseudo);
        $pseudo = str_replace("Û","&#219;",$pseudo);
        $pseudo = str_replace("Ú","&#218;",$pseudo);
        $pseudo = str_replace("Ù","&#217;",$pseudo);
        $pseudo = str_replace("Ø","&#216;",$pseudo);
        $pseudo = str_replace("×","&#215;",$pseudo);
        $pseudo = str_replace("Ö","&#214;",$pseudo);
        $pseudo = str_replace("Õ","&#213;",$pseudo);
        $pseudo = str_replace("Ô","&#212;",$pseudo);
        $pseudo = str_replace("Ó","&#211;",$pseudo);
        $pseudo = str_replace("Ò","&#210;",$pseudo);
        $pseudo = str_replace("Ñ","&#209;",$pseudo);
        $pseudo = str_replace("Ð","&#208;",$pseudo);
        $pseudo = str_replace("Ï","&#207;",$pseudo);
        $pseudo = str_replace("Î","&#206;",$pseudo);
        $pseudo = str_replace("Í","&#205;",$pseudo);
        $pseudo = str_replace("Ì","&#204;",$pseudo);
        $pseudo = str_replace("Ë","&#203;",$pseudo);
        $pseudo = str_replace("Ê","&#202;",$pseudo);
        $pseudo = str_replace("É","&#201;",$pseudo);
        $pseudo = str_replace("È","&#200;",$pseudo);
        $pseudo = str_replace("Ç","&#199;",$pseudo);
        $pseudo = str_replace("Æ","&#198;",$pseudo);
        $pseudo = str_replace("Å","&#197;",$pseudo);
        $pseudo = str_replace("Ä","&#196;",$pseudo);
        $pseudo = str_replace("Ã","&#195;",$pseudo);
        $pseudo = str_replace("Â","&#194;",$pseudo);
        $pseudo = str_replace("Á","&#193;",$pseudo);
        $pseudo = str_replace("À","&#192;",$pseudo);
        $pseudo = str_replace("¿","&#191;",$pseudo);
        $pseudo = str_replace("¾","&#190;",$pseudo);

        return $pseudo;
    }

?>