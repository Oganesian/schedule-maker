<?php

include_once 'src/php/sql.php';

if(isset($_POST["submitMonth"])){
  $year = substr($_POST["month"], 0, 4);
  $month = substr($_POST["month"], 5, 7);
  $id = $_POST["passenger"];

  // INITIALIZATIONS
  $meeting_days = getMeetingDays($year, $month);
  $passengers = getPassengers($year, $month, $meeting_days, $id);

/*
foreach($meeting_days as $day){
  echo $day->format('Y-m-d').", ";
}
echo "\n";

 foreach($passengers as $passenger){
    echo "id: ".$passenger["id"]."\n";
    echo "phone: ".$passenger["phone"]."\n";
    echo "email: ".$passenger["email"]."\n";
    echo "address: ".$passenger["address"]."\n";
    echo "dates: ";
    foreach($passenger["dates"] as $date){
      echo $date->format('Y-m-d').", ";
    }
    echo "\n";
  }*/
  createScheduleForAMonth($meeting_days, $passengers);
}

function createScheduleForAMonth($meeting_days, $passengers){
  foreach($meeting_days as $meeting_day){
    foreach($passengers as $passenger){
      while($passenger["places_need"] > 0){
        $drivers = my_query("SELECT id_publisher FROM who_takes_whom WHERE id_passenger = '{$passenger['id']}' AND active = '1' ORDER BY last_drive_date ASC", true);
        if($drivers->num_rows > 0) {
          $driver = $drivers->fetch_assoc();
          $places_in_car_sql = my_query("SELECT places_in_car FROM publishers WHERE id_publisher = '{$driver['id_publisher']}'", true);
          $places_in_car_row = $places_in_car_sql->fetch_assoc();
          $temp_query = "SELECT * FROM days_when_publisher_cant_drive WHERE day='{$meeting_day->format('Y-m-d')}' AND id_publisher = '{$driver["id_publisher"]}' AND type = 0";
          $temp = my_query($temp_query, true);
          $type_num = 0;
          if($temp->num_rows > 0) {
            $type = $temp->fetch_assoc();
            $type_num = $type["type"];
          }
          if(!$temp || !$temp->num_rows) {
            $passenger["places_need"] -= $places_in_car_row["places_in_car"];
            $id_publisher = $driver["id_publisher"];
            $id_passenger = $passenger["id"];
            $meeting_day_str = $meeting_day->format('Y-m-d');
            my_query("UPDATE who_takes_whom SET last_drive_date = '{$meeting_day_str}' WHERE id_publisher = '{$id_publisher}' AND id_passenger = '{$id_passenger}'", false);
            my_query("INSERT INTO fahrplan VALUES('$id_publisher', '$id_passenger', '$meeting_day_str', '$type_num')", false);
          } else {
            break 1;
          }
        }
      }
    }
  }
}

function getPassengers($year, $month, $meeting_days, $id){
  if($id == -1){
    $query = "SELECT * FROM passengers";
  } else {
    $query = "SELECT * FROM passengers WHERE id_passenger = '{$id}'";
  }
  $passengers_result = my_query($query, true);
  $passengers = array();
  $index = 0;
  while ($line = $passengers_result->fetch_assoc()) {
    $dates = getPassengerDays($line["id_passenger"], $year, $month, $meeting_days);
    $passengers[$index++] = array("id" => $line["id_passenger"],
                                  "name" => $line["passenger"],
                                  "phone" => $line["phone"],
                                  "address" => $line["address"],
                                  "email" => $line["email"],
                                  "places_need" => $line["places_need"],
                                  "dates" => $dates);
  }
  return $passengers;
}

function getMeetingDays($year, $month){
  $meeting_days = my_query("SELECT * FROM meeting_days", true);
  $meeting_days_row = $meeting_days->fetch_assoc();
  $weekday = $meeting_days_row["weekday"];
  $weekend = $meeting_days_row["weekend"];
  $weekday = myParseDayToEN($weekday);
  $weekend = myParseDayToEN($weekend);

  $all_weekdays_in_a_month = getAllDaysInAMonth($year, $month, $weekday);
  $all_weekends_in_a_month = getAllDaysInAMonth($year, $month, $weekend);

  $all_meeting_days_in_a_month = array_merge($all_weekdays_in_a_month, $all_weekends_in_a_month);

  usort($all_meeting_days_in_a_month, "date_sort");
  return removeNoMeetingDays($all_meeting_days_in_a_month, $year, $month);
}

function date_sort($a, $b) {
  if ($a == $b) {
    return 0;
  }
  return $a < $b ? -1 : 1;
}

function getPassengerDays($id, $year, $month, $meeting_days){
  $passenger_doesnt_need =
    my_query("SELECT * FROM days_when_passenger_doesnt_need WHERE MONTH(day) = {$month} AND YEAR(day) = {$year} AND id_passenger = {$id}", true);
  $days = array();
  $index = 0;
  while($passenger_doesnt_need_days = $passenger_doesnt_need->fetch_assoc()){
    $days[$index++] = new \DateTime($passenger_doesnt_need_days["day"]);
  }
  foreach ($days as $day) {
    if (($key = array_search($day, $meeting_days)) !== false) {
      unset($meeting_days[$key]);
    }
  }
  return $meeting_days;
}

function getPublisherDays($id, $year, $month, $meeting_days){
  $publisher_cant =
    my_query("SELECT * FROM days_when_publisher_cant_drive WHERE MONTH(day) = {$month} AND YEAR(day) = {$year} AND id_publisher = {$id}", true);
  $days = array();
  $index = 0;
  while($publisher_cant_days = $publisher_cant->fetch_assoc()){
    $days[$index++] = new \DateTime($publisher_cant_days["day"]);
  }
  foreach ($days as $day) {
    if (($key = array_search($day, $meeting_days)) !== false) {
      unset($meeting_days[$key]);
    }
  }
  return $meeting_days;
}

function removeNoMeetingDays($meeting_days, $year, $month){
  $no_meeting_days_in_a_month = my_query("SELECT * FROM no_meeting_days WHERE MONTH(date) = {$month} AND YEAR(date) = {$year}", true);
  $no_meeting_days = array();
  $index = 0;
  while($no_meeting_days_row = $no_meeting_days_in_a_month->fetch_assoc()){
    $no_meeting_days[$index++] = new \DateTime($no_meeting_days_row["date"]);
  }

  foreach ($no_meeting_days as $no_meeting_day) { // Remove no_meeting_days from meeting_days
    if (($key = array_search($no_meeting_day, $meeting_days)) !== false) {
      unset($meeting_days[$key]);
    }
  }
  return $meeting_days;
}

function myParseDayToEN($day){
  switch($day){
    case 0: return "Monday"; break;
    case 1: return "Tuesday"; break;
    case 2: return "Wednesday"; break;
    case 3: return "Thursday"; break;
    case 4: return "Friday"; break;
    case 5: return "Saturday"; break;
    case 6: return "Sunday"; break;
  }
}

function getAllDaysInAMonth($year, $month, $day = 'Monday', $daysError = 3) {
  $dateString = 'first '.$day.' of '.$year.'-'.$month;
  if (!strtotime($dateString)) {
      throw new \Exception('"'.$dateString.'" is not a valid strtotime');
  }
  $startDay = new \DateTime($dateString);
  /*if ($startDay->format('j') > $daysError) {
      $startDay->modify('- 7 days');
  }*/
  $days = array();
  while ($startDay->format('Y-m') <= $year.'-'.str_pad($month, 2, 0, STR_PAD_LEFT)) {
      $days[] = clone($startDay);
      $startDay->modify('+ 7 days');
  }
  return $days;
}

?>
