import * as utils from './utils.js';
const url = utils.API_DIR + "vendor_products.php";
displayMainContent();

async function displayMainContent() {
    generateMainContent(await utils.makePostRequest(url, new FormData()));
}

function generateMainContent(result) {
    // <section>
    //     <h2>I tuoi prodotti</h2>
    //     <ul>
    //         <?php if(isset($templateParams["products"]) && count($templateParams["products"]) > 0):
    //             foreach($templateParams["products"] as $product): ?>
    //                 <li>
    //                     <a href="<?php echo PAGES_DIR."product.php?search=".$product["idProdotto"] ?>">
    //                         <img src="<?php echo DB_RESOURCES_DIR.$product['link']?>" alt="Immagine Prodotto"/><br/>
    //                         <?php echo $product["nome"] ?>
    //                     </a><br/>
    //                     <?php if($product["offerta"] > 0) {
    //                         echo "<ins>".$product["offerta"]."% ".$product['prezzoScontato']."</ins> <del>".$product['prezzo']."</del> €";
    //                     } else {
    //                         echo "<p>".$product['prezzo']." €</p>";
    //                     }?>
    //                     <p><?php echo $product['media_recensioni']."/5 (".$product['num_recensioni'].")" ?></p>
    //                     <p>Disponibili: <?php echo $product["quantitaDisponibile"] ?></p>
    //                     <p>Descrizione: <?php echo $product["descrizione"] ?></p>
    //                     <a href="manage_product.php?product=<?php echo $product['idProdotto'] ?>"><button type="button">Modifica<img src="<?php echo RESOURCES_DIR."matita.png"?>" alt="" name ="modify"/></button><a>
    //                     <form action='#' method="POST">
    //                         <input type="hidden" name="id" value="<?php echo $product['idProdotto'] ?>">
    //                         <button type="submit">Elimina<img src="<?php echo RESOURCES_DIR."cestino_B.png"?>" alt="" name ="delete" /></button>
    //                     </form>
    //                 </li>
    //             <?php endforeach;
    //         endif; ?>
    //     </ul>
    // </section>

    document.querySelector('main').innerHTML = "";

    const products = result['results'];

    const section = document.createElement('section');

    const h2 = document.createElement('h2');
    h2.textContent = 'I tuoi Prodotti';

    const ul = document.createElement('ul');

    for (let i = 0; i < products.length; i++) {
        const product = products[i];
        const li = document.createElement('li');
                
        const a = document.createElement('a');
        a.href = utils.PAGES_DIR + 'product.php?search=' + product['idProdotto'];
        
        const img = document.createElement('img');
        img.src = utils.DB_RESOURCES_DIR + product['link'];
        img.alt = "Immagine Prodotto";

        const p = document.createElement('p');
        p.textContent = product['nome'];

        const price = document.createElement('p');
        if (product["offerta"] > 0) {
            price.innerHTML = `<ins>${product["offerta"]}% ${product['prezzoScontato']}</ins> <del>${product["prezzo"]}</del> €"`;;
        } else {
            price.innerText = product['prezzo'] + '€';            
        }
        
        const p1 = document.createElement('p');
        p1.innerText = product['media_recensioni'].substring(0, 3) + " (" + product['num_recensioni'] + ")";
        p1.appendChild(utils.generateReviewStars(product['media_recensioni']));

        const p2 = document.createElement('p');
        p2.innerText = 'Disponibilità: ' + product['quantitaDisponibile'];

        const p3 = document.createElement('p');
        p3.innerText = product['descrizione'];

        const editImg = document.createElement('img');
        editImg.src = utils.RESOURCES_DIR + 'matita.png';
        editImg.alt = '';

        const editButton = document.createElement('button');
        editButton.textContent = 'Modifica';
        editButton.appendChild(editImg);
        editButton.addEventListener('click', (event) => {
            event.preventDefault();
            location.href = utils.PAGES_DIR + 'manage_product.php' + '?id=' + product['idProdotto'];
        });

        
        a.appendChild(img);
        a.appendChild(p);
        a.appendChild(price);
        a.appendChild(p1);
        a.appendChild(p2);
        a.appendChild(p3);
        a.appendChild(editButton);

        li.appendChild(a);
        ul.appendChild(li);
    }
    
    section.appendChild(ul);
    document.querySelector('main').appendChild(section);
}