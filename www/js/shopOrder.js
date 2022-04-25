//variables globales
let productGlobal = [];
let amountGlobalOrder = 0;
let symbol = " €";
let btnBasket = document.getElementById("show-basket");

//recuperer les valeur du html, et preparer l'insertion
$(".add-caddie").on("click", function () {
  // Ici on recupere notre classe de base que on concaténe avec la recuperation de l'id
  // Coté phtml on a la meme chose pour avoir des classe qui correspondent
  let quantity = $(".input-quantity" + $(this).data("id")).val();

  //recuperation des valeurs via data
  let product = $(this).data("product");
  let description = $(this).data("description");
  let price = $(this).data("price");
  let id = $(this).data("id");

  // Ici on gére les message d'ajout et d'erreur
  // Si la quantité est egal à 0 alors on indique un message et on ne push pas
  if (quantity == 0) {
    $(".add-text" + $(this).data("id"))
      .text("Merci de choisir une quantité")
      .css("color", "red");
    $(".small-hidden").addClass("show-small");
    //sinon on push et on indique l'ajout au panier
  } else {
    $(".add-text" + $(this).data("id"))
      .text("Ajouté au panier")
      .css("color", "green");
    $(".small-hidden").addClass("show-small");
    let addProduct = [product, description, price, id, quantity];
    productGlobal.push(addProduct);
  }

  addProductStorage();
  getProductStorage();
  shoppingCart();
});

// fonction pour ajouter les produits au storage
function addProductStorage() {
  productGlobal = JSON.stringify(productGlobal);

  localStorage.setItem("panier", productGlobal);
}

//recuperation des produits du storage
function getProductStorage() {
  productGlobal = localStorage.getItem("panier");

  if (productGlobal != null) {
    productGlobal = JSON.parse(productGlobal);
  } else {
    productGlobal = [];
  }
}

//affichage du storage/basket
function displayBasket() {
  getProductStorage();

  $("#show-detail-basket").empty();
  $("#head-detail-basket").empty();

  amountGlobalOrder = 0;

  if (productGlobal.length == 0) {
    //gestion de l'affichage dans le cas d'un panier vide
    $("#show-detail-basket").html("<p>Votre panier est vide</p>");
    $("#confirm-order").addClass("show-btn");
    $("#visible-validate").addClass("show-btn");
    $("#show-amount").empty();
    $("#head-detail-basket").empty();
  } else {
    $("#head-detail-basket").append("<tr><th>Produit</th><th>Prix TTC</th><th>Quantité</th><th>Prix total</th></tr>");
    for (let i = 0; i < productGlobal.length; i++) {
      let amountOrder = productGlobal[i][2] * productGlobal[i][4];
      amountGlobalOrder += amountOrder;

      $("#show-detail-basket").append("<tr><td><a data-id ='" + i + "' data-label ='Produit'>" + productGlobal[i][0] + "</a></td><td><a data-id ='" + i + "' data-label ='Prix TTC'>" + productGlobal[i][2] + symbol + "</a></td><td><a data-id ='" + i + "' data-label ='Quantité'>" + productGlobal[i][4] + "</a></td><td><a data-id ='" + i + "' data-label ='Prix Total'>" + amountOrder.toFixed(2) + symbol + "</a></td><td class='container-btn-del'><button data-id ='" + i + "' class='btn-del' type=" + "button" + ">Supprimer</button></td></tr>");
    }

    $("#show-detail-basket .btn-del").on("click", delProduct);
  }
  if (amountGlobalOrder > 0) {
    $("#show-amount").html("<p class=" + "amount-text" + ">Le prix total de votre commande est de " + amountGlobalOrder.toFixed(2) + " €" + "</p>");
  }
}

//confirmation de commande
function confirmOrder() {
  getProductStorage();
  productGlobal = JSON.stringify(productGlobal);

  $.get("index.php", "action=showCaddie&productBasket=" + productGlobal + "&amount=" + amountGlobalOrder, function (response) {
    //vider le local storage
    localStorage.clear();
    productGlobal = [];

    //nettoyer l'affichage
    $("#show-detail-basket").empty();
    $("#head-detail-basket").empty();
    $("#show-amount").empty();
    $("#confirm-order").addClass("show-btn");
    shoppingCart();

    //message de confirmation de commande

    $("#show-detail-basket").html("Votre commande d'un montant de " + amountGlobalOrder.toFixed(2) + " €" + " à bien été passée, nous vous enverrons un mail dés que vos produits en boutique seront disponibles");
  });
}

//Delete les produits
function delProduct() {
  let id = $(this).data("id");
  productGlobal.splice(id, 1);
  productGlobal = JSON.stringify(productGlobal);
  localStorage.setItem("panier", productGlobal);

  getProductStorage();
  shoppingCart();
  displayBasket();
}

//compteur d'articles
function shoppingCart() {
  getProductStorage();

  let countProduct = productGlobal.length;

  if (countProduct != 0) {
    $("#shopping span").text(countProduct);
  } else {
    $("#shopping span").empty();
  }
}

//code principal
$(function () {
  btnBasket.addEventListener("click", displayBasket());
  $("#confirm-order").on("click", confirmOrder);
  shoppingCart();
});
