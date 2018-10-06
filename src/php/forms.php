<?php
include_once 'sql.php';
include_once 'initials.php';
include_once 'auth.php';

if(isset($_POST["createDriver"])) {
  if(check(1)){
    $driver = safe_query($_POST['driver']);
    $phone = safe_query($_POST['phone']);
    $email = safe_query($_POST['email']);
    $places = safe_query($_POST['places']);
    my_query("INSERT INTO publishers VALUES('NULL', '{$driver}', '{$phone}', '{$email}', '{$places}')", false);
    initializeDriversTable();
  }
}

if(isset($_POST["createUser"])) {
  if(check(1)){
    $name = safe_query($_POST['user']);
    $login = trim(safe_query($_POST['login']));
    $pass = trim(safe_query($_POST['password']));
    $pass_confirm = trim(safe_query($_POST['password_confirm']));
    if(!preg_match("/^[a-zA-Z0-9]+$/",$login)){
      echo "<script>alert('Логин может состоять только из латинских букв и цифр')</script>";
    } else {
      if($pass != $pass_confirm){
        echo "<script>different_passwords()</script>";
      }else{
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        my_query("INSERT INTO users VALUES('NULL', '{$hash}', '{$login}', '{$name}')", false);
      }
    }
  }
}

if(isset($_POST["editUser"])) {
  if(check(1)){
    $name = safe_query($_POST['user']);
    $login = trim(safe_query($_POST['login']));
    $pass = trim(safe_query($_POST['password']));
    $pass_confirm = trim(safe_query($_POST['password_confirm']));
    $id = safe_query($_POST['userid']);
    if(!preg_match("/^[a-zA-Z0-9]+$/",$login)){
      echo "<script>alert('Логин может состоять только из латинских букв и цифр')</script>";
    } else {
      if($pass != $pass_confirm){
        echo "<script>different_passwords();</script>";
      }else{
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        my_query("UPDATE users SET pass_hash = '{$hash}', login='{$login}', name='{$name}' WHERE id = '$id'", false);
      }
    }
    echo initializeUsersTable();
  }
}

if(isset($_POST["createPassenger"])) {
  if(check(1)){
  $passenger = safe_query($_POST['passenger']);
  $address = safe_query($_POST['address']);
  $phone = safe_query($_POST['phone']);
  $email = safe_query($_POST['email']);
  $places = safe_query($_POST['places']);
  my_query("INSERT INTO passengers VALUES('NULL', '{$passenger}', '{$phone}', '{$address}', '{$email}', '{$places}')", false);
}
}

if(isset($_POST["deleteDriver"])) {
  if(check(1)){
  $id = safe_query($_POST['id']);
  my_query("DELETE FROM publishers WHERE id_publisher = '{$id}'", false);
  echo initializeDriversTable();
  echo '<script>setButtonClick()</script>';
}
}

if(isset($_POST["deleteDrive"])) {
  if(check(1)){
    $pass = safe_query($_POST['passenger']);
    $driver = safe_query($_POST['driver']);
    $date = safe_query($_POST['date']);
    $date_sql = date("Y-m-d", strtotime($date));
    my_query("DELETE FROM fahrplan WHERE id_passenger = '{$pass}' AND id_publisher = '{$driver}' AND date = '{$date_sql}'", false);

    $result = my_query("SELECT id_passenger, passenger, address, phone FROM passengers WHERE id_passenger = '{$pass}'", true);
    $passenger_row = $result->fetch_assoc();
    $echo = initializeScheduleForAPassenger($passenger_row);
    $echo .= "<div class='passenger-information'>
            <p>Адрес: {$passenger_row["address"]}</p>
            <p>Телефон: {$passenger_row["phone"]}</p>
          </div></div>";
    $echo .= '<script>setButtonClick()</script>';
    echo $echo;
  }
}

if(isset($_POST["deleteUser"])) {
  if(check(1)){
  $id = safe_query($_POST['id']);
  my_query("DELETE FROM users WHERE id = '{$id}'", false);
  echo initializeUsersTable();
  echo '<script>setButtonClick()</script>';
  }
}

if(isset($_POST["deletePassenger"])) {
  if(check(1)){
  $id = safe_query($_POST['id']);
  my_query("DELETE FROM passengers WHERE id_passenger = '{$id}'", false);
  echo initializePassengersTable();
  echo '<script>setButtonClick()</script>';
  }
}

if(isset($_POST["changeActive"])) {
  if(check(1)){
  $id_publisher = safe_query($_POST['id_publisher']);
  $id_passenger = safe_query($_POST['id_passenger']);
  my_query("UPDATE who_takes_whom SET active = NOT active WHERE id_publisher = '{$id_publisher}' AND id_passenger = '{$id_passenger}'", false);
  echo initializeRelations();
  echo '<script>setButtonClick()</script>';
  }
}

if(isset($_POST["deleteRelation"])) {
  if(check(1)){
  $id_publisher = safe_query($_POST['id_publisher']);
  $id_passenger = safe_query($_POST['id_passenger']);
  my_query("DELETE FROM who_takes_whom WHERE id_publisher = '{$id_publisher}' AND id_passenger = '{$id_passenger}'", false);
  echo initializeRelations();
  echo '<script>setButtonClick()</script>';
  }
}

if(isset($_POST["createRelation"])) {
  if(check(1)){
    $id_publisher = safe_query($_POST["driver"]);
    $id_passenger = safe_query($_POST["passenger"]);
    $result = my_query("SELECT MIN(last_drive_date) FROM who_takes_whom WHERE id_publisher = '{$id_publisher}'", true);
    $line = $result->fetch_assoc();
    $min_date = $line["MIN(last_drive_date)"];
    $date = new \DateTime($min_date);
    $date->modify('- 2 days');
    my_query("INSERT INTO who_takes_whom VALUES('{$id_publisher}', '{$id_passenger}', '1', '{$date->format('Y-m-d')}')", false);
    initializeRelations();
  }
}

if(isset($_POST["addDriverException"])) {
  if(check(1)){
    $id_publisher = safe_query($_POST["driver"]);
    $date = safe_query($_POST["date_e"]);
    $type_of_ex = safe_query($_POST["type"]);
    $duplicate = my_query("SELECT id_publisher FROM days_when_publisher_cant_drive WHERE id_publisher = '{$id_publisher}' AND day = '{$date}'", true);
    if($duplicate->num_rows == 0) {
      my_query("INSERT INTO days_when_publisher_cant_drive VALUES('{$id_publisher}', '{$date}', '{$type_of_ex}')", false);
    }
    echo initializeDriversExceptions();
  }
}

if(isset($_POST["addPassengerException"])) {
  if(check(1)){
    $id_passenger = safe_query($_POST["passenger"]);
    $date = date('Y-m-d', strtotime(safe_query($_POST["date_p"])));
    my_query("INSERT INTO days_when_passenger_doesnt_need VALUES('{$id_passenger}', '{$date}')", false);
    initializePassengersExceptions();
  }
}

if(isset($_POST["updateCreateRelationForm"])){
    if(check(1)){
  echo initializeRelationsForm();
}
}

if(isset($_POST["updateRelations"])){
    if(check(1)){
  echo initializeRelations();
  echo '<script>setButtonClick();</script>';
    }
}

if(isset($_POST["editDriver"])) {
  if(check(1)){
  $driver = safe_query($_POST['e-driver']);
  $phone = safe_query($_POST['e-phone']);
  $email = safe_query($_POST['e-email']);
  $places = safe_query($_POST['e-places']);
  $id = safe_query($_POST['id']);
  my_query("UPDATE publishers SET publisher='{$driver}', phone='{$phone}', email='{$email}', places_in_car='{$places}' WHERE id_publisher = '{$id}'", false);
  echo initializeDriversTable();
  echo '<script>setButtonClick();</script>';
}
}

if(isset($_POST["editSchedules"])) {
  if(check(1)) {

    $driver = safe_query($_POST["id_publisher"]);
    $newDriver = safe_query($_POST["id_publisher_new"]);
    $newDate = date('Y-m-d', strtotime(safe_query($_POST["date_new"])));
    $passenger = safe_query($_POST["id_passenger"]);
    $date = date('Y-m-d', strtotime(safe_query($_POST["date"])));


    my_query("UPDATE fahrplan SET id_publisher='{$newDriver}', date='{$newDate}' WHERE id_publisher='{$driver}' AND id_passenger='{$passenger}' AND date='{$date}'", false);

    $result = my_query("SELECT id_passenger, passenger, address, phone FROM passengers WHERE id_passenger = '{$passenger}'", true);
    $passenger_row = $result->fetch_assoc();
    $echo = initializeScheduleForAPassenger($passenger_row);
    $echo .= "<div class='passenger-information'>
            <p>Адрес: {$passenger_row["address"]}</p>
            <p>Телефон: {$passenger_row["phone"]}</p>
          </div></div>";
    $echo .= '<script>setButtonClick();</script>';
    echo $echo;
  }
}

if(isset($_POST["editMeetingsDays"])) {
  if(check(1)){
  $weekday = safe_query($_POST['e-weekday']);
  $weekend = safe_query($_POST['e-weekend']);
  my_query("UPDATE meeting_days SET weekday='{$weekday}', weekend='{$weekend}'", false);
  echo initializeMeetingDays();
  echo '<script>setButtonClick();</script>';
}
}

if(isset($_POST["deleteNoMeetingDay"])){
  if(check(1)){
  $date = date('Y-m-d', strtotime(safe_query($_POST["id"])));
  my_query("DELETE FROM no_meeting_days WHERE date = '{$date}'", false);
  echo initializeNoMeetingDays();
  echo '<script>setButtonClick();</script>';
}
}

if(isset($_POST['deleteDriverException'])){
  if(check(1)){
  $date = date('Y-m-d', strtotime(safe_query($_POST["date"])));
  $id = safe_query($_POST['id']);
  my_query("DELETE FROM days_when_publisher_cant_drive WHERE day = '{$date}' AND id_publisher='{$id}'", false);
  echo initializeDriversExceptions();
  echo '<script>setButtonClick();</script>';
}
}

if(isset($_POST['deletePassengerException'])){
  if(check(1)){
  $date = date('Y-m-d', strtotime(safe_query($_POST["date"])));
  $id = safe_query($_POST['id']);
  my_query("DELETE FROM days_when_passenger_doesnt_need WHERE day = '{$date}' AND id_passenger='{$id}'", false);
  echo initializePassengersExceptions();
  echo '<script>setButtonClick();</script>';
}
}



if(isset($_POST["addNoMeetingDay"])){
  if(check(1)){
    $date = date('Y-m-d', strtotime(safe_query($_POST["date"])));
    my_query("INSERT INTO no_meeting_days VALUES('{$date}')", false);
    initializeNoMeetingDays();
  }
}

if(isset($_POST["editPassenger"])) {
  if(check(1)){
  $passenger = safe_query($_POST['e-passenger']);
  $phone = safe_query($_POST['e-phone']);
  $address = safe_query($_POST['e-address']);
  $email = safe_query($_POST['e-email']);
  $places = safe_query($_POST['e-places']);
  $id = safe_query($_POST['id']);
  my_query("UPDATE passengers SET passenger='{$passenger}',  phone='{$phone}', address='{$address}', email='{$email}', places_need='{$places}' WHERE id_passenger = '{$id}'", false);
  echo initializePassengersTable();
  echo '<script>setButtonClick();</script>';
}
}

?>
