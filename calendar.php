<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
  <title>Sunshine Coast Botanical Garden Society</title>

  <link rel="stylesheet" href="scbgs.css" type="text/css" title="default_style">
  <link rel="alternate stylesheet" href="scbgs_ie.css" type="text/css" title="alternate_style">
  <link rel="stylesheet" href="menubar_scbgs.css" type="text/css">
  <link rel="shortcut icon" href="favicon.ico?vn=1">

  <script src='menubar_functions.js' type="text/javascript"></script>
  <script src='general_functions.js' type="text/javascript"></script>

  <style type="text/css">
  
  .bubble .details .links a{ 
			display:none!important; 
		} 

	.bubble .details .links a:hover{ 
			display:none!important;
		}
		
		</style>
  
  <script type="text/javascript">
  <!--
  function use_style_sheet(title) {
    var i, element
    for (i = 0; (element = document.getElementsByTagName("link")[i]); i++) {
      if (element.getAttribute("rel").indexOf("style") != -1 && element.getAttribute("title")) 
      {
        element.disabled = true; // disable style sheet
        if(element.getAttribute("title") == title)
        element.disabled = false // enable chosen style sheet;
      }
    }
  }

  // If the browser in use is an old version (version 6 or older) of IE, use alternate style sheet.
  function load_function() {
    var ua = window.navigator.userAgent;
    var msie = ua.indexOf ( "MSIE " );

    if ( msie > 0 ) {
      if (parseInt (ua.substring (msie+5, ua.indexOf (".", msie ))) < 7) {
        use_style_sheet("alternate_style");
      }
    } 
  }
  -->
  </script>

  <script type="text/javascript">
  <!--
  function eventDetails(newContent) {
   winContent = window.open("event.php?eventId="+newContent, 'window2', 'right=0, top=20, width=760, height=350, menubar=yes, toolbar=yes, scrollbars=yes, resizable=yes');
   if (window.focus) {
      winContent.focus();
    }
  }
  -->
  </script>

</head>

<body onLoad="load_function()">

<div id="page">

<?php
  include "menu_submenus.html";
  include "banner_poppy.html";include "banner.html";
?> 
  <br class="clearboth">

  <div id="single_col">
    <img src="images/title_calendar.gif" width="420" height="32" alt="Events Calendar">
    <br><br>

   <div align="center" id="calendar">
	<iframe src="https://www.google.com/calendar/embed?showTitle=0&amp;showPrint=0&amp;showTabs=0&amp;showCalendars=0&amp;height=600&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=scbotsoc%40gmail.com&amp;color=%232952A3&amp;ctz=America%2FVancouver" style=" border-width:0 " width="100%" height="600" frameborder="0" scrolling="no"></iframe>
      </div>

      </div>
      <br><br>
    </td>
  </tr>

  <div class="spacer">&nbsp;</div>
  <br class="clearboth">
</div>

<?php
  include "footer.html";
?> 

</body>
</html>

