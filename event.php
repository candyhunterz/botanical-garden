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
  -->
  </script>

<?php
  /* Function to convert $old_date from a comma-separated string of dates in format mm/dd/yyyy to */
  /* an array of dates in format weekday, month dd, YYYY (called datest, or dates_text).  */
  /* Intermediate form is an array of datesd, or dates_digits, in format mm/dd/yyyy. */

  function convertDate($old_date, &$datest)
  {
    list($datesd[0], $datesd[1], $datesd[2], $datesd[3], $datesd[4], $datesd[5], $datesd[6], $datesd[7], 
      $datesd[8], $datesd[9]) = sscanf($old_date, "%s %s %s %s %s %s %s %s %s %s"); 

    for ($i = 0; $i < 10; $i++)
    {
      if (strlen($datesd[$i]) > 0)
      {
        $count = sscanf($datesd[$i], "%d/%d/%d", $month_digit, $day_digit, $year_digit);
        if ($count == 3) 
        {
          $temp_date = strtotime("$month_digit/$day_digit/$year_digit");
          if ($temp_date == FALSE)
          {
            /* If it didn't convert, give up and return FALSE. */
            $datest[0] = $old_date;
            for ($j = 1; $j < 10; $j++) $datest[$j] = "";
            return;
          }
          else
          {
            /* If it converted to a valid date, then append it to the list of dates already parsed. */
            $datest[$i] = date("l, F j, Y", $temp_date);
          }
        }
        else
        {
          /* It didn't convert, so give up and return FALSE. */
          $datest[0] = $old_date;
          for ($j = 1; $j < 10; $j++) $datest[$j] = "";
          return;
        }
      }
    }
    return;
  }

  function printInformation()
  {
    global $name, $date, $startTime, $endTime, $description, $link_title, $link_address, $location, $cost; 
    global $picture1, $text1, $picture2, $text2, $picture3, $text3, $picture4, $text4, $picture5, $text5;
    global $event_found, $the_event, $result, $the_event_dates;

    /* If you find the event... */
/*     if ($event_found == TRUE)
    { */
      /* Print information. */
      printf("<br><br>\n");
      printf("<span class=\"purple_left\">$name</span><br><br>\n");
      printf("<span class=\"green_left\">Date: </span>");
	  
/*       for ($k = 0; $k < 10; $k++) 
      { */
	  printf("%s<br>", $date);
/*         if (count($the_event_dates[$k]) > 0)
          printf("%s<br>", $the_event_dates[$k]); */
      //}
      printf("<span class=\"green_left\">Time: </span>$startTime-$endTime<br>\n");
	  
      printf("<span class=\"green_left\">Location: </span>$location<br>\n");

      printf("<span class=\"green_left\">Description:</span><br><br>$description<br><br>\n");
      if (strlen($the_event[$link_title]) > 0)
        printf("<a class=\"inline\" href=\"$the_event[$link_address]\" onClick=\"this.blur\(\)\">$the_event[$link_title]</a>\n");
      printf("<br><br>\n");

      if (strlen($the_event[$picture1]) > 0)
      {
        printf("<span class=\"green_left\">Photographs</span>\n");
        printf("<br><br>\n");
        printf("<div align=\"center\">\n");
        printf("<img border=\"0\" src=\"images/$the_event[$picture1]\" alt=\"\">\n");
        printf("<br>$the_event[$text1]<br><br><br>");

        if (strlen($the_event[$picture2]) > 0)
        {
          printf("<img border=\"0\" src=\"images/$the_event[$picture2]\" alt=\"\">\n");
          printf("<br>$the_event[$text2]<br><br><br>");
        }
        if (strlen($the_event[$picture3]) > 0)
        {
          printf("<img border=\"0\" src=\"images/$the_event[$picture3]\" alt=\"\">\n");
          printf("<br>$the_event[$text3]<br><br><br>");
        }
        if (strlen($the_event[$picture4]) > 0)
        {
          printf("<img border=\"0\" src=\"images/$the_event[$picture4]\" alt=\"\">\n");
          printf("<br>$the_event[$text4]<br><br><br>");
        }
        if (strlen($the_event[$picture5]) > 0)
        {
          printf("<img border=\"0\" src=\"images/$the_event[$picture5]\" alt=\"\">\n");
          printf("<br>$the_event[$text5]<br><br><br>");
        }
        printf("</div>\n");
      }

  }
  
  
  
  if (!isset($calendarfeed)) {$calendarfeed = "https://www.google.com/calendar/feeds/scbotsoc%40gmail.com/public/basic";}

	// Date format you want your details to appear
	$dateformat="j F Y"; // 10 March 2009 - see http://www.php.net/date for details
	$timeformat="g.ia"; // 12.15am

	// The timezone that your user/venue is in (i.e. the time you're entering stuff in Google Calendar.) http://www.php.net/manual/en/timezones.php has a full list
	date_default_timezone_set('America/Vancouver');

	// ...and how many you want to display (leave at 999 for everything)
	$items_to_show=999;

	// Form the XML address.
	$futureparam = $_GET['future'];

	if ($futureparam == "false"){
		$today = date('Y-m-d');
		$calendar_xml_address = str_replace("/basic","/full?singleevents=true&max-results=999&start-max=".$today."&orderby=starttime&sortorder=a",$calendarfeed);
	}
	else {
		$calendar_xml_address = str_replace("/basic","/full?singleevents=true&futureevents=true&max-results".$items_to_show."&orderby=starttime&sortorder=a",$calendarfeed); //This goes and gets future events in your feed.
	}
	$xml = simplexml_load_file($calendar_xml_address);
	$xml->asXML();

	foreach ($xml->entry as $entry){
		$ns_gd = $entry->children('http://schemas.google.com/g/2005');
		echo $entry;

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
		$events['location'] = $ns_gd->where->attributes()->valueString;
		$events['description'] = $entry->content;
		
		$link = $entry->link->attributes()->href;
		$link = substr($link, 42);

		$events['link'] = $link;
		$allEvents[] = $events;
	}
	
	/* Find out what event to display information on by parsing URL.  */
  $event_id = $_GET['eventId'];
  //echo $event_id;
  foreach ($allEvents as $e){
	if ($e['link'] == $event_id){
		$event = $e;
		break;
	}
  }
  //echo $event['title'];
  //global $name, $time, $description, $link_title, $link_address, $location, $cost;
  $name = $event['title'];
  $date = $event['time']['startDate'];
  $startTime = $event['time']['startTime'];
  $endTime = $event['time']['endTime'];
  $location = $event['location'];
  $description = $event['description'];
  
  $the_event_dates[] = array();
  array_push($the_event_dates, $event['time']['startDate']);
  
  
  
  /* Find event in database using event id. */
  /* $event_found = FALSE;
  while ($the_event = mysql_fetch_row($result))
  {
    if ($the_event[$id] == $event_id)
    {
      $event_found = TRUE;
      break;
    }
  } */

  /* If you find the event... */
 /*  $the_event_dates = array('', '', '', '', '', '', '', '', '', '', '');
  if ($event_found == TRUE)
  { */
    /* Convert dates. */
/*     convertDate($the_event[$date], $the_event_dates);
  }
 */
?>

</head>

<body onLoad="load_function()">

<div id="page_narrow">

  <br class="clearboth">

  <img class="image_centered" src="images/scbgs_logo.gif" width="494" height="99" 
    alt="Sunshine Coast Botanical Garden Society">

  <div id="single_col_narrow">
    <?php 
	  //include 'test2.php';
      printInformation();
    ?>
  </div>

  <div class="spacer">&nbsp;</div>
  <br class="clearboth">
</div>

<?php
  include "footer_narrow.html";
?> 

</body>
</html>

