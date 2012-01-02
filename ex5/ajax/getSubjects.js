$(function() {
  getSubjects()
  $("#subject_list").tablesorter()
})

function getSubjects() {

  var faculty = $("#faculty").val()
  var url = "./getSubjects.php?faculty=" + faculty

  $.ajax(url).done(function(subjects) {
    $("tr.subject").remove()

    var subjects_table = $("#subject_list tbody")

    for (var i = subjects.length - 1; i >= 0; i--){
      var row = "<tr class='subject'>"
      row += "<td>" + subjects[i].code + "</td>"
      row += "<td>" + subjects[i].title + "</td>"
      row += "<td>" + subjects[i].lecturer + "</td>"
      row += "<td>" + subjects[i].description + "</td>"
      row += "</td>"

      subjects_table.append(row)
      subjects_table.trigger("update")
    }
  })
}