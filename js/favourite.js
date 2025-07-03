import * as utils from './utils.js';
const url = utils.API_DIR + "favourite.php";
displayMainContent();

async function displayMainContent() {
    generateMainContent(await utils.makePostRequest(url, new FormData()));
}

function generateMainContent(products) {
    // <section>
    //     <h2>Preferiti</h2>
    //     <ul>
    //          foreach product in products:
    //              <li>content</li>
    //     </ul>
    // </section>
    
    document.querySelector('main').innerHTML = "";

    const section = document.createElement('section');
    const h2 = document.createElement('h2');
    h2.textContent ='Preferiti';
    const ul = document.createElement('ul');
    
    for (let i = 0; i < products['result'].length; i++) {
        const product = products['result'][i];
        const li = document.createElement('li');        
        li.appendChild(utils.generateProductSection(product));
        li.appendChild(generateInteractionForm(product));
        ul.appendChild(li);
    }
    
    section.appendChild(h2);
    section.appendChild(ul);
    const main = document.querySelector('main');
    main.appendChild(section);
}

function generateInteractionForm(product) {
    // <form action="">
    //     <button type='submit' name='remove'>Rimuovi<img src="${paths.RESOURCES_DIR}cestino_B.png" alt="" name='remove'></button>
    //     <button type='submit' name='favourite'>Sposta nei Preferiti<img src="${paths.RESOURCES_DIR}cuore_B.png" alt="" name='favourite'></button>
    // </form>
    
    const form = document.createElement('form');
    
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
    favouriteImage.src = utils.RESOURCES_DIR + 'carrello_B.png';
    favouriteImage.alt = '';

    const favouriteButton = document.createElement('button');
    favouriteButton.textContent = 'Sposta nel Carrello';
    favouriteButton.addEventListener('click', (event) => {
        buttonListener('cart', product['idProdotto'], event);
    });
    favouriteButton.appendChild(favouriteImage);
    
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