import * as utils from './utils.js';
const url = utils.API_DIR + "favourite.php";
displayMainContent();

async function displayMainContent() {
    generateMainContent(await utils.makePostRequest(url, new FormData()));
}

function generateMainContent(result) {
    // <section>
    //     <h2>Preferiti</h2>
    //     <ul>
    //          foreach product in products:
    //              <li>content</li>
    //     </ul>
    // </section>
    
    document.querySelector('main').innerHTML = "";

    const section = document.createElement('section');

    const header = document.createElement('header');
    const h2 = document.createElement('h2');
    h2.textContent ='Preferiti';

    const ul = document.createElement('ul');
    
    for (let i = 0; i < result['result'].length; i++) {
        const product = result['result'][i];
        const li = document.createElement('li');
        
        li.appendChild(utils.generateProductImage(product));
        li.appendChild(utils.generateProductSection(product));
        li.appendChild(generateInteractionForm(product, result['cartQuantity'][product['idProdotto']], result['available'][product['idProdotto']]));
        ul.appendChild(li);
    }
    
    header.appendChild(h2);
    section.appendChild(header);
    section.appendChild(ul);
    
    document.querySelector('main').appendChild(section);
}

function generateInteractionForm(product, cartQuantity, available) {
    // <form action="">
    //     <button type='submit' name='remove'>Rimuovi<img src="${paths.RESOURCES_DIR}cestino_B.png" alt="" name='remove'></button>
    //     <button type='submit' name='favourite'>Sposta nei Preferiti<img src="${paths.RESOURCES_DIR}cuore_B.png" alt="" name='favourite'></button>
    // </form>
    
    const form = document.createElement('form');
    
    const removeImage = document.createElement('img');
    removeImage.src = utils.RESOURCES_DIR + 'cestino_W.png';
    removeImage.alt = '';
    
    const removeButton = document.createElement('button');
    removeButton.type = 'button';
    removeButton.textContent = 'Rimuovi';
    removeButton.name = 'favouriteRemove';
    removeButton.addEventListener('click', (event) => {
        buttonListener('remove', product['idProdotto'], event, 0, 0);
    });
    removeButton.appendChild(removeImage);

    const favouriteImage = document.createElement('img');
    favouriteImage.src = utils.RESOURCES_DIR + 'carrello_B.png';
    favouriteImage.alt = '';

    const cartButton = document.createElement('button');
    cartButton.type = 'button';
    cartButton.name = 'cart';
    cartButton.textContent = 'Sposta nel Carrello';
    cartButton.addEventListener('click', (event) => {
        buttonListener('cart', product['idProdotto'], event, Number(cartQuantity) + 1, available);
    });
    cartButton.appendChild(favouriteImage);
    
    form.appendChild(removeButton);
    form.appendChild(cartButton);

    return form;
}

async function buttonListener(action, id, event, quantity, available) {
    event.preventDefault();
    console.log(action + " " + id + ', quantity: ' + quantity + ', available: ' + available);

    if (action === 'remove' || quantity <= available) {
        const formData = new FormData();
        formData.append('action', action);
        formData.append('id', id);
        generateMainContent(await utils.makePostRequest(url, formData));
    } else {
        utils.alertQuantity(quantity, available);
    }
}