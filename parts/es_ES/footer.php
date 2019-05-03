<footer style="position:fixed;bottom:0;width:100%;background:#222;height:50px;text-align:right;padding-right:20px;padding-top:5px;border-top:solid #080808 1px;z-index:10;">
	<style>
        .switch {
          position: fixed;
          bottom:12px;
          right:25px;
          display: inline-block;
          width: 30px;
          height: 17px;
          margin-top:0px;
        }

        i.sun{
          color:white;
          bottom:12px;
          right:60px;
          position:fixed;
          font-style: normal;
          font-size:20px;
          font-weight:900;
        }

        i.moon{
          color:white;
          bottom:12px;
          right:7px;
          position:fixed;
          font-style: normal;
          font-size:20px;
          font-weight:900;
        }

        #copyright{
          color:#ccc;
          position:fixed;
          width:100%;
          text-align:center;
          bottom:12px;
          font-size: 16px;
        }

        .switch input { 
          opacity: 0;
          width: 0;
          height: 0;
        }

        .slider {
          position: absolute;
          cursor: pointer;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          background-color: #ccc;
          -webkit-transition: .4s;
          transition: .4s;
        }

        .slider:before {
          position: absolute;
          content: "";
          height: 13px;
          width: 13px;
          left: 2px;
          bottom: 2px;
          background-color: white;
          -webkit-transition: .4s;
          transition: .4s;
        }

        input:checked + .slider {
          background-color: #2196F3;
        }

        input:focus + .slider {
          box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
          -webkit-transform: translateX(13px);
          -ms-transform: translateX(13px);
          transform: translateX(13px);
        }

        /* Rounded sliders */
        .slider.round {
          border-radius: 17px;
        }

        .slider.round:before {
          border-radius: 50%;
        }
    </style>
    <!--<div style="color:white;">Mode sombre</div>-->
    <div id="copyright"><a href="patchnotes.php" target="_blank">Notas del parche del sitio web (Francés)</a> - © 2019 Todos los derechos reservados</div>
    <i class="sun">☼</i>
    <label class="switch">
        <input id="darkmode" onclick="toggleswitch(this)" type="checkbox">
        <span class="slider round"></span>
    </label>
    <i class="moon">☾</i>
    <script>
    	function toggleswitch(a){
    		//a.checked = !a.checked;
    		setCookie("dark",a.checked,7);
        if(a.checked){
          document.getElementsByTagName("body")[0].classList.add("dark");
        }else{
          document.getElementsByTagName("body")[0].classList.remove("dark");
        }
    		//alert(getCookie("dark"))
    	}

      if(getCookie("dark") == "true"){
        document.getElementById("darkmode").checked = true;
        document.getElementsByTagName("body")[0].classList.add("dark");
      }
    </script>
    
</footer>