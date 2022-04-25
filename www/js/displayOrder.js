let select = document.getElementById("choice-order");

function displayDetailOrder() {
  let idOrder = $("#choice-order option:selected").val();

  if (idOrder > 0) {
    $.get("index.php", "action=choiceOrderUser&idOrder=" + idOrder, function (response) {
      $("#choiceOrder").html(response);
      $("#container-product").empty();
      $("#download-btn").empty();
    });
  } else {
    $("#container-product").empty();
  }
}

document.addEventListener("DOMContentLoaded", function () {
  if (select) {
    select.addEventListener("change", displayDetailOrder);
  }
});
