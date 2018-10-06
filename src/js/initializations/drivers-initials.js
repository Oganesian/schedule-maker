$(document).ready(function() {

  $("#addDriverForm").submit(function(event) {
    event.preventDefault();
    $("#loading-1").css("display", "block");
    $("#createDriverBtn").val("");
    $.post('../src/php/forms.php', {
      createDriver: true,
      driver: $('#input-1').val(),
      phone: $('#input-2').val(),
      email: $('#input-3').val(),
      places: $('#combo-0').val()
    }, function(data) {
      $('#combo-0 option').eq(0).prop('selected', true);
      $('#input-1').val("");
      $('#input-2').val("");
      $('#input-3').val("");
      $("#drivers-block").html(data);
      $("#loading-1").css("display", "none");
      $("#createDriverBtn").val("Добавить");
      setButtonClick();
    });
  });

  $("#createRelationForm").submit(function(event) {
    event.preventDefault();
    $("#loading-2").css("display", "block");
    $("#createRelationBtn").val("");
    $.post('../src/php/forms.php', {
      createRelation: true,
      driver: $('#combo-1').val(),
      passenger: $('#combo-2').val()
    }, function(data) {
      $('#combo-1 option').eq(0).prop('selected', true);
      $('#combo-2 option').eq(0).prop('selected', true);
      $("#relations-block").html(data);
      $("#loading-2").css("display", "none");
      $("#createRelationBtn").val("Добавить");
      setButtonClick();
    });
  });

  $("#edit-r").click(function() {
    $('.edit-delete-dropdown-r').fadeOut(20);
    var ids = $(".edit-delete-dropdown-r").attr("id");
    var arrayOfStrings = ids.split("_");
    $.post('../src/php/forms.php', {
      'id_publisher': arrayOfStrings[0],
      'id_passenger': arrayOfStrings[1],
      'changeActive': true
    }, function(data) {
      $("#relations-block").html(data);
    });
  });

  $("#delete-r").click(function() {
    $('.edit-delete-dropdown-r').fadeOut(20);
    var ids = $(".edit-delete-dropdown-r").attr("id");
    var arrayOfStrings = ids.split("_");
    $.post('../src/php/forms.php', {
      'id_publisher': arrayOfStrings[0],
      'id_passenger': arrayOfStrings[1],
      'deleteRelation': true
    }, function(data) {
      $("#relations-block").html(data);
    });
  });

  $("#delete").click(function() {
    $('.edit-delete-dropdown').fadeOut(20);
    $(".modal").fadeIn(50);
    $("#deleteDriverDialog").fadeIn(50);
    var id = $(".edit-delete-dropdown").attr("id");
    var name = $("#" + id + "_name").html();
    myDeleteDialog(id, name);
  });

  $("#edit").click(function() {
    $('.edit-delete-dropdown').fadeOut(20);
    $(".modal").fadeIn(50);
    $("#editDriverDialog").fadeIn(50);
    var id = $(".edit-delete-dropdown").attr("id");
    var name = $("#" + id + "_name").html();
    var phone = $("#" + id + "_phone").html();
    var email = $("#" + id + "_email").html();
    var places = $("#" + id + "_places").html();
    var last_date = $("#" + id + "_last_date").html();
    myEditDialog(id, name, phone, email, places, last_date);
  });

  $(".deleteDriverButton").click(function() {
    var id = this.id;
    $(".modal").fadeOut(50);
    $("#deleteDriverDialog").fadeOut(10);
    $.post('../src/php/forms.php', {
      'id': id,
      'deleteDriver': true
    }, function(data) {
      $("#drivers-block").html(data);
      $.post('../src/php/forms.php', {
        'updateCreateRelationForm': true
      }, function(data) {
        $("#createRelationForm").html(data);
      });
      $.post('../src/php/forms.php', {
        'updateRelations': true
      }, function(data) {
        $("#relations-block").html(data);
      });
    });
  });

  $(".editDriverButton").click(function() {
    var id = this.id;
    $(".modal").fadeOut(50);
    $("#editDriverDialog").fadeOut(10);
    $.post('../src/php/forms.php', {
      'id': id,
      'editDriver': true,
      'e-driver': $("#edit-input-1").val(),
      'e-phone': $("#edit-input-2").val(),
      'e-email': $("#edit-input-3").val(),
      'e-places': $("#edit-combo-0").val()
    }, function(data) {
      $("#drivers-block").html(data);
      $.post('../src/php/forms.php', {
        'updateCreateRelationForm': true
      }, function(data) {
        $("#createRelationForm").html(data);
      });
      $.post('../src/php/forms.php', {
        'updateRelations': true
      }, function(data) {
        $("#relations-block").html(data);
      });
    });
  });

  setButtonClick();

});

function setButtonClick() {
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

function myEditDialog(id, name, phone, email, places, last_date) {
  $("#editDriverTitle").html(name + " — Редактирование");
  $("#edit-input-1").attr("value", name);
  $("#edit-input-2").attr("value", phone);
  $("#edit-input-3").attr("value", email);
  $("#edit-input-4").attr("value", last_date);
  $("#value_" + places).attr("selected", "selected");
  $(".editDriverButton").attr("id", id);
}
