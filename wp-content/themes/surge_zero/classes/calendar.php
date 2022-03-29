<?php

  namespace KNE\Booking;
  class DateTime extends \DateTime{};
  class DateTimeImmutable extends \DateTimeImmutable{};

  class Calendar {

    public $start_date;

    public $end_date;


    function drawMonthCalendar ($date, $custom_class = null) {

      $query_date = (!$date) ? new DateTimeImmutable('now') : new DateTimeImmutable($date) ;

      $first_day_of_month = $query_date->modify('first day of this month');

      $current_date = new DateTimeImmutable('now');

      $day_of_first_day = $first_day_of_month->format('N');
      //check if monday
      if($day_of_first_day=='1'){
        $calendar_start_date = $first_day_of_month;
      } else {
        $calendar_start_date = $first_day_of_month->modify('last monday');
      }
      $this->start_date = $calendar_start_date;

      //construct previous and next urls
      $next_query = $_GET;
      $prev_query = $_GET;
      // replace parameter(s)
      $next_query['query_date'] = $query_date->modify('first day of next month')->format('Y-m-d');
      $prev_query['query_date'] = $query_date->modify('first day of last month')->format('Y-m-d');
      // rebuild url
      $current_uri = explode('?', $_SERVER['REQUEST_URI'])[0];
      $next_query_result = http_build_query($next_query);
      $prev_query_result = http_build_query($prev_query);

      //draw calendar boxes
      $calendar_map = array();
      echo '<div class="calendar_cont '.$custom_class.'">';
      echo '<div class="calendar_header">';
      echo '<a href="'.$current_uri.'?'.$prev_query_result.'" class="prev_month">&lt;&lt;Prev</a>';
      echo '<h2 class="month_name">'.$query_date->format('F Y').'</h2>';
      echo '<a href="'.$current_uri.'?'.$next_query_result.'" class="next_month">Next&gt;&gt;</a>';
      echo '</div>';
      echo '<div class="calendar month">';
      //days row
      echo '<div class="day_header" style="style="grid-row: 1 / span 1; grid-column: 1 / span 1;" >Mon</div>';
      echo '<div class="day_header" style="style="grid-row: 1 / span 1; grid-column: 2 / span 1;" >Tue</div>';
      echo '<div class="day_header" style="style="grid-row: 1 / span 1; grid-column: 3 / span 1;" >Wed</div>';
      echo '<div class="day_header" style="style="grid-row: 1 / span 1; grid-column: 4 / span 1;" >Thu</div>';
      echo '<div class="day_header" style="style="grid-row: 1 / span 1; grid-column: 5 / span 1;" >Fri</div>';
      echo '<div class="day_header" style="style="grid-row: 1 / span 1; grid-column: 6 / span 1;" >Sat</div>';
      echo '<div class="day_header" style="style="grid-row: 1 / span 1; grid-column: 7 / span 1;" >Sun</div>';
      //loop through 42 days from start
      for($x = 0; $x<42; $x++){
        //row and column
        $row = ceil(($x+1)/7) + 1;
        $column = ($x+1) - (7 * ($row-2));
        $this_date = $calendar_start_date->modify('+'.$x.' days');
        $this->end_date = $this_date;
        $formatted_date = $this_date->format('Y-m-d');
        $today_class = ( $this_date->format('Y-m-d') == $current_date->format('Y-m-d')) ? 'today' : '' ;
        $past_day_class = ($this_date->format('Y-m-d') < $current_date->format('Y-m-d')) ? 'past_day' : '' ;
        $this_month_class = ($this_date->format('n') == $query_date->format('n')) ? 'current_month' : 'not_this_month' ;
        //generate date link
        $day_link = $this->setDayViewLink( $this_date );

        echo '<div id="'.$this_date->format('Y-m-d').'" class="day '.$this_month_class.' '.$past_day_class.' '.$today_class.'" style="grid-row: '.$row.' / span 1; grid-column: '.$column.' / span 1;" data-date="'.$this_date->format('Y-m-d').'">';
        echo '<a href="'.$day_link.'">';
        echo $this_date->format('j');
        echo '</a>';
        echo '</div>';
      }

      echo '</div>';
      echo '</div>';//end calendar

    }


    function drawDayCalendar ($date, $start, $end, $period, $tracks, $mini_calendar) {
      $query_date = (!$date) ? new DateTimeImmutable('now') : new DateTimeImmutable($date) ;
      $this->start_date = $query_date;
      $this->end_date = $query_date;

      //construct previous and next urls
      $next_query = $_GET;
      $prev_query = $_GET;
      // replace parameter(s)
      $next_query['query_date'] = $query_date->modify('+1 days')->format('Y-m-d');
      $prev_query['query_date'] = $query_date->modify('-1 days')->format('Y-m-d');
      // rebuild url
      $current_uri = explode('?', $_SERVER['REQUEST_URI'])[0];
      $next_query_result = http_build_query($next_query);
      $prev_query_result = http_build_query($prev_query);

      //construct times array
      $start_time = DateTimeImmutable::createFromFormat('Y-m-d Hi', $query_date->format('Y-m-d').' '.$start);
      $end_time = DateTimeImmutable::createFromFormat('Y-m-d Hi', $query_date->format('Y-m-d').' '.$end);
      $schedule_times = array();
      //grid template rows
      $grid_row_template_string = '[trackname] minmax(2rem, 1fr) ';
      for ($time = $start_time; $time <= $end_time; $time = $time->modify('+'.$period.'minutes')) {
        array_push($schedule_times, $time);
        $formatted_time = $time->format('Gi');
        $grid_row_template_string.= '[row'.$formatted_time.'] minmax(2rem, 1fr) ';
      }
      //grid template columns
      $grid_col_template_string = '[times] 3.5rem [main] minmax(14rem, 24rem) ';
      foreach($tracks['other_tracks'] as $other_track_id){
        $grid_col_template_string.='[colEvent'.$other_track_id.'] minmax(14rem, 24rem) ';
      }

      echo '<div class="schedule_cont">';
      //header
      echo '<div class="day_header">';
      echo '<a href="'.$current_uri.'?'.$prev_query_result.'" class="prev_day">&lt;&lt;Prev</a>';
      echo '<h2>'.$query_date->format('l jS F, Y').'</h2>';
      echo '<a href="'.$current_uri.'?'.$next_query_result.'" class="next_day">Next&gt;&gt;</a>';
      echo '</div>';

      //include thrity minutes notice
      get_template_part('/templates/thirty-minutes-notice', 'small');

      //schedule
      echo '<div id="schedule" class="schedule" style="grid-template-rows: '.$grid_row_template_string.'; grid-template-columns: '.$grid_col_template_string.'">';
      //add times
      foreach ($schedule_times as $time) {
        $formatted_time = $time->format('Gi');
        $display_time = $time->format('H:i');
        //check if on hour
        $time_class = ($formatted_time % 100 == 0) ? 'hour' : '' ;
        echo '<div class="time '.$time_class.' '.$formatted_time.'" style="grid-row: row'.$formatted_time.' / span 1">';
        echo '<h4>'.$display_time.'</h4>';
        echo '</div>';
      }
      //add tracknames - only main track, others added by js
      $column = 3;
      //main track
      $main_track_id = $tracks['main'];
      echo '<h4 style="grid-row: trackname / span 1; grid-column: 2 / span 1 ">'.$tracks['track_info'][$main_track_id]['track_name'].'</h4>';

      echo '</div>'; //close schedule
      echo '</div>'; //close cont
    }

    function setDayViewLink ( $this_date ) {
      //construct previous and next urls
      $params = $_GET;
      // replace parameter(s)
      $params['query_date'] = $this_date->format('Y-m-d');
      $params['view'] = 'day';
      // rebuild url
      $current_uri = explode('?', $_SERVER['REQUEST_URI'])[0];
      $date_link = $current_uri . '?' . http_build_query($params);

      return $date_link;

    }
  }

?>
