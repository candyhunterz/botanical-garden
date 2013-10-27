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
   winContent = window.open("event.php?eventId="+newContent+"&future=false", 'window2', 'right=0, top=20, width=760, height=350, menubar=yes, toolbar=yes, scrollbars=yes, resizable=yes');
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
$today = date('Y-m-d');
$calendar_xml_address = str_replace("/basic","/full?singleevents=true&max-results=999&start-max=".$today."&orderby=starttime&sortorder=a",$calendarfeed); //This goes and gets future events in your feed.

$xml = simplexml_load_file($calendar_xml_address);
$xml->asXML();

foreach ($xml->entry as $entry){
	$ns_gd = $entry->children('http://schemas.google.com/g/2005');

	// These are the dates we'll display
    $gCalDate = date($dateformat, strtotime($ns_gd->when->attributes()->startTime));
    $gCalDateStart = date($dateformat, strtotime($ns_gd->when->attributes()->startTime));
    $gCalDateEnd = date($dateformat, strtotime($ns_gd->when->attributes()->endTime));

	$events['title'] = $entry->title;
	$events['time'] = array(
		'currDate' => $gCalDate,
		'startDate' => $gCalDateStart,
		'endDate' => $gCalDateEnd);
	
	$link = $entry->link->attributes()->href;
	$link = substr($link, 42);
	$events['link'] = $link;
	$allEvents[] = $events;
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
	  $counter = count($allEvents);
	  $today = getdate();
	  $current_year = $today["year"];
	  $current_month = $today["mon"];
	  $current_day = $today["mday"];
	  
	  /* Identify which year to display. */
      if (isset($_GET['year']))
      {
        /* Visitor has used next/previous year to get to this page. */
        $this_year = $_GET['year'];
        if ($this_year < 2003) $this_year = 2003;
        if ($this_year > $current_year) $this_year = $current_year;
      }
      else
      {
        /* Visitor has just entered events page.  Use today's date to decide what year to show.*/
        $this_year = $current_year;
      }

      /* Identify previous and next year. */
      $previous_year_2 = $this_year - 2;
      $previous_year = $this_year - 1;
      $next_year = $this_year + 1;
      $next_year_2 = $this_year + 2;
      /* Display next and previous buttons. */
      echo "<div style=\"text-align: center;\">";

        /* Display title and next/previous links. */
        if ($previous_year_2 >= 2003)
        {
          echo "<a class=\"inline\" href=\"past_events.php?year=$previous_year_2#calendar\">";
          echo $previous_year_2;
          echo "</a>";
        }

        if ($previous_year >= 2003)
        {
          echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          echo "<a class=\"inline\" href=\"past_events.php?year=$previous_year#calendar\">";
          echo $previous_year;
          echo "</a>";
        }
  
        echo "<span class=\"month\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo $this_year;
        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>";
  
        /* Don't display future years. */
        if ($next_year <= $current_year)
        {
          echo "<a class=\"inline\" href=\"past_events.php?year=$next_year#calendar\">";
          echo $next_year;
          echo "</a>";
        }

        if ($next_year_2 <= $current_year)
        {
          echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          echo "<a class=\"inline\" href=\"past_events.php?year=$next_year_2#calendar\">";
          echo $next_year_2;
          echo "</a>";
        }

        echo "<br><br>";
      echo "</div>";
	  
	  
	  foreach ($allEvents as $e){
		$parts = explode(' ', $e['time']['startDate']);
		if($parts[2] > $this_year){
			break;
		}
		if ($parts[2] == $this_year){
			if (!isset($currYear[(string)$e['title']])) {
				$currYear[(string)$e['title']] = array();
			}
			array_push($currYear[(string)$e['title']], $e);
		}
	  }
      /* List all events that happened during this year . Just look at the first day of the event, not all days, */
      /* so that we only list each event once. For each item in the array $data... */

        /* Display events. */
	foreach($currYear as $key => $value){
		$eid = $value[0]['link'];
		print_r("<b><a class=\"inline\" onClick=\"this.blur\(\)\" href=\"javascript:eventDetails('$eid')\">".$key."</a></b><br>\n");
		foreach($value as $v){
			print_r($v['time']['startDate']."<br>");
		}
		
		print_r("<p></p>");
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

