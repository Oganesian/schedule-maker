<?php
    include_once '../src/php/auth.php';
?>
<!DOCTYPE html>
<html lang="ru">

<head>
  <title>Авторизация</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="../src/css/style.css">
  <script type="text/javascript" src="../src/js/jquery-min.js"></script>
  <script type="text/javascript" src="../src/js/script.js"></script>
</head>

<body>
  <div class="modal"></div>

  <section id="main">
    <div class="main-row" style="max-width: 480px; min-width: 280px; margin-top: 6%; max-height: 315px;">
      <div class="table-block" id="login-block">
        <div class="form-container">
          <form action="" method="POST" enctype="multipart/form-data" name="auth_form">
            <div class="form-item">
              <input autocomplete="off" class="form-input" id="input-2" type="text" name="login" required>
              <label for="input-2" id="label-2">Логин</label>
            </div>
            <div class="form-item">
              <input autocomplete="off" class="form-input" id="input-3" type="password" name="password" required>
              <label for="input-3" id="label-3">Пароль</label>
            </div>
            <div class="submit-container">
              <input type="submit" name="auth" class="submit" value="Войти" />
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

</body>

</html>
