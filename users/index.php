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
  <title>Ответственные</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="../src/css/style.css">
  <script type="text/javascript" src="../src/js/jquery-min.js"></script>
  <script type="text/javascript" src="../src/js/initializations/users-initials.js"></script>
  <script type="text/javascript" src="../src/js/script.js"></script>
</head>

<body>
  <div class="modal">
  </div>
  <div class="menu">
    <a class="menu-item" href="../">Расписание</a>
    <a class="menu-item" href="../settings/">Настройки</a>
    <a class="menu-item" href="../drivers/">Водители</a>
    <a class="menu-item" href="../passengers/">Пассажиры</a>
    <a class="menu-item active" href="../users/">Ответственные</a>
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

  <div class="dialog" id="differentPasswordsDialog">
    <div class="dialog-wrapper">
      <div class="top-container">
        <div class="title-container">
          <div class="title">Пароли не совпадают</div>
        </div>
      </div>
      <div class="button-container">
        <button class="submit okButton">Ок</button>
      </div>
    </div>
  </div>

  <div class="dialog" id="editUserDialog">
    <div class="dialog-wrapper" id="editWrapper">
      <div class="top-container">
        <div class="title-container">
          <div class="title" id="editUserTitle">Редактирование</div>
        </div>
      </div>
      <div class="form-container" id="edit-form">
          <form action="" method="POST" enctype="multipart/form-data" name="edit_user">
            <input type="number" class="editUserButton" style="display: none" name="userid" />
            <div class="form-item">
              <input autocomplete="off" class="form-input" id="edit-input-1" type="text" name="user" required>
              <label for="edit-input-1" id="label-1">Фамилия Имя</label>
            </div>
            <div class="form-item">
              <input autocomplete="off" class="form-input" id="edit-input-2" type="text" name="login" required>
              <label for="edit-input-2" id="label-2">Логин</label>
            </div>
            <div class="form-item">
              <input autocomplete="off" class="form-input" id="edit-input-3" type="password" minlength="6" name="password" required>
              <label for="edit-input-3" id="label-3">Пароль</label>
            </div>
            <div class="form-item">
              <input autocomplete="off" class="form-input" id="edit-input-4" type="password" minlength="6" name="password_confirm" required>
              <label for="edit-input-4" id="label-4">Подтверждение пароля</label>
            </div>
            <div class="button-container" id="editButtons">
              <button class="submit cancel">Отмена</button>
              <input type="submit" name="editUser" value="Изменить" class="submit submitEdit" id="editUserSubmit">
            </div>
            </form>
      </div>
    </div>
  </div>

  <div class="dialog" id="deleteUserDialog">
    <div class="dialog-wrapper">
      <div class="top-container">
        <div class="title-container">
          <div class="title" id="deleteUserTitle"></div>
        </div>
      </div>
      <div class="button-container">
        <button class="submit cancel">Отмена</button>
        <button class="submit deleteUserButton">Удалить</button>
      </div>
    </div>
  </div>

  <?php
    include_once '../src/php/initials.php';
    include_once '../src/php/forms.php';
  ?>

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
        <h2>Ответственные</h2>
      </div>
      <div class="table-block" id="users-block">
        <?php
          initializeUsersTable();
        ?>
      </div>
      <div class="table-header">
        <h2>Добавить ответственного</h2>
      </div>
      <div class="table-block">
        <div class="form-container">
          <form action="" method="POST" enctype="multipart/form-data" name="users">
            <div class="form-item">
              <input autocomplete="off" class="form-input" id="input-1" type="text" name="user" required>
              <label for="input-1" id="label-1">Фамилия Имя</label>
            </div>
            <div class="form-item">
              <input autocomplete="off" class="form-input" id="input-2" type="text" name="login" required>
              <label for="input-2" id="label-2">Логин</label>
            </div>
            <div class="form-item">
              <input autocomplete="off" class="form-input" id="input-3" type="password" minlength="6" name="password" required>
              <label for="input-3" id="label-3">Пароль</label>
            </div>
            <div class="form-item">
              <input autocomplete="off" class="form-input" id="input-4" type="password" minlength="6" name="password_confirm" required>
              <label for="input-4" id="label-4">Подтверждение пароля</label>
            </div>
            <div class="submit-container">
              <input type="submit" name="createUser" class="submit" value="Добавить" />
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

</body>

</html>
