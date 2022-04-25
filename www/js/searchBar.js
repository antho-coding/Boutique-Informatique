//request Ajax for search bar user

$("#search").on("keyup", function () {
  let resultSearch = $("#search").val();

  $.get("index.php", "action=shop&search=" + resultSearch, function (response) {
    $("#displaySearch").empty();
    $("#displayProduct").empty();
    $("#displaySearch").html(response);
  });
});

//request  Ajax for search bar Admin

$("#searchShop").on("keyup", function () {
  let resultSearch = $("#searchShop").val();

  console.log("coucou");

  $.get("index.php", "action=searchShopAdmin&search=" + resultSearch, function (response) {
    $("#displaySearchShop").empty();
    $("#displayShop").empty();
    $("#displaySearchShop").html(response);
  });
});
