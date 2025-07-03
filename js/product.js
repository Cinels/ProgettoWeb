import * as utils from './utils.js';
const getParams = window.location.search;
const url = utils.API_DIR + "product.php" + getParams;
displayMainContent();

async function displayMainContent() {
    generateMainContent(await utils.makePostRequest(url, new FormData()));
}

function generateMainContent(result) {
    // <section>
    //     <section>Prodotto</section>
    //     <form>Interazioni</form>
    //     <p><?php echo $result["descrizione"] ?></p>
    //     <p><?php echo $result["proprieta"] ?></p>
    //     <section>Recensioni</section>
    // </section>
    
    const product = result['result'][0];    
    document.querySelector('main').innerHTML = "";

    const section = document.createElement('section');

    section.appendChild(generateProductSection(product, result['images']));
    section.appendChild(generateInteractionForm(product, result['isFavourite']));
    
    const p1 = document.createElement('p');
    p1.textContent = product['descrizione'];
    section.appendChild(p1);

    const p2 = document.createElement('p');
    p2.textContent = product['proprieta'];
    section.appendChild(p2);
    
    section.appendChild(generateReviewSection(product, result['hasBuyed'], result['hasReviewed'], result['userReview'], result['reviews']));

    const main = document.querySelector('main');
    main.appendChild(section);
}

function generateProductSection(product, images) {
    // <img src="${utils.DB_RESOURCES_DIR}${images[0]['link']}" alt="Immagine Prodotto"/><br/>
    // <!-- gestione delle immagini multiple -->

    // <h2>${product["nome"]}</h2>
    // <a href="#Reviews">${product['media_recensioni']} + "/5 (" + product['num_recensioni'] + ")"<img src=utils.RESOURCES_DIR + "Marco_semplice_W.png" alt=""/></a>
    // if(product["offerta"] > 0) {
    //     const sale = product["prezzo"] - product["prezzo"]*(product["offerta"]/100);
    //     <ins>${product["offerta"]}% ${sale}</ins> <del>$product['prezzo']} €</del>";
    // } else {
    //     <p>${product['prezzo']} €</p>";
    // }?>
    // <p>Venditore: "${product['idVenditore']</p>
    // const options = {'weekday': 'long', 'month': 'long', 'day': '2-digit'};
    // const date = new Date(new Date().setDate(new Date().getDate() + 1)).toLocaleString('it-IT', options);
    // <p>Consegna prevista per ${date}</p>
    
    const section = document.createElement('section');
    
    const mainImage = document.createElement('img');
    mainImage.src = utils.DB_RESOURCES_DIR + images[0]['link'];
    mainImage.alt = "Immagine Prodotto";
    
    const article = document.createElement('article');
    for(let i = 0; i < images.lenght; i++) {
        const img = document.createElement('img');
        img.src = utils.DB_RESOURCES_DIR + images[i]['link'];
        img.alt = '';
        img.addEventListener('click', (event) => {
            event.preventDefault();
            mainImage.src = img.src;
        });
        article.appendChild(img);
    }
    const h2 = document.createElement('h2');
    h2.textContent = product['nome'];
    
    const a = document.createElement('a');
    a.href = "#Reviews";
    a.textContent = product['media_recensioni'].substring(0, 3) + " (" + product['num_recensioni'] + ")";
    a.appendChild(utils.generateReviewStars(product['media_recensioni']));
    
    const price = document.createElement('p');
    if (product["offerta"] > 0) {
        const sale = product["prezzo"] - product["prezzo"]*(product["offerta"]/100);
        price.innerHTML = `<ins>${product["offerta"]}% ${sale}</ins> <del>${product["prezzo"]}</del> €"`;;
    } else {
        price.innerText = product['prezzo'] + '€';            
    }

    const p2 = document.createElement('p');
    p2.innerText = "Venditore: " + product['idVenditore'];

    const options = {'weekday': 'long', 'month': 'long', 'day': '2-digit'};
    const date = new Date(new Date().setDate(new Date().getDate() + 1)).toLocaleString('it-IT', options);
    const p3 = document.createElement('p');
    p3.innerText = "Consegna prevista per: " + date;

    section.appendChild(mainImage);
    section.appendChild(article);
    section.appendChild(h2);
    section.appendChild(a);
    section.appendChild(price);
    section.appendChild(p2);
    section.appendChild(p3);

    return section;
}

function generateInteractionForm(product, isFavourite) {
    // <form action="">
    //     <label for="quantity">Quantità: </label>
    //     <input type="number" id="quantity" name="cart" min="0" value="1">
    //     <button> Aggiungi al Carrello <img src="${utils.RESOURCES_DIR}carrello_B.png" alt=""/>
    //     if(isFavourite){
    //         <button>Rimuovi dai Preferiti<img src="${utils.RESOURCES_DIR}cuore_R.png" alt=""/>
    //     } else {
    //         <button>Aggiungi ai Preferiti<img src="${utils.RESOURCES_DIR}cuore_B.png" alt=""/>
    //     }
    // </form>

    const form = document.createElement('form');

    const label = document.createElement('label');
    label.setAttribute = 'quantity';
    label.textContent = 'Quantità';

    const input = document.createElement('input');
    input.type = 'number';
    input.min = 0;
    input.value = 1;

    const cartImage = document.createElement('img');
    cartImage.src = utils.RESOURCES_DIR + "carrello_B.png";
    cartImage.alt = "";
    
    const cartButton = document.createElement('button');
    cartButton.textContent = 'Aggiungi al Carrello';
    cartButton.addEventListener('click', (event) => {
        cartButtonListener(input.value, event);
    });
    cartButton.appendChild(cartImage);

    const favouriteImage = document.createElement('img');
    favouriteImage.alt = '';
    const favouriteButton = document.createElement('button');
    if(isFavourite) {
        favouriteImage.src = utils.RESOURCES_DIR + 'cuore_R.png';
        favouriteButton.textContent = 'Rimuovi dai Preferiti';
        favouriteButton.addEventListener('click', (event) => {
            favouriteButtonListener('remove', event);
        });
    } else {
        favouriteImage.src = utils.RESOURCES_DIR + 'cuore_B.png';
        favouriteButton.textContent = 'Aggiungi ai Preferiti';
        favouriteButton.addEventListener('click', (event) => {
            favouriteButtonListener('add', event);
        });
    }
    favouriteButton.appendChild(favouriteImage);

    form.appendChild(label);
    form.appendChild(input);
    form.appendChild(cartButton);
    form.appendChild(favouriteButton);

    return form;
}

function generateReviewSection(product, hasBuyed, hasReviewed, userReview, reviews) {
    // <section id="Reviews">
    //     <h3>Recensioni</h3>
    //     <p>${product['media_recensioni']}/5 (${product['num_recensioni']})</p>
    //     if(hasBuyed && !hasReviewed) {
    //         <a href="write_review.php?id=${product["idProdotto"]}">Lascia una recensione</a>
    //     } elseif(hasBuyed) {
    //         <a href="write_review.php?id=${product["idProdotto"]}">Modifica recensione</a>
    //     }
    //     <?php require_once("reviews.php"); ?>
    // </section>
        
    const section = document.createElement('section');
    section.id = 'Reviews';

    const h3 = document.createElement('h3');
    h3.textContent = 'Recensioni';
    section.appendChild(h3);

    const p = document.createElement('p');
    p.innerText = product['media_recensioni'].substring(0, 3) + " (" + product['num_recensioni'] + ")";
    p.appendChild(utils.generateReviewStars(product['media_recensioni']));
    section.appendChild(p);

    const stars = document.createElement('img');
    stars.alt = "Inserisci Voto";
    stars.addEventListener('click', (event) => {
        event.preventDefault();
        const vote = (event.offsetX*5/stars.width + 0.5).toFixed(0);

        console.log('vote: ' + vote);

        stars.src = utils.RESOURCES_DIR + vote + '_star.png';
        stars.setAttribute('vote', vote);
    });
    const text = document.createElement('textarea');
    const textButton = document.createElement('button');
    textButton.addEventListener('click', (event) => {
        reviewButtonListener(stars.getAttribute('vote'), textButton.name, event);
    });

    if(hasBuyed) {
        let vote;
        if(hasReviewed) {
            vote = userReview['voto'];
            stars.setAttribute('vote', vote);
            text.value = userReview['descrizione'];
            textButton.textContent = 'Modifica Recensione';
            textButton.name = 'edit';
        } else {
            vote = 0;
            textButton.textContent = 'Effettua Recensione';
            textButton.name = 'add';
        }
        stars.src = utils.RESOURCES_DIR + vote + '_star.png';

        section.appendChild(stars);
        section.appendChild(text);
        section.appendChild(textButton);
    }

    for (let i = 0; i < reviews.lenght; i++) {
        const article = document.createElement('article');
        article.appendChild(utils.generateReviewStars(reviews[i]['voto'], `Voto: ${reviews[i]['voto']} su 5`));

        const p = document.createElement('p');
        p.innerText = reviews[i]['descrizione'];
        article.appendChild(p);

        section.appendChild(article);
    }
    
    return section;
}

async function cartButtonListener(quantity, event) {
    event.preventDefault();
    console.log('cart ' + quantity);
    
    const formData = new FormData();
    formData.append('cart', quantity);
    generateMainContent(await utils.makePostRequest(url, formData));
}

async function favouriteButtonListener(action, event) {
    event.preventDefault();
    console.log("favourite: " + action);

    const formData = new FormData();
    formData.append('favourite', action);
    generateMainContent(await utils.makePostRequest(url, formData));
}

async function reviewButtonListener(vote, action, event) {
    event.preventDefault();
    console.log('vote: ' + vote + ", review: " + action);

    if(vote !== null && vote > 0) {
        const formData = new FormData();
        formData.append('vote', vote);
        formData.append('review', action);
        generateMainContent(await utils.makePostRequest(url, formData));
    }
}