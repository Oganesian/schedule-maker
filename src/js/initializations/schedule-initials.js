var parentId = "";

$(document).ready(function() {

  $("#createScheduleMonth").click(function() {
    if($("#input-1").val() != ""){
      $(".ld-ring").css("display", "inline-block");
      $(this).attr("value", "Создание...");
    }
  });

  $("#delete").click(function() {
    $('.edit-delete-dropdown').fadeOut(20);
    $(".modal").fadeIn(50);
    $("#deleteDriveDialog").fadeIn(50);
    var id = $(".edit-delete-dropdown").attr("id");
    var date = $("#" + id + "_date").html();
    myDeleteDialog(id, date);
  });

  $(".save").click(function() {
    var id = this.id;//$(".save-dropdown").attr("id");
    id = id.replace("-button", "-table");
    saveAsPDF(id);
  });

  $("#edit").click(function() {
    $('.edit-delete-dropdown').fadeOut(20);
    $(".modal").fadeIn(50);
    $("#editDriveDialog").fadeIn(50);
    var ids = $(".edit-delete-dropdown").attr("id");
    var arrayOfStrings = ids.split("_");
    myEditDialog(ids, arrayOfStrings[1], arrayOfStrings[2]);
  });

  $(".deleteDriveButton").click(function() {
    var ids = this.id;
    var arrayOfStrings = ids.split("_");
    $(".modal").fadeOut(50);
    $("#deleteDriveDialog").fadeOut(10);
    $.post('../src/php/forms.php', {
      'passenger': arrayOfStrings[0],
      'date': arrayOfStrings[1],
      'driver': arrayOfStrings[2],
      'deleteDrive': true
    }, function(data) {
      $("#"+parentId).html(data);
    });
  });

  $(".okButton").click(function() {
    $(".modal").fadeOut(50);
    $("#differentPasswordsDialog").fadeOut(10);
  });

  $(".editScheduleButton").click(function() {
    var ids = this.id;
    var arrayOfStrings = ids.split("_");
    $(this).html("Обработка...");
      $.post('../src/php/forms.php', {
        "editSchedules": true,
        'id_passenger': arrayOfStrings[0],
        'date': arrayOfStrings[1],
        'id_publisher': arrayOfStrings[2],
        'id_publisher_new': $("#combo-1").val(),
        'date_new': $("#input-2").val()
      }, function (data) {
        $("#"+parentId).html(data);
        $(".modal").fadeOut(50);
        $(".dialog").fadeOut(10);
        $(this).html("Изменить");
      });
  });

  setButtonClick();
});

function setButtonClick() {

  $(".edit-delete").click(function() {
    event.stopPropagation();
    $(".dropdown").fadeOut(20);
    var box = this.getBoundingClientRect();
    var widthDropdown = $(".edit-delete-dropdown").css("width");
    var widthButton = $(".edit-delete").css("width");
    var width = parseInt(widthDropdown) - parseInt(widthButton);
    parentId = $(this).closest('.table-block').attr('id');
    $(".edit-delete-dropdown").css("top", box.top + pageYOffset - 2);
    $(".edit-delete-dropdown").css("left", box.left - width + 2);
    $(".edit-delete-dropdown").attr("id", this.id);
    $(".edit-delete-dropdown").fadeIn(20);
  });

  /*$(".save").click(function() {
    event.stopPropagation();
    $(".dropdown").fadeOut(20);
    var box = this.getBoundingClientRect();
    var widthDropdown = $(".save-dropdown").css("width");
    var widthButton = $(".save").css("width");
    var width = parseInt(widthDropdown) - parseInt(widthButton);
    $(".save-dropdown").css("top", box.top + pageYOffset - 2);
    $(".save-dropdown").css("left", box.left - width + 2);
    $(".save-dropdown").attr("id", this.id);
    $(".save-dropdown").fadeIn(20);
  });*/
}

function getTableData(id){
  var myTableArray = [];
  var headers = ['Кто забирает', 'Дата', 'День недели', 'Примечание'];
  myTableArray.push(headers);
  var firstDate = $("table#"+id+" td:eq( 1 )").text();
  var month = firstDate.substr(3, 2);
  $("table#"+id+" tr").each(function() {
    var arrayOfThisRow = [];
    var tableData = $(this).find('td');
    if (tableData.length > 0) {
      if (!($(tableData[1]).text().substr(3, 2) == month)){
        return;
      }
      tableData.each(function() {
        if($(this).text() != "•••"){
          arrayOfThisRow.push($(this).text());
        }
      });
      myTableArray.push(arrayOfThisRow);
    }
  });
  return myTableArray;
}

function saveAsPDF(id) {
  var sourceData = getTableData(id);
  var bodyData = [];
  var monthAndYear = sourceData[1][1].substr(3, 7);
  var name = id.replace("-table", "");
  var fileName = name + " " + monthAndYear;
  sourceData.forEach(function(sourceRow) {
    var dataRow = [];
    dataRow.push(sourceRow[0]);
    dataRow.push(sourceRow[1]);
    dataRow.push(sourceRow[2]);
    dataRow.push(sourceRow[3]);
    bodyData.push(dataRow)
  });

  var docDefinition = {
    content:
    {
      style: 'tableExample',
      table: {
        headerRows: 1,
        widths: [ '25%', '25%', '25%', '25%'],
        body: bodyData
      },
      layout: {
        fillColor: function (i, node) {
          return ((i % 2 === 0) && (i !== 0)) ? '#CCCCCC' : null;
        }
      }
    },
    styles: {
      tableExample: {
        margin: [0, 5, 0, 15],
        fontSize: 13,
        alignment: 'center'
      }
    }
  }
  pdfMake.createPdf(docDefinition).download(fileName+'.pdf');
}

function myDeleteDialog(id, date) {
  $("#deleteDriveTitle").html(date + " - удаление. Продолжить?");
  $(".deleteDriveButton").attr("id", id);
}

function myEditDialog(ids, date, id_publisher) {
    var correctFormat = date.substr(6, 4) + "-" + date.substr(3, 2) + "-" + date.substr(0, 2);
  $("#value_" + id_publisher).attr("selected", "selected");
  $("#input-2").val(correctFormat);
  $(".editScheduleButton").attr("id", ids);
}
