$(document).ready(function() {
  setButtonClick();
});

function setButtonClick() {
  $("#delete").click(function() {
    $('.edit-delete-dropdown').fadeOut(20);
    $(".modal").fadeIn(50);
    $("#editPassengerDialog").fadeIn(50);
    var id = $(".edit-delete-dropdown").attr("id");
    var name = $("#" + id + "_name").html();
    myDeleteDialog(id, name);
  });

  $("#edit").click(function() {
    $('.edit-delete-dropdown').fadeOut(20);
    $(".modal").fadeIn(50);
    $("#editPassengerDialog").fadeIn(50);
    var id = $(".edit-delete-dropdown").attr("id");
    var name = $("#" + id + "_name").html();
    var phone = $("#" + id + "_phone").html();
    var email = $("#" + id + "_email").html();
    var places = $("#" + id + "_places").html();
    var address = $("#" + id + "_address").html();
    myEditDialog(id, name, phone, email, places, address);
  });

  $(".deleteDriverButton").click(function() {
    var id = this.id;
    $(".modal").fadeOut(50);
    $("#editPassengerDialog").fadeOut(10);
    $.post('../src/php/forms.php', {
      'id': id,
      'deletePassenger': true
    }, function(data) {
      $("#passengers-block").html(data);
    });
  });

  $(".editDriverButton").click(function() {
    var id = this.id;
    $(".modal").fadeOut(50);
    $("#editPassengerDialog").fadeOut(10);
    $.post('../src/php/forms.php', {
      'id': id,
      'editPassenger': true,
      'e-passenger': $("#edit-input-1").val(),
      'e-phone': $("#edit-input-2").val(),
      'e-address': $("#edit-input-4").val(),
      'e-email': $("#edit-input-3").val(),
      'e-places': $("#edit-combo-0").val()
    }, function(data) {
      $("#passengers-block").html(data);
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

  $(".edit-delete-r").click(function() {
    event.stopPropagation();
    var box = this.getBoundingClientRect();
    var widthDropdown = $(".edit-delete-dropdown-r").css("width");
    var widthButton = $(".edit-delete-r").css("width");
    var width = parseInt(widthDropdown) - parseInt(widthButton);
    $(".edit-delete-dropdown-r").css("top", box.top + pageYOffset - 2);
    $(".edit-delete-dropdown-r").css("left", box.left - width + 2);
    $(".edit-delete-dropdown-r").attr("id", this.id, 10);
    $(".edit-delete-dropdown-r").fadeIn(20);
  });
}

function myDeleteDialog(id, name) {
  $("#deleteDriverTitle").html(name + " будет удален. Продолжить?");
  $(".deleteDriverButton").attr("id", id);
}

function myEditDialog(id, name, phone, email, places, address) {
  $("#editDriverTitle").html(name + " — Редактирование");
  $("#edit-input-1").attr("value", name);
  $("#edit-input-2").attr("value", phone);
  $("#edit-input-3").attr("value", email);
  $("#edit-input-4").attr("value", address);
  $("#value_" + places).attr("selected", "selected");
  $(".editDriverButton").attr("id", id);
}
