import * as utils from './utils.js';
const getParams = window.location.search;
const url = utils.API_DIR + "results.php" + getParams;
displayMainContent();

async function displayMainContent() {
    generateMainContent(await utils.makePostRequest(url, new FormData()));
}

function generateMainContent(result) {
    // <section>
    //     <ul>
    //         <?php if(isset($templateParams["results"])):
    //             foreach($templateParams["results"] as $result): ?>
    //                 <li>
    //                     <a href="<?php echo PAGES_DIR ?>product.php?search=<?php echo $result["idProdotto"]?>"><img src="<?php echo DB_RESOURCES_DIR.$result["link"]?>" alt="Immagine Prodotto"/><br/>
    //                     <?php echo $result["nome"] ?></a>

    //                     <?php if($dbh->isLogged() && $dbh->getUserType() == "client"): 
    //                         if($dbh->isProductFavourite($result["idProdotto"])): ?>
    //                             <a href="?search=<?php echo $_GET["search"] ?>&id=<?php echo $result["idProdotto"]; ?>&favourites=remove <?php /*$dbh->removeFromFavourites($result["idProdotto"])*/ ?>"><img src="<?php echo RESOURCES_DIR?>cuore_R.png" alt="Rimuovi dai Preferiti"/></a>
    //                         <?php else: ?>
    //                             <a href="?search=<?php echo $_GET["search"] ?>&id=<?php echo $result["idProdotto"]; ?>&favourites=add <?php /*$dbh->addToFavourites($result["idProdotto"], $dbh->getUser()['email'])*/ ?>"><img src="<?php echo RESOURCES_DIR?>cuore_B.png" alt="Aggiungi ai Preferiti"/></a>
    //                         <?php endif;
    //                     endif; ?>
    //                     <?php if($result["offerta"] > 0) {
    //                         echo "<ins>".$result["offerta"]."% ".$result["prezzoScontato"]."</ins> <del>".$result['prezzo']." €</del>";
    //                     } else {
    //                         echo "<p>".$result['prezzo']." €</p>";
    //                     }?>
    //                     <?php if($dbh->isLogged() && $dbh->getUserType() == "client"): 
    //                         <a href="?search=<?php echo $_GET["search"] ?>&id=<?php echo $result["idProdotto"]; ?>&cart=add"><img src="<?php echo RESOURCES_DIR?>carrello_B.png" alt="Aggiungi al Carrello"/></a>
    //                     endif; ?>
    //                 </li>
    //             <?php endforeach;
    //         endif; ?>
    //     </ul>
    // </section>

    document.querySelector('main').innerHTML = "";

    const products = result['results'];

    const section = document.createElement('section');

    const ul = document.createElement('ul');

    for (let i = 0; i < products.length; i++) {
        const product = products[i];
        const li = document.createElement('li');
        
        const img = document.createElement('img');
        img.src = utils.DB_RESOURCES_DIR + product['link'];
        img.alt = "Immagine Prodotto";

        const h2 = document.createElement('h2');
        h2.textContent = product['nome'];

        const a = document.createElement('a');
        a.href = utils.PAGES_DIR + 'product.php?search=' + product['idProdotto'];
        a.appendChild(img);
        a.appendChild(h2);

        li.appendChild(a);

        if (result['user_type'] === 'client') {
            const isFavourite = result['favourites'].includes(product['idProdotto']);

            const favouriteImg = document.createElement('img');
            favouriteImg.src = utils.RESOURCES_DIR + (isFavourite ? 'cuore_R.png' : 'cuore_B.png');
            favouriteImg.alt = isFavourite ? 'Rimuovi dai Preferiti' : 'Aggiungi ai Preferiti' ;
            
            const favouriteButton = document.createElement('button');
            favouriteButton.appendChild(favouriteImg);
            favouriteButton.addEventListener('click', (event) => {
                favouriteButtonListener(isFavourite ? 'remove' : 'add', product['idProdotto'], event);
            });
            
            li.appendChild(favouriteButton);
        } 

        const price = document.createElement('p');
        if (product["offerta"] > 0) {
            price.innerHTML = `<ins>${product["offerta"]}% ${product['prezzoScontato']}</ins> <del>${product["prezzo"]}</del>€`;;
        } else {
            price.innerText = product['prezzo'] + '€';            
        }

        li.appendChild(price);

        if (result['user_type'] === 'client') {            
            const cartImg = document.createElement('img');
            cartImg.src = utils.RESOURCES_DIR + 'carrello_B.png';
            cartImg.alt = 'Aggiungi al Carrello';
            
            const cartButton = document.createElement('button');
            cartButton.appendChild(cartImg);
            cartButton.addEventListener('click', (event) => {
                cartButtonListener('add', product['idProdotto'], event, 
                    Number(result['cartQuantity'][product['idProdotto']]) + 1, result['available'][product['idProdotto']]);
            });

            li.appendChild(cartButton);
        }

        ul.appendChild(li);
    }
    
    section.appendChild(ul);
    document.querySelector('main').appendChild(section);
}

async function favouriteButtonListener(action, id, event) {
    event.preventDefault();
    console.log('favourite ' + action + " " + id);

    const formData = new FormData();
    formData.append('favourite', action);
    formData.append('id', id);
    generateMainContent(await utils.makePostRequest(url, formData));
}

async function cartButtonListener(action, id, event, quantity, available) {
    event.preventDefault();
    console.log('cart ' + action + " " + id);
    
    if (quantity <= available) {
        utils.alertInsertInCart();
        const formData = new FormData();
        formData.append('cart', action);
        formData.append('id', id);
        generateMainContent(await utils.makePostRequest(url, formData));
    } else {
        utils.alertQuantity(quantity, available);
    }
}