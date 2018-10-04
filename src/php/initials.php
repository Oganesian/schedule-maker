<?php
include_once 'sql.php';
include_once 'auth.php';

function initializeDriversTable() {
  if(check(1)){
  $result = my_query("SELECT * FROM publishers", true) or die('Запрос не удался: ' . mysql_error());
  $tableHeaders = '<table>
    <tr id="columns-headers">
      <th>Водитель</th>
      <th>Телефон</th>
      <th>E-Mail</th>
      <th>Мест</th>
    </tr>';
  $echo = $tableHeaders;
  while ($line = $result->fetch_assoc()) {
    $tr = "<tr><td id='{$line['id_publisher']}_name'>{$line['publisher']}</td>";
    $tr .= "<td id='{$line['id_publisher']}_phone'>{$line['phone']}</td>";
    $tr .= "<td id='{$line['id_publisher']}_email'>{$line['email']}</td>";
    $tr .= "<td id='{$line['id_publisher']}_places'>{$line['places_in_car']}</td>";
    $tr .= "<td class='buttons-td'>";
    $tr .= "<button class='std-button edit-delete' id='{$line['id_publisher']}_std-button'>•••</button></td></tr>";
    $echo .= $tr;
  }
  if($echo == $tableHeaders){
    $echo = "<h2 class='empty-table-warning'>Нет записей</h2>";
  } else {
    $echo .= "</table>";
  }
  echo $echo;
}
}

function initializeUsersTable() {
  if(check(1)){
  $result = my_query("SELECT * FROM users", true) or die('Запрос не удался: ' . mysql_error());
  $tableHeaders = '<table>
    <tr id="columns-headers">
      <th>Логин</th>
      <th>Пользователь</th>
    </tr>';
  $echo = $tableHeaders;
  while ($line = $result->fetch_assoc()) {
    $tr = "<tr><td id='{$line['id']}_login'>{$line['login']}</td>";
    $tr .= "<td id='{$line['id']}_name'>{$line['name']}</td>";
    $tr .= "<td class='buttons-td'>";
    $tr .= "<button class='std-button edit-delete' id='{$line['id']}_std-button'>•••</button></td></tr>";
    $echo .= $tr;
  }
  if($echo == $tableHeaders){
    $echo = "<h2 class='empty-table-warning'>Нет записей</h2>";
  } else {
    $echo .= "</table>";
  }
  echo $echo;
}
}

function initializePassengersTable() {
  if(check(1)){
  $result = my_query("SELECT * FROM passengers", true) or die('Запрос не удался: ' . mysql_error());
  $tableHeaders = '<table>
    <tr id="columns-headers">
      <th>Пассажир(ы)</th>
      <th>Адрес</th>
      <th>Телефон</th>
      <th>E-Mail</th>
      <th>Мест</th>
    </tr>';
  $echo = $tableHeaders;
  while ($line = $result->fetch_assoc()) {
    $tr = "<tr><td id='{$line['id_passenger']}_name'>{$line['passenger']}</td>";
    $tr .= "<td id='{$line['id_passenger']}_address'>{$line['address']}</td>";
    $tr .= "<td id='{$line['id_passenger']}_phone'>{$line['phone']}</td>";
    $tr .= "<td id='{$line['id_passenger']}_email'>{$line['email']}</td>";
    $tr .= "<td id='{$line['id_passenger']}_places'>{$line['places_need']}</td>";
    $tr .= "<td class='buttons-td'>";
    $tr .= "<button class='std-button edit-delete' id='{$line['id_passenger']}_std-button'>•••</button></td></tr>";
    $echo .= $tr;
  }
  if($echo == $tableHeaders){
    $echo = "<h2 class='empty-table-warning'>Нет записей</h2>";
  } else {
    $echo .= "</table>";
  }
  echo $echo;
}
}

function initializeRelations() {
  if(check(1)){
  $result = my_query("SELECT * FROM who_takes_whom", true) or die('Запрос не удался: ' . mysql_error());
  $tableHeaders =
    '<table>
      <tr id="columns-headers">
        <th>Водитель</th>
        <th>Пассажир</th>
        <th>Статус</th>
      </tr>';

    $echo = $tableHeaders;

    while ($line = $result->fetch_assoc()) {
      $driver_result = my_query("SELECT publisher FROM publishers WHERE id_publisher = '{$line['id_publisher']}'", true) or die('Запрос не удался: ' . mysql_error());
      $driver_line = $driver_result->fetch_assoc();
      $driver = $driver_line["publisher"];
      $passenger_result = my_query("SELECT passenger FROM passengers WHERE id_passenger = '{$line['id_passenger']}'", true) or die('Запрос не удался: ' . mysql_error());
      $passenger_line = $passenger_result->fetch_assoc();
      $passenger = $passenger_line["passenger"];

      $tr = "<tr><td id='{$line['id_publisher']}_publisher_r'>{$driver}</td>";
      $tr .= "<td id='{$line['id_passenger']}_passenger_r'>{$passenger}</td>";
      if($line["active"] == "1"){
        $tr .= "<td class='status-active'>Активен</td>";
      } else {
        $tr .= "<td class='status-inactive'>Неактивен</td>";
      }
      $tr .= "<td class='buttons-td'>";
      $tr .= "<button class='std-button edit-delete-r' id='{$line['id_publisher']}_{$line['id_passenger']}'>•••</button></td></tr>";
      $echo .= $tr;
    }
    if($echo == $tableHeaders){
      $echo = "<h2 class='empty-table-warning'>Нет записей</h2>";
    } else {
      $echo .= "</table>";
    }
    echo $echo;
}
}

function initializeMeetingDays() {
  if(check(1)){
  $result = my_query("SELECT * FROM meeting_days", true) or die('Запрос не удался: ' . mysql_error());
  $tableHeaders =
    '<table>
      <tr id="columns-headers">
        <th>Будни</th>
        <th>Выходные</th>
      </tr>';
    $echo = $tableHeaders;
    $line = $result->fetch_assoc();

    $weekday = myParseDay($line["weekday"]);
    $weekend = myParseDay($line["weekend"]);

    $echo .= "<tr><td class='weekday-c' id='{$line["weekday"]}'>{$weekday}</td>";
    $echo .= "<td class='weekend-c' id='{$line["weekend"]}'>{$weekend}</td>";
    $echo .= "<td class='buttons-td'>";
    $echo .= "<button class='std-button edit' id='{$weekday}'>•••</button></td></tr></table>";

    echo $echo;
}
}

function initializeNoMeetingDays() {
  if(check(1)){
  $result = my_query("SELECT * FROM no_meeting_days ORDER BY `date` DESC LIMIT 10", true) or die('Запрос не удался: ' . mysql_error());
  $tableHeaders =
    '<table>
      <tr id="columns-headers">
        <th>Дата</th>
        <th>День недели</th>
      </tr>';
    $echo = $tableHeaders;
    while($line = $result->fetch_assoc()){
      $date = date('d.m.Y', strtotime($line["date"]));
      $dt1 = strtotime($date);
      $dt2 = date("l", $dt1);
      $dt3 = strtolower($dt2);
      $dateOfWeekRU = myParseDayEN($dt3);
      $tr = "<tr><td id='{$date}'>{$date}</td>";
      $tr .= "<td>{$dateOfWeekRU}</td>";
      $tr .= "<td class='buttons-td'>";
      $tr .= "<button class='std-button delete' id='{$date}'>•••</button></td></tr>";
      $echo .= $tr;
    }
    if($echo == $tableHeaders){
      $echo = "<h2 class='empty-table-warning'>Нет записей</h2>";
    } else {
      $echo .= "</table>";
    }
    echo $echo;
}
}

function initializeDriversExceptions() {
  if(check(1)){
  $result = my_query("SELECT * FROM days_when_publisher_cant_drive ORDER BY `day` DESC LIMIT 20", true) or die('Запрос не удался: ' . mysql_error());
  $tableHeaders =
    '<table>
      <tr id="columns-headers">
        <th>Водитель</th>
        <th>Дата</th>
        <th>Тип</th>
      </tr>';

    $echo = $tableHeaders;
    while($line = $result->fetch_assoc()){
      switch((int)$line["type"]){
        case 1: $type_of_ex = "Может привезти в Зал"; break;
        case 2: $type_of_ex = "Может отвезти домой"; break;
        default: $type_of_ex = "Вообще не может";
      }
      $date = date('d.m.Y', strtotime($line["day"]));
      $temp = my_query("SELECT publisher FROM publishers WHERE id_publisher = '{$line["id_publisher"]}'", true);
      $line_temp = $temp->fetch_assoc();
      $tr = "<tr><td id='{$line["id_publisher"]}_{$date}'>{$line_temp["publisher"]}</td>";
      $tr .= "<td>{$date}</td>";
      $tr .= "<td>{$type_of_ex}</td>";
      $tr .= "<td class='buttons-td'>";
      $tr .= "<button class='std-button delete del-r' id='{$line["id_publisher"]}_{$date}'>•••</button></td></tr>";
      $echo .= $tr;
    }
    if($echo == $tableHeaders){
      $echo = "<h2 class='empty-table-warning'>Нет записей</h2>";
    } else {
      $echo .= "</table>";
    }
    echo $echo;
}
}

function initializePassengersExceptions() {
  if(check(1)){
  $result = my_query("SELECT * FROM days_when_passenger_doesnt_need ORDER BY `day` DESC LIMIT 20", true) or die('Запрос не удался: ' . mysql_error());
  $tableHeaders =
    '<table>
      <tr id="columns-headers">
        <th>Пассажир(-ы)</th>
        <th>Дата</th>
      </tr>';
    $echo = $tableHeaders;
    while($line = $result->fetch_assoc()){
      $date = date('d.m.Y', strtotime($line["day"]));
      $temp = my_query("SELECT passenger FROM passengers WHERE id_passenger = '{$line["id_passenger"]}'", true);
      $line_temp = $temp->fetch_assoc();
      $tr = "<tr><td id='{$line["id_passenger"]}_{$date}'>{$line_temp["passenger"]}</td>";
      $tr .= "<td>{$date}</td>";
      $tr .= "<td class='buttons-td'>";
      $tr .= "<button class='std-button delete del-p' id='{$line["id_passenger"]}_{$date}'>•••</button></td></tr>";
      $echo .= $tr;
    }
    if($echo == $tableHeaders){
      $echo = "<h2 class='empty-table-warning'>Нет записей</h2>";
    } else {
      $echo .= "</table>";
    }
    echo $echo;
}
}

function initializeSchedules(){
  if(check(1)){
    $result = my_query("SELECT id_passenger, passenger, address, phone FROM passengers", true);
    $echo = "";
    while($passenger_row = $result->fetch_assoc()){
      $name = translit($passenger_row["passenger"]);
      $tagId = str_replace(" ", "", $name);
      $passenger_header = "<div class='table-header hideable' id='{$tagId}-header'>
            <div id='{$tagId}-img' class='hide-show-arrow'><img src='src/img/arrow.svg'/></div>
            <h2>{$name}</h2>
          </div>";
      $passenger_block = "<div class='table-block' id='{$tagId}-block'>";
      $echo .= $passenger_header . $passenger_block;
      $echo .= initializeScheduleForAPassenger($passenger_row);
      $echo .= "<div class='passenger-information'>
            <p>Адрес: {$passenger_row["address"]}</p>
            <p>Телефон: {$passenger_row["phone"]}</p>
          </div></div>";
    }
    echo $echo;
  }
}

function initializeScheduleForAPassenger($passenger_row){
    $echo = "";
    $name = translit($passenger_row["passenger"]);
    $tagId = str_replace(" ", "", $name);
    $getDate = my_query("SELECT MAX(date) FROM fahrplan WHERE id_passenger = '{$passenger_row["id_passenger"]}'", true);
    $date = $getDate->fetch_assoc();
    $month = substr($date["MAX(date)"], 5, 2);
    $year = substr($date["MAX(date)"], 0, 4);
    $temp = my_query("SELECT * FROM fahrplan WHERE id_passenger = '{$passenger_row["id_passenger"]}' AND MONTH(date) = '{$month}' AND YEAR(date) = '{$year}' ORDER BY date", true);
    $tableHeaders =
      "<table id='{$tagId}-table'>
        <tr id='columns-headers'>
          <th>Кто забирает</th>
          <th>Дата</th>
          <th>День недели</th>
          <th>Примечание</th>
          <th class='buttons-td'><button class='std-button save' id='{$tagId}-button'>•••</button></th>
        </tr>";
    $echo = $tableHeaders;

    while($line_temp = $temp->fetch_assoc()){
        $date = date('d-m-Y', strtotime($line_temp["date"]));
        $publisher_sql = my_query("SELECT publisher FROM publishers WHERE id_publisher = '{$line_temp["id_publisher"]}'", true);
        $publisher_row = $publisher_sql->fetch_assoc();
        $day_of_week = date('N', strtotime($line_temp["date"]));
        $day_of_week = myParseDay($day_of_week-1);
        $type = myParseType($line_temp["type"]);
        $tr = "<tr><td id='{$passenger_row["id_passenger"]}_{$date}_{$line_temp["id_publisher"]}'>{$publisher_row["publisher"]}</td>";
        $tr .= "<td id='{$passenger_row["id_passenger"]}_{$date}_{$line_temp["id_publisher"]}_date'>{$date}</td>";
        $tr .= "<td>{$day_of_week}</td>";
        $tr .= "<td>{$type}</td>";
        $tr .= "<td class='buttons-td'>";
        $tr .= "<button class='std-button edit-delete' id='{$passenger_row["id_passenger"]}_{$date}_{$line_temp["id_publisher"]}'>•••</button></td></tr>";
        $echo .= $tr;
    }
    if($echo == $tableHeaders){
      $echo = "<h2 class='empty-table-warning'>Нет записей</h2>";
    } else {
      $echo .= "</table>";
    }
    return $echo;
}

function initializePassengersOptions(){
  $resultPassengers = my_query("SELECT id_passenger, passenger FROM passengers", true) or die('Запрос не удался: ' . mysql_error());
  $echo = "";
  $flagPassengers = false;
  $options = "";
  while ($line = $resultPassengers->fetch_assoc()) {
    $flagPassengers = true;
    $option = "<option value='{$line["id_passenger"]}'>{$line["passenger"]}</option>";
    $options .= $option;
  }
  $echo .= $options;
  echo $echo;
}

function initializeRelationsForm(){
  if(check(1)){
  $resultDrivers = my_query("SELECT id_publisher, publisher FROM publishers", true) or die('Запрос не удался: ' . mysql_error());
  $resultPassengers = my_query("SELECT id_passenger, passenger FROM passengers", true) or die('Запрос не удался: ' . mysql_error());
  $echo = "";
  $flagDrivers = false;
  $flagPassengers = false;

  $formItem =
  '<div class="form-item">
    <select class="form-input" id="combo-1" name="driver" required>';
  while ($line = $resultDrivers->fetch_assoc()) {
    $flagDrivers = true;
    $option = "<option value='{$line["id_publisher"]}'>{$line["publisher"]}</option>";
    $formItem .= $option;
  }
  $formItem .= '</select>
    <label for="combo-1" id="c-label-1">Водитель</label>
  </div>';
  $echo .= $formItem;

  $formItem =
  '<div class="form-item">
    <select class="form-input" id="combo-2" name="passenger" required>';
  while ($line = $resultPassengers->fetch_assoc()) {
    $flagPassengers = true;
    $option = "<option value='{$line["id_passenger"]}'>{$line["passenger"]}</option>";
    $formItem .= $option;
  }
  $formItem .= '</select>
    <label for="combo-2" id="c-label-1">Пассажир</label>
  </div>';
  $echo .= $formItem;
  $echo .= '<div class="submit-container">
              <input type="submit" name="createRelation" class="submit" value="Добавить" />
            </div>';
  if($flagDrivers && $flagPassengers){
    echo $echo;
  } else {
    echo "<h2 class='empty-table-warning'>Нет записей</h2>";
  }
}
}

function initializeDriversExceptionsForm(){
  if(check(1)){
  $resultDrivers = my_query("SELECT id_publisher, publisher FROM publishers", true) or die('Запрос не удался: ' . mysql_error());
  $echo = "";
  $flagDrivers = false;

  $formItem =
  '<div class="form-item">
    <select class="form-input" id="combo-driver" name="driver" required>';
  while ($line = $resultDrivers->fetch_assoc()) {
    $flagDrivers = true;
    $option = "<option value='{$line["id_publisher"]}'>{$line["publisher"]}</option>";
    $formItem .= $option;
  }
  $formItem .= '</select>
    <label for="combo-driver" id="c-label-1" style="left: 0px">Водитель</label>
  </div>';
  $echo .= $formItem;
  $echo .= '<div class="form-item">
                <select class="form-input" id="combo-type" name="type" required="">
                  <option value="0">Вообще не может</option>
                  <option value="1">Может только привезти в Зал</option>
                  <option value="2">Может только отвезти из Зала</option>
                </select>
                <label for="combo-type" id="c-label-2" style="left: 0px">Тип исключения</label>
               </div>';

  $echo .= '<div class="form-item">
                <input autocomplete="off" class="form-input" id="input-date" type="date" name="date_e" pattern="\d{1,2}\.\d{1,2}\.\d{4}" placeholder="дд.мм.гггг" required>
                <label for="input-date" id="label-2" style="top: -58px">Дата</label>
              </div>';

  if($flagDrivers){
    echo $echo;
  } else {
    echo "<h2 class='empty-table-warning'>Нет записей</h2>";
  }
}
}

function initializeEditScheduleForm(){
  if(check(1)){
  $resultDrivers = my_query("SELECT id_publisher, publisher FROM publishers", true) or die('Запрос не удался: ' . mysql_error());
  $echo = "";
  $flagDrivers = false;

  $formItem =
  '<div class="form-item">
    <select class="form-input" id="combo-1" name="driver" required>';
  while ($line = $resultDrivers->fetch_assoc()) {
    $flagDrivers = true;
    $option = "<option id='value_{$line["id_publisher"]}' value='{$line["id_publisher"]}'>{$line["publisher"]}</option>";
    $formItem .= $option;
  }
  $formItem .= '</select>
    <label for="combo-1" id="c-label-1">Водитель</label>
  </div>';
  $formItem .= '<div class="form-item">
                <input autocomplete="off" class="form-input" id="input-2" type="date" name="date_e" pattern="\d{1,2}\.\d{1,2}\.\d{4}" placeholder="дд.мм.гггг" required>
                <label for="input-2" id="label-2">Дата</label>
              </div>';
  $echo .= $formItem;

  if($flagDrivers){
    echo $echo;
  } else {
    echo "<h2 class='empty-table-warning'>Нет записей</h2>";
  }
}
}

function initializePassengersExceptionsForm(){
  if(check(1)){
  $resultDrivers = my_query("SELECT id_passenger, passenger FROM passengers", true) or die('Запрос не удался: ' . mysql_error());
  $echo = "";
  $flagDrivers = false;

  $formItem =
  '<div class="form-item">
    <select class="form-input" id="combo-2" name="passenger" required>';
  while ($line = $resultDrivers->fetch_assoc()) {
    $flagDrivers = true;
    $option = "<option value='{$line["id_passenger"]}'>{$line["passenger"]}</option>";
    $formItem .= $option;
  }
  $formItem .= '</select>
    <label for="combo-2" id="c-label-2">Пассажир</label>
  </div>';
  $formItem .= '<div class="form-item">
                <input autocomplete="off" class="form-input" id="input-3" type="date" name="date_p" pattern="\d{1,2}\.\d{1,2}\.\d{4}" placeholder="дд.мм.гггг" required>
                <label for="input-3" id="label-3">Дата</label>
              </div>';
  $echo .= $formItem;

  if($flagDrivers){
    echo $echo;
  } else {
    echo "<h2 class='empty-table-warning'>Нет записей</h2>";
  }
}
}

function translit($str) {
  $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
  $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
  return str_replace($rus, $lat, $str);
}

function myParseDayEN($day){
  switch($day){
    case "monday": return "Понедельник"; break;
    case "tuesday": return "Вторник"; break;
    case "wednesday": return "Среда"; break;
    case "thursday": return "Четверг"; break;
    case "friday": return "Пятница"; break;
    case "saturday": return "Суббота"; break;
    case "sunday": return "Воскресенье"; break;
  }
}

function myParseDay($day){
  switch($day){
    case 0: return "Понедельник"; break;
    case 1: return "Вторник"; break;
    case 2: return "Среда"; break;
    case 3: return "Четверг"; break;
    case 4: return "Пятница"; break;
    case 5: return "Суббота"; break;
    case 6: return "Воскресенье"; break;
  }
}

function myParseType($type){
  switch($type){
    case 0: return ""; break;
    case 1: return "Привезет в Зал Царства"; break;
    case 2: return "Увезет домой"; break;
    default: return "";
  }
}

?>
