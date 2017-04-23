<?php
  function svgInject($image) {
    $svg = SITE_PATH."images/".$image.".svg";
    echo (file_exists($svg)) ? file_get_contents($svg) : "";
  }

  function get_artists_by_event($event_id) {
    global $database;
    $result = $database->query("SELECT DISTINCT artists.artist_id, artists.artist_name, artists.mail_city, artists.mail_state, artists.artist_website, artists.web_display, artist_events.web_display AS event_display FROM artists JOIN artist_events ON artists.artist_id = artist_events.artist_id WHERE artist_events.event_id = ".$event_id);
    return $result;
  }

  function get_schedule_by_artist($artist_id) {
    global $database;
      $result = $database->query("SELECT DISTINCT schedule.datetime_start, schedule.datetime_end FROM schedule WHERE schedule.artist_id = ".$artist_id);
    return $result;
  }

  function get_bands_by_day($day, $web_display, $ord, $dir) {
    global $database;
    $result = $database->query("SELECT DISTINCT schedule.artist_id, artists.artist_name, artists.artist_website, artists.mail_city, artists.mail_state, artist_events.web_display FROM schedule JOIN artists ON schedule.artist_id = artists.artist_id JOIN artist_events ON artists.artist_id = artist_events.artist_id WHERE schedule.event_id = 13 AND schedule.perform_date = '".$day."' AND artist_events.web_display = ".$web_display." AND artist_events.event_id = schedule.event_id ORDER BY ".$ord." ".$dir);
    return $result;
  }

  function get_faqs_by_cat($cat) {
    global $database;
    $result = $database->query("SELECT DISTINCT faq.category, faq.question, faq.answer FROM faq WHERE category = '".$cat."' AND event_id = ".EVENT_ID." ORDER BY faq_no");
    return $result;
  }

?>