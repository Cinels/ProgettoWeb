import * as utils from './utils.js';
const url = utils.API_DIR + "cart.php";
displayMainContent();

async function displayMainContent() {
    generateMainContent(await utils.makePostRequest(url, new FormData()));
}

function generateMainContent(result) {
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
    section.appendChild(h2);
    
    if (result['result'].length > 0) {

        const form = document.createElement('form');
        
        const h3 = document.createElement('h3');
        h3.textContent = 'Totale: ' + result['total'] + " €";
        
        const buyImage = document.createElement('img');
        buyImage.src = utils.RESOURCES_DIR + 'pay.png';
        buyImage.alt = '';
        
        const buyButton = document.createElement('button');
        buyButton.textContent = 'Acquista';
        buyButton.addEventListener('click', (event) => {
            event.preventDefault();
            if (result['result'].length > 0) {
                document.location = utils.PAGES_DIR + 'payment.php';
            }
        });
        buyButton.appendChild(buyImage);
        
        form.appendChild(h3);
        form.appendChild(buyButton);
        
        const ul = document.createElement('ul');
        
        for (let i = 0; i < result['result'].length; i++) {
            const product = result['result'][i];
            const li = document.createElement('li');        
            li.appendChild(utils.generateProductSection(product));
            li.appendChild(generateInteractionForm(product, result['available'][product['idProdotto']]));
            ul.appendChild(li);
        }
        
        section.appendChild(form);
        section.appendChild(ul);
    }
    document.querySelector('main').appendChild(section);
}

function generateInteractionForm(product, available) {
    // <form action="">
    //     <input type="number" id="quantity" name="quantity" min="0" value="${product["quantita"]}">;
    //     <button type='submit' name='remove'>Rimuovi<img src="${paths.RESOURCES_DIR}cestino_B.png" alt="" name='remove'></button>
    //     <button type='submit' name='favourite'>Sposta nei Preferiti<img src="${paths.RESOURCES_DIR}cuore_B.png" alt="" name='favourite'></button>
    // </form>
    
    const form = document.createElement('form');

    const input = document.createElement('input');
    input.type = 'number';
    input.min = 0;
    input.max = available;
    input.value = product['quantita'];
    input.addEventListener('change', (event) => {
        quantityListener(input.value, available, product['idProdotto'], event);
    });
    input.addEventListener('submit', (event) => {
        quantityListener(input.value, available,  product['idProdotto'], event);
    });
    
    const removeImage = document.createElement('img');
    removeImage.src = utils.RESOURCES_DIR + 'cestino_B.png';
    removeImage.alt = '';
    
    const removeButton = document.createElement('button');
    removeButton.type = 'button';
    removeButton.textContent = 'Rimuovi';
    removeButton.addEventListener('click', (event) => {
        buttonListener('remove', product['idProdotto'], event);
    });
    removeButton.appendChild(removeImage);

    const favouriteImage = document.createElement('img');
    favouriteImage.src = utils.RESOURCES_DIR + 'cuore_B.png';
    favouriteImage.alt = '';

    const favouriteButton = document.createElement('button');
    favouriteButton.type = 'button';
    favouriteButton.textContent = 'Sposta nei Preferiti';
    favouriteButton.addEventListener('click', (event) => {
        buttonListener('favourite', product['idProdotto'], event);
    });
    favouriteButton.appendChild(favouriteImage);
    
    // form.appendChild(label);
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

async function quantityListener(quantity, available, id, event) {
    event.preventDefault();
    
    if (quantity <= available) {
        console.log("quantità: " + quantity + " id: " + id);

        const formData = new FormData();
        formData.append('quantity', quantity);
        formData.append('id', id);
        generateMainContent(await utils.makePostRequest(url, formData));
    } else {
        utils.alertQuantity(quantity, available);
    }
    
}