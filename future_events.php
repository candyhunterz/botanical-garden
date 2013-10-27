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
  //-->
  </script>

  <script type="text/javascript">
  <!--
  function eventDetails(newContent) {
   winContent = window.open("event.php?eventId="+newContent+"&future=true", 'window2', 'right=0, top=20, width=760, height=350, menubar=yes, toolbar=yes, scrollbars=yes, resizable=yes');
   if (window.focus) {
      winContent.focus();
    }
  }
  -->
  </script>

<?php
// Your private feed - which you get by right-clicking the 'xml' button in the 'Private Address' section of 'Calendar Details'.
if (!isset($calendarfeed)) {$calendarfeed = "https://www.google.com/calendar/feeds/scbotsoc%40gmail.com/public/basic";}

// Date format you want your details to appear
$dateformat="j F Y"; // 10 March 2009 - see http://www.php.net/date for details
$timeformat="g.ia"; // 12.15am

// The timezone that your user/venue is in (i.e. the time you're entering stuff in Google Calendar.) http://www.php.net/manual/en/timezones.php has a full list
date_default_timezone_set('America/Vancouver');

// ...and how many you want to display (leave at 999 for everything)
$items_to_show=999;

// Form the XML address.
$calendar_xml_address = str_replace("/basic","/full?singleevents=true&futureevents=true&max-results".$items_to_show."&orderby=starttime&sortorder=a",$calendarfeed); //This goes and gets future events in your feed.

$xml = simplexml_load_file($calendar_xml_address);
$xml->asXML();

foreach ($xml->entry as $entry){
	$ns_gd = $entry->children('http://schemas.google.com/g/2005');

	// These are the dates we'll display
    $gCalDate = date($dateformat, strtotime($ns_gd->when->attributes()->startTime));
    $gCalDateStart = date($dateformat, strtotime($ns_gd->when->attributes()->startTime));
    $gCalDateEnd = date($dateformat, strtotime($ns_gd->when->attributes()->endTime));
    $gCalStartTime = date($timeformat, strtotime($ns_gd->when->attributes()->startTime));
    $gCalEndTime = date($timeformat, strtotime($ns_gd->when->attributes()->endTime));
	
	$events['title'] = $entry->title;
	$events['time'] = array(
		'currDate' => $gCalDate,
		'startDate' => $gCalDateStart,
		'endDate' => $gCalDateEnd,
		'startTime' => $gCalStartTime,
		'endTime' => $gCalEndTime);
	
	$link = $entry->link->attributes()->href;
	$link = substr($link, 42);

	$events['link'] = $link;
	$allEvents[] = $events;
}

foreach ($allEvents as $e){
	if (!isset($finalList[(string)$e['title']])) {
		$finalList[(string)$e['title']] = array();
	}
	array_push($finalList[(string)$e['title']], $e);
			
}

?>

</head>

<body onLoad="load_function()">

<div id="page_ferns">

  <?php
    include "menu_submenus.html";
    include "banner_poppy_and_iris.html"; include "banner.html";
  ?> 

  <br class="clearboth">

  <div id="single_col">
    <img id="event_list" src="images/title_upcoming_events.gif" width="420" height="32" alt="Upcoming SCBGS Events">
    <br><br>

    <?php 
	  $counter = count($finalList);
	  $today = getdate();
	  $current_year = $today["year"];
	  $current_month = $today["mon"];
	  $current_day = $today["mday"];
	  
	  if($_GET != null){
		$start = $_GET['start'];
		$boundary = $_GET['boundary'];
	  }
	  else{
		$boundary = 9;
		$start = 0;
	  }
	  
      if (count($allEvents) < 1)
      {
        printf("<br><br>There are currently no future events scheduled.  Please check back again soon.<br><br>\n");
      }
      else
      {
        printf("<br>For a description of each event, and photographs, click on the title of the event.<br><br>");

        /* If there is more than one page of items, display next/previous buttons... */
        if($counter > 10) {
          printf("<br>");
          /* Display next and/or previous buttons. */ 
          printf("<div align=\"center\"><table border=\"1\" cellspacing=\"0\" cellpadding=\"3px\"><tr>");
          if ($start >= 9) {
            printf("<td>");
            printf("<a class=\"next_previous\" href=\"future_events.php?boundary=".($boundary-10)."&start=".($start-10)."#event_list\">Previous 10 Events</a>");
            printf("</td>");
          }
          if ($start + 10 < $counter) {
          printf("<br><br>");
            printf("<td>");
            printf("<a class=\"next_previous\" href=\"future_events.php?boundary=".($boundary+10)."&start=".($start+10)."#event_list\">Next 10 Events</a>");
            printf("</td>");
          }
        printf("</tr></table></div>");
        }

        
		/* Display events. */
		$s = 0;
		foreach($finalList as $key => $value){
			if($s < $start){
				$s++;
				continue;
			}
			if ($s > $boundary) {
				break;
			}
			$eid = $value[0]['link'];
			print_r("<b><a class=\"inline\" onClick=\"this.blur\(\)\" href=\"javascript:eventDetails('$eid')\">".$key."</a></b><br>\n");
			foreach($value as $v){
				print_r($v['time']['startDate']."<br>");
			}
			$s++;
			print_r("<p></p>");
		}


        /* If there is more than one page of items, display next/previous buttons... */
        //if ($num_rows > 10) {
          //printf("<br><br>");
          /* Display next and/or previous buttons. */ 
         /* printf("<div align=\"center\">\n<table border=\"1\" cellspacing=\"0\" cellpadding=\"3px\"><tr>");
          if ($start > $boundary) {
            printf("<td>");
            printf("<a class=\"next_previous\" href=\"future_events.php?boundary=".($boundary)."&start=".($start-10)."#event_list\">Previous 10 Events</a>");
            printf("</td>");
          }
          if ( $start + 10 < $num_rows) {
            printf("<br><br>");
            printf("<td>");
            printf("<a class=\"next_previous\" href=\"future_events.php?boundary=".($boundary)."&start=".($start+10)."#event_list\">Next 10 Events</a>");
            printf("</td>");
          }
        printf("</tr></table></div>");
        }*/
      }
    ?>

    <br>

  </div>

  <div class="spacer">&nbsp;</div>
  <br class="clearboth">
</div>

<?php
  include "footer.html";
?> 

</body>
</html>

