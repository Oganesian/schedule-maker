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
  <title>Пассажиры</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="../src/css/style.css">
  <script type="text/javascript" src="../src/js/jquery-min.js"></script>
  <script type="text/javascript" src="../src/js/initializations/passengers-initials.js"></script>
  <script type="text/javascript" src="../src/js/script.js"></script>
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
    <a class="menu-item" href="../settings/">Настройки</a>
    <a class="menu-item" href="../drivers/">Водители</a>
    <a class="menu-item active" href="../passengers/">Пассажиры</a>
    <a class="menu-item" href="../users/">Ответственные</a>
    <a class="menu-item" href="../logout/">Выход</a>
  </div>

  <div class="dropdown hidden edit-delete-dropdown">
    <button slot="item" class="dropdown-item" id="edit" role="menuitem">
    Изменить
  </button>
    <button slot="item" class="dropdown-item" id="delete" role="menuitem">
    Удалить
  </button>
  </div>

  <div class="dialog" id="deleteDriverDialog">
    <div class="dialog-wrapper">
      <div class="top-container">
        <div class="title-container">
          <div class="title" id="deleteDriverTitle"></div>
        </div>
      </div>
      <div class="button-container">
        <button class="submit cancel">Отмена</button>
        <button class="submit deleteDriverButton">Удалить</button>
      </div>
    </div>
  </div>

  <div class="dialog" id="editPassengerDialog">
    <div class="dialog-wrapper" id="editWrapper">
      <div class="top-container">
        <div class="title-container">
          <div class="title" id="editDriverTitle">Редактирование</div>
        </div>
      </div>
      <div class="form-container" id="edit-form">
        <form action="" method="POST" enctype="multipart/form-data" name="drivers">
          <div class="form-item">
            <input autocomplete="off" class="form-input" id="edit-input-1" type="text" required>
            <label for="edit-input-1" id="label-1">Фамилия Имя</label>
          </div>
          <div class="form-item">
            <input autocomplete="off" class="form-input" id="edit-input-4" type="text" required>
            <label for="edit-input-4" id="label-4">Адрес</label>
          </div>
          <div class="form-item">
            <input autocomplete="off" class="form-input" id="edit-input-2" type="text" required>
            <label for="edit-input-2" id="label-2">Телефон</label>
          </div>
          <div class="form-item">
            <input autocomplete="off" class="form-input" id="edit-input-3" type="email" required>
            <label for="edit-input-3" id="label-3">E-Mail</label>
          </div>
          <div class="form-item">
            <select class="form-input" id="edit-combo-0" required>
              <option id="value_1" value="1">1</option>
              <option id="value_2" value="2">2</option>
              <option id="value_3" value="3">3</option>
              <option id="value_4" value="4">4</option>
              <option id="value_5" value="5">5</option>
              <option id="value_6" value="6">6</option>
              <option id="value_7" value="7">7</option>
            </select>
            <label for="edit-combo-0" id="c-label-1">Необходимо мест</label>
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
        <h2>Пассажиры</h2>
      </div>
      <div class="table-block" id="passengers-block">
        <?php
        initializePassengersTable()
      ?>
      </div>
      <div class="table-header">
        <h2>Добавить пассажира</h2>
      </div>
      <div class="table-block" id="add-passengers-block">
        <div class="form-container">
          <form action="" method="POST" enctype="multipart/form-data" name="drivers">
            <div class="form-item">
              <input autocomplete="off" class="form-input" id="input-1" type="text" name="passenger" required>
              <label for="input-1" id="label-1">Фамилия Имя</label>
            </div>
            <div class="form-item">
              <input autocomplete="off" class="form-input" id="input-2" type="text" name="address" required>
              <label for="input-2" id="label-2">Адрес</label>
            </div>
            <div class="form-item">
              <input autocomplete="off" class="form-input" id="input-3" type="text" name="phone" required>
              <label for="input-3" id="label-3">Телефон</label>
            </div>
            <div class="form-item">
              <input autocomplete="off" class="form-input" id="input-4" type="email" name="email" required>
              <label for="input-4" id="label-4">E-Mail</label>
            </div>
            <div class="form-item">
              <select class="form-input" id="combo-0" name="places" required>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
            </select>
              <label for="combo-0" id="c-label-1">Необходимо мест</label>
            </div>
            <div class="submit-container">
              <input type="submit" name="createPassenger" class="submit" value="Добавить" />
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

</body>

</html>
