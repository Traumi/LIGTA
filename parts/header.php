<header>
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php" data-toggle="tooltip" data-placement="bottom" title="LoL Informations Gathering Technology Artefact">LIGTA<sup>V <?php echo $ver_log ?></sup></a><!--LoL Informations Gathering Technology Artefact-->
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li><form class="navbar-form navbar-right" action="profil.php" method="get">
          <div class="input-group">
            <input placeholder="<?php echo $translations['SEARCH_PLAYER'] ?>" name="pseudo" class="form-control" type="text">
            <div class="input-group-btn">
              <button class="btn btn-default" type="submit" style="">
                &nbsp;<i class="glyphicon glyphicon-search"></i>&nbsp;
              </button>
            </div>

          </div>
          <select class="form-control" name="reg" id="reg">
            <option value="euw1">EUW</option>
            <option value="eun1">EUNE</option>
            <option value="na1">NA</option>
          </select>
        </form></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><div class="navbar-form navbar-right">
          <select onchange="change_lang(this)" class="form-control" name="lang" id="lang">
            <option value="fr_FR">Français</option>
            <option value="de_DE" disabled>Deutsch</option>
            <option value="en_GB">English (GB)</option>
            <option value="en_US">English (US)</option>
            <option value="es_ES">Español</option>
          </select>
        </div></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <?php echo $translations["OPTIONS"] ?>
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li class="dropdown-header">Data Patch : <?php echo json_decode(file_get_contents('data/version.json'))->version; ?></li>
            <li role="separator" class="divider"></li>
            <li class="dropdown-header"><?php echo $translations["OPTIONS"] ?></li>
            <li><a href="index.php"><?php echo $translations["ACCUEIL"] ?></a></li>
            <li><a href="champ_list.php"><?php echo $translations["CHAMP_LIST"] ?></a></li>
            <li><a href="icon_builder.php">Icon Builder</a></li>
            <li><a href="ultimatebravery.php">Ultimate Bravery</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div style="height:50px;"></div>
<script>
      function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = "expires="+ d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
      }
      function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
      }
</script>
<script>
  function change_lang(a){
    setCookie("lang",a.value,7);
    location.reload();
  }

  if(getCookie("lang") != ""){
    console.log(getCookie("lang"));
    document.getElementById("lang").value = getCookie("lang");
  }

  if(getCookie("reg") != ""){
    console.log(getCookie("reg"));
    document.getElementById("reg").value = getCookie("reg");
  }
</script>
</header>