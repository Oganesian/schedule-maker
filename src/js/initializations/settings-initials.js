$(document).ready(function() {

  $("#addDriverExceptionForm").submit(function(event) {
    event.preventDefault();
    $("#loading-2").css("display", "block");
    $("#addDriverExceptionBtn").val("");
    $.post('../src/php/forms.php', {
      addDriverException: true,
      driver: $('#combo-driver').val(),
      date_e: $('#input-date').val(),
      type: $('#combo-type').val(),
    }, function(data) {
      $("#drivers-exceptions-block").html(data);
      $("#loading-2").css("display", "none");
      $("#addDriverExceptionBtn").val("Добавить");
      setButtonClick();
    });
  });

  $("#addNoMeetingDayForm").submit(function(event) {
    event.preventDefault();
    $("#loading-1").css("display", "block");
    $("#addNoMeetingDayBtn").val("");
    $.post('../src/php/forms.php', {
      addNoMeetingDay: true,
      date: $('#input-1').val()
    }, function(data) {
      $("#no-meeting-days-block").html(data);
      $("#loading-1").css("display", "none");
      $("#addNoMeetingDayBtn").val("Добавить");
      setButtonClick();
    });
  });

  $("#addPassengerExceptionForm").submit(function(event) {
    event.preventDefault();
    $("#loading-3").css("display", "block");
    $("#addPassengerExceptionBtn").val("");
    $.post('../src/php/forms.php', {
      addPassengerException: true,
      passenger: $('#combo-2').val(),
      date_p: $('#input-3').val()
    }, function(data) {
      $("#passengers-exceptions-block").html(data);
      $("#loading-3").css("display", "none");
      $("#addPassengerExceptionBtn").val("Добавить");
      setButtonClick();
    });
  });

  $("#delete-r").click(function() {
    $('.delete-r-dropdown').fadeOut(20);
    var ids = $(".delete-r-dropdown").attr("id");
    var arrayOfStrings = ids.split("_");
    $.post('../src/php/forms.php', {
      'deleteDriverException': true,
      'id': arrayOfStrings[0],
      'date': arrayOfStrings[1]
    }, function(data) {
      $("#drivers-exceptions-block").html(data);
    });
  });

  $("#delete").click(function() {
    $('.delete-dropdown').fadeOut(20);
    var id = $(".delete-dropdown").attr("id");
    $.post('../src/php/forms.php', {
      'deleteNoMeetingDay': true,
      'id': id
    }, function(data) {
      $("#no-meeting-days-block").html(data);
    });
  });

  $("#delete-p").click(function() {
    $('.delete-p-dropdown').fadeOut(20);
    var ids = $(".delete-p-dropdown").attr("id");
    var arrayOfStrings = ids.split("_");
    $.post('../src/php/forms.php', {
      'deletePassengerException': true,
      'id': arrayOfStrings[0],
      'date': arrayOfStrings[1]
    }, function(data) {
      $("#passengers-exceptions-block").html(data);
    });
  });

  $(".editDriverButton").click(function() {
    $(".modal").fadeOut(50);
    $("#editDriverDialog").fadeOut(10);
    $.post('../src/php/forms.php', {
      'editMeetingsDays': true,
      'e-weekday': $("#edit-combo-0").val(),
      'e-weekend': $("#edit-combo-1").val()
    }, function(data) {
      $("#meetings-days-block").html(data);
    });
  });

  $("#edit").click(function() {
    $('.edit-dropdown').fadeOut(20);
    $(".modal").fadeIn(50);
    $("#editDriverDialog").fadeIn(50);
    var weekday = $(".weekday-c").attr("id");
    var weekend = $(".weekend-c").attr("id");
    myEditDialog(weekday, weekend);
  });

  setButtonClick();
});

function setButtonClick() {

  $(".edit").click(function() {
    event.stopPropagation();
    var box = this.getBoundingClientRect();
    var widthDropdown = $(".edit-dropdown").css("width");
    var widthButton = $(".edit").css("width");
    var width = parseInt(widthDropdown) - parseInt(widthButton);
    $(".edit-dropdown").css("top", box.top + pageYOffset - 2);
    $(".edit-dropdown").css("left", box.left - width + 2);
    $(".edit-dropdown").attr("id", parseInt(this.id, 10));
    $(".edit-dropdown").fadeIn(20);
  });

  $(".delete").click(function() {
    event.stopPropagation();
    var cls;
    if ($(this).hasClass("del-r")) {
      cls = ".delete-r-dropdown";
    }
    else if ($(this).hasClass("del-p")) {
      cls = ".delete-p-dropdown";
    }else {
      cls = ".delete-dropdown";
    }
    var box = this.getBoundingClientRect();
    var widthDropdown = $(cls).css("width");
    var widthButton = $(".delete").css("width");
    var width = parseInt(widthDropdown) - parseInt(widthButton);
    $(cls).css("top", box.top + pageYOffset - 2);
    $(cls).css("left", box.left - width + 2);
    $(cls).attr("id", this.id);
    $(cls).fadeIn(20);
  });
}

function myEditDialog(weekday, weekend) {
  $("#value_" + weekday).attr("selected", "selected");
  $("#value_" + weekend).attr("selected", "selected");
}
