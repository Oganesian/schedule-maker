$(document).ready(function() {
  setButtonClick();
});

function setButtonClick() {
  $("#delete").click(function() {
    $('.edit-delete-dropdown').fadeOut(20);
    $(".modal").fadeIn(50);
    $("#deleteUserDialog").fadeIn(50);
    var id = $(".edit-delete-dropdown").attr("id");
    var name = $("#" + id + "_name").html();
    myDeleteDialog(id, name);
  });

  $("#edit").click(function() {
    $('.edit-delete-dropdown').fadeOut(20);
    $(".modal").fadeIn(50);
    $("#editUserDialog").fadeIn(50);
    var id = $(".edit-delete-dropdown").attr("id");
    var name = $("#" + id + "_name").html();
    var login = $("#" + id + "_login").html();
    myEditDialog(id, name, login);
  });

  $(".okButton").click(function() {
    $(".modal").fadeOut(50);
    $("#differentPasswordsDialog").fadeOut(10);
  });

  $(".deleteUserButton").click(function() {
    var id = this.id;
    $(".modal").fadeOut(50);
    $("#deleteUserDialog").fadeOut(10);
    $.post('../src/php/forms.php', {
      'id': id,
      'deleteUser': true
    }, function(data) {
      $("#users-block").html(data);
    });
  });

  $(".edit-delete").click(function() {
    event.stopPropagation();
    var box = this.getBoundingClientRect();
    var widthDropdown = $(".edit-delete-dropdown").css("width");
    var widthButton = $(".edit-delete").css("width");
    var width = parseInt(widthDropdown) - parseInt(widthButton);
    $(".edit-delete-dropdown").css("top", box.top + pageYOffset - 2);
    $(".edit-delete-dropdown").css("left", box.left - width + 2);
    $(".edit-delete-dropdown").attr("id", parseInt(this.id, 10));
    $(".edit-delete-dropdown").fadeIn(20);
  });
}

function different_passwords() {
  $(".modal").fadeIn(50);
  $("#differentPasswordsDialog").fadeIn(50);
}

function myDeleteDialog(id, name) {
  $("#deleteUserTitle").html(name + " будет удален. Продолжить?");
  $(".deleteUserButton").attr("id", id);
}

function myEditDialog(id, name, login) {
  $("#editUserTitle").html(name + " — Редактирование");
  $("#edit-input-1").attr("value", name);
  $("#edit-input-2").attr("value", login);
  $(".editUserButton").attr("value", id);
}
