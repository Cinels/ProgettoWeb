import * as paths from './paths.js';
const url = paths.API_DIR + "cart.php";
displayMainContent();

async function displayMainContent() {
    try {
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }
        const json = await response.json();
        console.log(json);
        generateMainContent(json);
    } catch (error) {
        console.error(error.message);
    }
}

function generateMainContent(products) {
    // <section>
    //     <h2>Carrello</h2>
    //     <ul>
    //          foreach product in products:
    //              <li>content</li>
    //     </ul>
    // </section>
    
    document.querySelector('main').innerHTML = "";

    const section = document.createElement('section');
    const h2 = document.createElement('h2');
    h2.textContent ='Carrello';
    const ul = document.createElement('ul');
    
    for (let i = 0; i < !products['empty'] && products['result'].length; i++) {
        const product = products['result'][i];
        const li = document.createElement('li');        
        li.appendChild(generateProductSection(product));
        li.appendChild(generateInteractionForm(product));
        ul.appendChild(li);
    }
    
    section.appendChild(h2);
    section.appendChild(ul);
    const main = document.querySelector('main');
    main.appendChild(section);
}

function generateProductSection(product) {
    // <a href="${paths.PAGES_DIR}product.php?search=${product["idProdotto"]}">
    //     <img src="${paths.DB_RESOURCES_DIR}${product['link']}" alt="Immagine Prodotto"/><br/>
    //     ${product['nome']}<br/>`;

    //     if (product["offerta"] > 0) {
    //         const sale = product["prezzo"] - product["prezzo"]*(product["offerta"]/100);
    //         <ins>${product["offerta"]}% ${sale}</ins> <del>${product["prezzo"]}</del> €";
    //     } else {
    //         <p>${product["prezzo"]} €</p>;
    //     }

    //     <p>${product["media_recensioni"]} ${product["num_recensioni"]}</p>
    //     <p>Venditore: ${product["idVenditore"]}</p>
    //     <p>Consegna prevista per <?php echo strftime("%A %d %B", strtotime('+1 day', time())); ?></p>
    // </a>
    
    const a = document.createElement('a');
    a.href = paths.PAGES_DIR + 'product.php?search=' + product['idProdotto'];
    
    const img_product = document.createElement('img');
    img_product.src = paths.DB_RESOURCES_DIR + product['link'];
    img_product.alt = '';

    const span = document.createElement('span');
    span.textContent = product['nome'];

    const price = document.createElement('p');
    if (product["offerta"] > 0) {
        const sale = product["prezzo"] - product["prezzo"]*(product["offerta"]/100);
        price.innerHTML = `<ins>${product["offerta"]}% ${sale}</ins> <del>${product["prezzo"]}</del> €"`;;
        // content += `<ins>${product["offerta"]}% ${sale}</ins> <del>${product["prezzo"]}</del> €"`;
    } else {
        price.innerText = product['prezzo'] + '€';            
        // content += `<p>${product["prezzo"]} €</p>`;
    }
    
    const p1 = document.createElement('p');
    p1.innerText = product['media_recensioni'] + " " + product['num_recensioni'];

    const p2 = document.createElement('p');
    p2.innerText = product['idVenditore'];

    const p3 = document.createElement('p');
    p3.innerText = "Consegna prevista per: " + Date();

    a.appendChild(img_product);
    a.appendChild(span);
    a.appendChild(price);
    a.appendChild(p1);
    a.appendChild(p2);
    a.appendChild(p3);
    
    return a;
}

function generateInteractionForm(product) {
    // <form action="">
    //     <label for="quantity">Quantità: </label>
    //     <input type="number" id="quantity" name="quantity" min="0" value="${product["quantita"]}">;
    //     <button type='submit' name='remove'>Rimuovi<img src="${paths.RESOURCES_DIR}cestino_B.png" alt="" name='remove'></button>
    //     <button type='submit' name='favourite'>Sposta nei Preferiti<img src="${paths.RESOURCES_DIR}cuore_B.png" alt="" name='favourite'></button>
    // </form>
    
    const form = document.createElement('form');

    const label = document.createElement('label');
    label.setAttribute = 'quantity';
    label.textContent = 'Quantità: ';

    const input = document.createElement('input');
    input.type = 'number';
    input.min = 0;
    input.value = product['quantita'];
    input.addEventListener('change', (event) => {
        quantityListener(input.value, product['idProdotto'], event);
    })
    
    const removeImage = document.createElement('img');
    removeImage.src = paths.RESOURCES_DIR + 'cestino_B.png';
    removeImage.alt = '';
    
    const removeButton = document.createElement('button');
    removeButton.textContent = 'Rimuovi';
    removeButton.addEventListener('click', (event) => {
        buttonListener('remove', product['idProdotto'], event);
    });
    removeButton.appendChild(removeImage);

    const favouriteImage = document.createElement('img');
    favouriteImage.src = paths.RESOURCES_DIR + 'cuore_B.png';
    favouriteImage.alt = '';

    const favouriteButton = document.createElement('button');
    favouriteButton.textContent = 'Sposta nei Preferiti';
    favouriteButton.addEventListener('click', (event) => {
        buttonListener('favourite', product['idProdotto'], event);
    });
    favouriteButton.appendChild(favouriteImage);
    
    form.appendChild(label);
    form.appendChild(input);
    form.appendChild(removeButton);
    form.appendChild(favouriteButton);

    return form;
}

async function buttonListener(action, id, event) {
    event.preventDefault();
    
    console.log(action + " " + id);

    const formData = new FormData();
    formData.append('action', action);
    formData.append('id', id);
    try {
        const response = await fetch(url, {
            method: "POST",                   
            body: formData
        });
        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }
        const json = await response.json();
        console.log(json);
        generateMainContent(json);
    } catch (error) {
        console.error(error.message);
    }
}

async function quantityListener(quantity, id, event) {
    event.preventDefault();

    console.log("quantità: " + quantity + " id: " + id);
    
    const formData = new FormData();
    formData.append('quantity', quantity);
    formData.append('id', id);
    try {
        const response = await fetch(url, {
            method: "POST",                   
            body: formData
        });
        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }
        const json = await response.json();
        console.log(json);
        generateMainContent(json);
    } catch (error) {
        console.error(error.message);
    }
}