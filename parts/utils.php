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

?>