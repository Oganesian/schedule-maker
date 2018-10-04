<?php
  include_once 'src/php/auth.php';
  if(!check(1)) {
      header("Location: ../login/");
      exit;
  }
  include_once 'src/php/algorithm.php';
  include_once 'src/php/initials.php';
  include_once 'src/php/forms.php';
?>
<!DOCTYPE html>
<html lang="ru">

<head>
  <title>Расписание</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="src/css/style.css">
  <link rel="stylesheet" type="text/css" href="src/css/loading.css"/>
  <script type="text/javascript" src="src/js/jquery-min.js"></script>
  <script type="text/javascript" src="src/js/initializations/schedule-initials.js"></script>
  <script type="text/javascript" src="src/js/script.js"></script>
  <script type="text/javascript" src='src/js/pdfmake.min.js'></script>
  <script type="text/javascript" src='src/js/vfs_fonts.js'></script>
</head>

<body>
  <div class="modal">
  </div>

    <div class="dropdown hidden edit-delete-dropdown">
      <button slot="item" class="dropdown-item" id="edit" role="menuitem">
      Изменить
    </button>
      <button slot="item" class="dropdown-item" id="delete" role="menuitem">
      Удалить
    </button>
    </div>

      <div class="dialog" id="editDriveDialog">
    <div class="dialog-wrapper" id="editWrapper">
      <div class="top-container">
        <div class="title-container">
          <div class="title" id="editDriveTitle">Редактирование</div>
        </div>
      </div>
            <div class="form-container">
          <form action="" method="POST" enctype="multipart/form-data" name="edit_schedule" id="edutScheduleForm">
            <?php
            initializeEditScheduleForm();
            ?>
            </form>
            <div class="button-container" id="editButtons">
              <button style="display: none"></button>
              <button class="submit cancel">Отмена</button>
              <button name="editScheduleB" class="submit editScheduleButton">Изменить</button>
            </div>

        </div>
    </div>
  </div>


    <div class="dialog" id="deleteDriveDialog">
      <div class="dialog-wrapper">
        <div class="top-container">
          <div class="title-container">
            <div class="title" id="deleteDriveTitle"></div>
          </div>
        </div>
        <div class="button-container">
          <button class="submit cancel">Отмена</button>
          <button class="submit deleteDriveButton">Удалить</button>
        </div>
      </div>
    </div>

  <div class="menu">
    <a class="menu-item active" href="../">Расписание</a>
    <a class="menu-item" href="settings/">Настройки</a>
    <a class="menu-item" href="drivers/">Водители</a>
    <a class="menu-item" href="passengers/">Пассажиры</a>
    <a class="menu-item" href="users/">Ответственные</a>
    <a class="menu-item" href="logout/">Выход</a>
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
        <h2>Создать расписание</h2>
      </div>
      <div class="table-block">
        <div class="form-container">
          <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-item">
              <input autocomplete="off" class="form-input" id="input-1" type="month" name="month" style="padding-left: 5px" required/>
              <label for="input-1" id="label-1" style="padding-left: 5px">Месяц</label>
            </div>
            <div class="form-item">
              <select class="form-input" name="passenger" id="publishers-combo" required>
                <option value="-1">Все</option>
                <?php initializePassengersOptions() ?>
              </select>
              <label for="publishers-combo" id="c-label-1">Пассажир(-ы)</label>
            </div>
            <div class="submit-container">
              <div class="ld ld-ring ld-cycle" style="left: 127px; top: 26px;"></div>
              <input type="submit"  class="submit" id="createScheduleMonth" value="Создать" name="submitMonth" />
            </div>
          </form>
        </div>
      </div>
      <div class="table-block">
      </div>
      <?php initializeSchedules() ?>
    </div>
  </section>

</body>

</html>
