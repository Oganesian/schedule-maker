<?php
  include_once '../src/php/auth.php';
  if(!check(1)) {
      header("Location: ../login/");
      exit;
  }
?>
<!DOCTYPE html>
<html lang="ru">

<head>
  <title>Настройки</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="../src/css/style.css">
  <link rel="stylesheet" type="text/css" href="../src/css/loading.css">
  <script type="text/javascript" src="../src/js/jquery-min.js"></script>
  <script type="text/javascript" src="../src/js/initializations/settings-initials.js"></script>
  <script type="text/javascript" src="../src/js/script.js"></script>
  <style>
  #editDriverDialog {
    height: 305px;
  }
  </style>
</head>

<body>
  <?php
    include_once '../src/php/initials.php';
    include_once '../src/php/forms.php';
  ?>
  <div class="modal">
  </div>
  <div class="menu">
    <a class="menu-item" href="../">Расписание</a>
    <a class="menu-item active" href="../settings/">Настройки</a>
    <a class="menu-item" href="../drivers/">Водители</a>
    <a class="menu-item" href="../passengers/">Пассажиры</a>
    <a class="menu-item" href="../users/">Ответственные</a>
    <a class="menu-item" href="../logout/">Выход</a>
  </div>

  <div class="dropdown hidden edit-dropdown">
    <button slot="item" class="dropdown-item" id="edit" role="menuitem">
    Изменить
  </button>
  </div>

  <div class="dropdown hidden delete-dropdown">
    <button slot="item" class="dropdown-item del" id="delete" role="menuitem">
    Удалить
  </button>
  </div>

  <div class="dropdown hidden delete-r-dropdown">
    <button slot="item" class="dropdown-item del" id="delete-r" role="menuitem">
    Удалить
  </button>
  </div>

  <div class="dropdown hidden delete-p-dropdown">
    <button slot="item" class="dropdown-item del" id="delete-p" role="menuitem">
    Удалить
  </button>
  </div>

  <div class="dialog" id="editDriverDialog">
    <div class="dialog-wrapper" id="editWrapper">
      <div class="top-container">
        <div class="title-container">
          <div class="title" id="editDriverTitle">Установить дни встреч</div>
        </div>
      </div>
      <div class="form-container" id="edit-form">
        <form action="" method="POST" enctype="multipart/form-data" name="meetings_days">
          <div class="form-item">
            <select class="form-input" id="edit-combo-0" required>
              <option id="value_0" value="0">Понедельник</option>
              <option id="value_1" value="1">Вторник</option>
              <option id="value_2" value="2">Среда</option>
              <option id="value_3" value="3">Четверг</option>
              <option id="value_4" value="4">Пятница</option>
            </select>
            <label for="edit-combo-0" id="c-label-1">Будни</label>
          </div>
          <div class="form-item">
            <select class="form-input" id="edit-combo-1" required>
              <option id="value_5" value="5">Суббота</option>
              <option id="value_6" value="6">Воскресенье</option>
            </select>
            <label for="edit-combo-1" id="c-label-2">Выходные</label>
          </div>
          </form>
          <div class="button-container" id="editButtons">
            <button class="submit cancel">Отмена</button>
            <button class="submit editDriverButton">Изменить</button>
          </div>
      </div>
    </div>
  </div>

  <header id="header">
    <nav>
      <button class="toggle-menu">
        <span class="sandwich">
          <span class="sw-topper"></span>
          <span class="sw-bottom"></span>
          <span class="sw-footer"></span>
        </span>
      </button>
    </nav>
  </header>

  <section id="main">
    <div class="main-row">
      <div class="table-header" id="first">
        <h2>Дни встреч</h2>
      </div>
      <div class="table-block" id="meetings-days-block">
        <?php
          initializeMeetingDays();
        ?>
      </div>
      <div class="table-header">
        <h2>Отмененные встречи</h2>
      </div>
      <div class="table-block" id="no-meeting-days-block">
        <?php
          initializeNoMeetingDays();
        ?>
      </div>
      <div class="table-header">
        <h2>Добавить отмененную встречу</h2>
      </div>
      <div class="table-block" id="add-no-meeting-day-block">
        <div class="form-container">
          <form action="" method="POST" enctype="multipart/form-data" name="no_meetings" id="addNoMeetingDayForm">
            <div class="form-item">
              <input autocomplete="off" class="form-input" id="input-1" type="date" name="date" pattern="\d{1,2}\.\d{1,2}\.\d{4}" placeholder="дд.мм.гггг" required>
              <label for="input-1" id="label-1">Дата</label>
            </div>
            <div class="submit-container">
              <div class="ld ld-ring ld-cycle" id="loading-1" style="margin: auto; top: 33.5px; width: 2em; height: 2em"></div>
              <input type="submit" id="addNoMeetingDayBtn" name="addNoMeetingDay" class="submit" value="Добавить" />
            </div>
          </form>
        </div>
      </div>
      <div class="table-header">
        <h2>Исключения для водителей</h2>
      </div>
      <div class="table-block" id="drivers-exceptions-block">
        <?php
          initializeDriversExceptions();
        ?>
      </div>
      <div class="table-header">
        <h2>Добавить исключение для водителя</h2>
      </div>
      <div class="table-block" id="add-driver-exception-block">
        <div class="form-container">
          <form action="" method="POST" enctype="multipart/form-data" name="drivers_exceptions" id="addDriverExceptionForm">
            <?php
            initializeDriversExceptionsForm();
            ?>
            <div class="submit-container">
              <div class="ld ld-ring ld-cycle" id="loading-2" style="margin: auto; top: 33.5px; width: 2em; height: 2em"></div>
              <input type="submit" id="addDriverExceptionBtn" name="addDriverException" class="submit" value="Добавить" />
            </div>
          </form>
        </div>
      </div>
      <div class="table-header">
        <h2>Исключения для пассажиров</h2>
      </div>
      <div class="table-block" id="passengers-exceptions-block">
        <?php
          initializePassengersExceptions();
        ?>
      </div>
      <div class="table-header">
        <h2>Добавить исключение для пассажира</h2>
      </div>
      <div class="table-block" id="add-passenger-exception-block">
        <div class="form-container">
          <form action="" method="POST" enctype="multipart/form-data" name="passengers_exceptions" id="addPassengerExceptionForm">
            <?php
            initializePassengersExceptionsForm();
            ?>
            <div class="submit-container">
              <div class="ld ld-ring ld-cycle" id="loading-3" style="margin: auto; top: 33.5px; width: 2em; height: 2em"></div>
              <input type="submit" id="addPassengerExceptionBtn" name="addPassengerException" class="submit" value="Добавить" />
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

</body>

</html>
