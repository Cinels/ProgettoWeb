import * as utils from './utils.js';
const getParams = window.location.search;
const url = utils.API_DIR + "product.php" + getParams;
displayMainContent();

async function displayMainContent() {
    generateMainContent(await utils.makePostRequest(url, new FormData()));
}

function generateMainContent(result) {
    // <section>
    //     <section>
    //         <section>Prodotto</section>
    //         <form>Interazioni</form>
    //         <p><?php echo $result["descrizione"] ?></p>
    //         <p><?php echo $result["proprieta"] ?></p>
    //         <section>Recensioni</section>
    //     </section>
    // </section>
    
    const product = result['result'][0];    
    document.querySelector('main').innerHTML = "";

    const outerSection = document.createElement('section');
    const section = document.createElement('section');

    section.appendChild(generateProductSection(product, result['images']));
    section.appendChild(generateInteractionForm(product['idProdotto'], result['isFavourite'], result['logged'], 
        result['cartQuantity'], product['quantitaDisponibile']));
    
    const h31 = document.createElement('h3');
    h31.textContent = 'Descrizione:';
    section.appendChild(h31);
    
    const p1 = document.createElement('p');
    p1.textContent = product['descrizione'];
    section.appendChild(p1);

    const h32 = document.createElement('h3');
    h32.textContent = 'Proprietà:';
    section.appendChild(h32);

    const p2 = document.createElement('p');
    p2.textContent = product['proprieta'];
    section.appendChild(p2);
    
    section.appendChild(generateReviewSection(product, result['hasBuyed'], result['hasReviewed'], result['userReview'], result['reviews'], result['n_rev']));
    outerSection.appendChild(section);
    document.querySelector('main').appendChild(outerSection);
}

function generateProductSection(product, images) {
    // <img src="${utils.DB_RESOURCES_DIR}${images[0]['link']}" alt="Immagine Prodotto"/><br/>
    // <!-- gestione delle immagini multiple -->

    // <h2>${product["nome"]}</h2>
    // if(product["offerta"] > 0) {
    //     const sale = product["prezzo"] - product["prezzo"]*(product["offerta"]/100);
    //     <ins>${product["offerta"]}% ${sale}</ins> <del>$product['prezzo']} €</del>";
    // } else {
    //     <p>${product['prezzo']} €</p>";
    // }?>
    // <a href="#Reviews">${product['media_recensioni']} + "/5 (" + product['num_recensioni'] + ")"<img src=utils.RESOURCES_DIR + "Marco_semplice_W.png" alt=""/></a>
    // <p>Venditore: "${product['idVenditore']</p>
    // const options = {'weekday': 'long', 'month': 'long', 'day': '2-digit'};
    // const date = new Date(new Date().setDate(new Date().getDate() + 1)).toLocaleString('it-IT', options);
    // <p>Consegna prevista per ${date}</p>
    // <p>Disponibili: ${product['quantitaDisponibile']}</p>
    
    const section = document.createElement('section');
    
    const mainImage = document.createElement('img');
    mainImage.src = utils.DB_RESOURCES_DIR + images[0]['link'];
    mainImage.alt = "Immagine Prodotto";
    
    const article = document.createElement('article');
    for(let i = 0; i < images.length; i++) {
        const img = document.createElement('img');
        img.src = utils.DB_RESOURCES_DIR + images[i]['link'];
        img.alt = `Immagine ${i} del Prodotto`;
        img.addEventListener('click', (event) => {
            event.preventDefault();
            clearImageSelection(article);
            img.setAttribute('selected', true);
            mainImage.src = img.src;
        });
        if (i == 0) {
            img.setAttribute('selected', true);
        }
        article.appendChild(img);
    }
    const h2 = document.createElement('h2');
    h2.textContent = product['nome'];
    
    const price = document.createElement('p');
    if (product["offerta"] > 0) {
        price.innerHTML = `<ins>${product["offerta"]}% ${product['prezzoScontato']}</ins> <del>${product["prezzo"]}</del>€`;;
    } else {
        price.innerText = product['prezzo'] + '€';            
    }

    const a = document.createElement('a');
    a.href = "#Reviews";
    a.textContent = product['media_recensioni'].substring(0, 3) + " (" + product['num_recensioni'] + ")";
    a.appendChild(utils.generateReviewStars(product['media_recensioni']));
    
    const p2 = document.createElement('p');
    p2.innerText = "Venditore: " + product['idVenditore'];

    const options = {'weekday': 'long', 'month': 'long', 'day': '2-digit'};
    const date = new Date(new Date().setDate(new Date().getDate() + 1)).toLocaleString('it-IT', options);
    const p3 = document.createElement('p');
    p3.innerText = "Consegna prevista per: " + date;

    const p4 = document.createElement('p');
    p4.innerText = "Disponibili: " + product['quantitaDisponibile'];

    section.appendChild(mainImage);
    section.appendChild(article);
    section.appendChild(h2);
    section.appendChild(price);
    section.appendChild(a);
    section.appendChild(p2);
    section.appendChild(p3);
    section.appendChild(p4);

    return section;
}

function generateInteractionForm(idProduct, isFavourite, user_type, cartQuantity, available) {
    // <form action="">'
    //     if (user_type === 'client') {
    //         <label for="quantity">Quantità: </label>
    //         <input type="number" id="quantity" name="cart" min="0" value="1">
    //         <button> Aggiungi al Carrello <img src="${utils.RESOURCES_DIR}carrello_B.png" alt=""/></button>
    //         if(isFavourite){
    //             <button>Rimuovi dai Preferiti<img src="${utils.RESOURCES_DIR}cuore_R.png" alt=""/></button>
    //         } else {
    //             <button>Aggiungi ai Preferiti<img src="${utils.RESOURCES_DIR}cuore_B.png" alt=""/></button>
    //         }
    //     } else {
    //         <button>Modifica<img src="${utils.RESOURCES_DIR}cuore_B.png" alt=""/></button>
    //     }
    // </form>

    const form = document.createElement('form');

    if (user_type === 'vendor') {
        const editImg = document.createElement('img');
        editImg.src = utils.RESOURCES_DIR + 'matita.png';
        editImg.alt = '';

        const editButton = document.createElement('button');
        editButton.textContent = 'Modifica';
        editButton.appendChild(editImg);
        editButton.addEventListener('click', (event) => {
            event.preventDefault();
            location.href = utils.PAGES_DIR + 'manage_product.php' + '?id=' + idProduct;
        });

        form.appendChild(editButton);
    } else {
        const innerForm = document.createElement('form');

        const label = document.createElement('label');
        label.setAttribute('for', 'quantity');
        label.textContent = 'Quantità:';

        const input = document.createElement('input');
        input.type = 'number';
        input.id = 'quantity';
        input.min = 0;
        input.max = available;
        input.value = 1;

        const minusButton = document.createElement('button');
        minusButton.type = 'button';
        minusButton.name = 'minus';
        minusButton.textContent = '-';
        minusButton.addEventListener('click', (event) => {
            event.preventDefault();
            if (Number(input.value) > Number(input.min)) input.value--;
        });

        const plusButton = document.createElement('button');
        plusButton.type = 'button';
        plusButton.name = 'plus';
        plusButton.textContent = '+';
        plusButton.addEventListener('click', (event) => {
            event.preventDefault();
            if (Number(input.value) < Number(input.max)) input.value++;
        });

        innerForm.addEventListener('submit', (event) => {
            event.preventDefault()
        });
        innerForm.appendChild(label);
        innerForm.appendChild(minusButton);
        innerForm.appendChild(input);
        innerForm.appendChild(plusButton);

        const cartImage = document.createElement('img');
        cartImage.src = utils.RESOURCES_DIR + "carrello_B.png";
        cartImage.alt = "";
        
        const cartButton = document.createElement('button');
        cartButton.type = 'button';
        cartButton.name = 'cart';
        cartButton.textContent = 'Aggiungi al Carrello';
        cartButton.addEventListener('click', (event) => {
            cartButtonListener(input.value, event, cartQuantity, available);
        });
        cartButton.appendChild(cartImage);

        const favouriteImage = document.createElement('img');
        favouriteImage.alt = '';
        const favouriteButton = document.createElement('button');
        favouriteButton.type = 'button';
        favouriteButton.name = 'favourite';
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

        form.appendChild(innerForm);
        form.appendChild(cartButton);
        form.appendChild(favouriteButton);
    }

    return form;
}

function generateReviewSection(product, hasBuyed, hasReviewed, userReview, reviews, n) {
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

    const header = document.createElement('header');
    
    const h3 = document.createElement('h3');
    h3.textContent = 'Recensioni:';
    header.appendChild(h3);

    const p = document.createElement('p');
    p.innerText = product['media_recensioni'].substring(0, 3) + " (" + product['num_recensioni'] + ")";
    p.appendChild(utils.generateReviewStars(product['media_recensioni']));
    header.appendChild(p);

    section.appendChild(header);

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
    text.name = 'reviewText';
    const textButton = document.createElement('button');
    textButton.addEventListener('click', (event) => {
        reviewButtonListener(textButton.name, stars.getAttribute('vote'), text.value, event);
    });

    if(hasBuyed) {
        let vote;
        if(hasReviewed && userReview != null) {
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

    for (let i = 0; i < reviews.length && i < n; i++) {
        const article = document.createElement('article');
        
        const h4 = document.createElement('h4');
        h4.textContent = reviews[i]['nome'] + " " + reviews[i]['cognome'];
        article.appendChild(h4);

        article.appendChild(utils.generateReviewStars(reviews[i]['voto'], `Voto: ${reviews[i]['voto']} su 5`));

        const p = document.createElement('p');
        p.innerText = reviews[i]['descrizione'];
        article.appendChild(p);

        section.appendChild(article);
    }

    const footer = document.createElement('footer');
    const morerev = document.createElement('a');
    morerev.href = '';
    if (!Number.isInteger(n)) {
        morerev.textContent = 'Mostra altro';
        morerev.addEventListener('click', async (event) => {
            reviewNumberListener('true', event);
        });
    } else {
        morerev.textContent = 'Mostra meno';
        morerev.addEventListener('click', async (event) => {
            reviewNumberListener('false', event);
        });
    }
    footer.appendChild(morerev);
    section.appendChild(footer);
    
    return section;
}

async function cartButtonListener(quantity, event, cartQuantity, available) {
    event.preventDefault();
    console.log('cart ' + quantity);
    const totalQuantity = Number(cartQuantity) + Number(quantity);
    
    if (totalQuantity <= available) {
        const formData = new FormData();
        formData.append('cart', quantity);
        const result = await utils.makePostRequest(url, formData);
        isClient(result);
    } else {
        utils.alertQuantity(totalQuantity, available);
    }
}

async function favouriteButtonListener(action, event) {
    event.preventDefault();
    console.log("favourite: " + action);

    const formData = new FormData();
    formData.append('favourite', action);
    const result = await utils.makePostRequest(url, formData);
    isClient(result);
}

async function reviewButtonListener(action, vote, description, event) {
    event.preventDefault();
    console.log("review: " + action + ', vote: ' + vote + ', description: ' + description);

    if(vote !== null && vote > 0) {
        const formData = new FormData();
        formData.append('vote', vote);
        formData.append('review', action);
        formData.append('description', description);
        const result = await utils.makePostRequest(url, formData);
        isClient(result);
    }
}

async function reviewNumberListener(action, event) {
    event.preventDefault();
    console.log('more_rev ' + action);

    const formData = new FormData();
    generateMainContent(await utils.makePostRequest(url + '&more_rev=' + action, formData));
}

function isClient(result) {
    if (result['logged'] === 'client') {
        generateMainContent(result);
    } else {
        location.href = utils.PAGES_DIR + (result['logged'] === 'vendor' ? 'profile.php' : 'login.php') ;
    }
}

function clearImageSelection(article) {
    for (let i = 0; i < article.children.length; i++) {
        article.children[i].removeAttribute('selected');
    }
}