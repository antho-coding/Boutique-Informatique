// Ce fichier js sert uniquement à recharger la partie du fichier js d'origine pour la requete ajax et que l'event click du bouton fonctionne

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
