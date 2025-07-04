import * as utils from './utils.js';
const url = utils.API_DIR + "cart.php";
displayMainContent();

async function displayMainContent() {
    generateMainContent(await utils.makePostRequest(url, new FormData()));
}

function generateMainContent(products) {
    // <section>
    //     <h2>Carrello</h2>
    //     <form action="">
    //         <label for="buy">Totale: products['total']€</label>
    //         <button type='submit' name='buy'>Acquista<img src="${paths.RESOURCES_DIR}ciamioncino_B.png" alt="" name='buy'></button>
    //     </form>
    //     <ul>
    //          foreach product in products:
    //              <li>content</li>
    //     </ul>
    // </section>
    
    document.querySelector('main').innerHTML = "";

    const section = document.createElement('section');
    const h2 = document.createElement('h2');
    h2.textContent ='Carrello';

    const form = document.createElement('form');
    
    const label = document.createElement('label');
    label.setAttribute = 'buy';
    label.textContent = 'Totale: ' + products['total'] + " €";

    const buyImage = document.createElement('img');
    buyImage.src = utils.RESOURCES_DIR + 'ciamioncino_B.png';
    buyImage.alt = '';

    const buyButton = document.createElement('button');
    buyButton.textContent = 'Acquista';
    buyButton.addEventListener('click', (event) => {
        buyButtonListener(event);
    });
    buyButton.appendChild(buyImage);

    form.appendChild(label);
    form.appendChild(buyButton);

    const ul = document.createElement('ul');
    
    for (let i = 0; i < products['result'].length; i++) {
        const product = products['result'][i];
        const li = document.createElement('li');        
        li.appendChild(utils.generateProductSection(product));
        li.appendChild(generateInteractionForm(product));
        ul.appendChild(li);
    }
    
    section.appendChild(h2);
    section.appendChild(form);
    section.appendChild(ul);
    
    document.querySelector('main').appendChild(section);
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
    });
    
    const removeImage = document.createElement('img');
    removeImage.src = utils.RESOURCES_DIR + 'cestino_B.png';
    removeImage.alt = '';
    
    const removeButton = document.createElement('button');
    removeButton.textContent = 'Rimuovi';
    removeButton.addEventListener('click', (event) => {
        buttonListener('remove', product['idProdotto'], event);
    });
    removeButton.appendChild(removeImage);

    const favouriteImage = document.createElement('img');
    favouriteImage.src = utils.RESOURCES_DIR + 'cuore_B.png';
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
    generateMainContent(await utils.makePostRequest(url, formData));
}

async function quantityListener(quantity, id, event) {
    event.preventDefault();
    console.log("quantità: " + quantity + " id: " + id);

    const formData = new FormData();
    formData.append('quantity', quantity);
    formData.append('id', id);
    generateMainContent(await utils.makePostRequest(url, formData));
}

async function buyButtonListener(event) {
    event.preventDefault();
    console.log('buy');
    
    const formData = new FormData();
    formData.append('action', 'buy');
    generateMainContent(await utils.makePostRequest(url, formData));
}