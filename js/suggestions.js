import * as utils from './utils.js';
const url = utils.API_DIR + "suggestions.php";
displaySideContent();

async function displaySideContent() {
    document.querySelector('aside').innerHTML += '';
    const page = location.pathname.substring(location.pathname.lastIndexOf('/') + 1);
    switch (page) {
        case 'index.php':
            generateSideContent((await utils.makePostRequest(url + '?suggestion=sale', new FormData()))['result'], 'In Sconto');
            generateSideContent((await utils.makePostRequest(url + '?suggestion=trends', new FormData()))['result'], 'Tendenze');
            generateSideContent((await utils.makePostRequest(url + '?suggestion=interests', new FormData()))['result'], 'I tuoi Interessi');
            break;
        case 'cart.php':
            generateSideContent((await utils.makePostRequest(url + '?suggestion=interests', new FormData()))['result'], 'I tuoi Interessi');
            break;
        case 'favourite.php':
            generateSideContent((await utils.makePostRequest(url + '?suggestion=interests', new FormData()))['result'], 'I tuoi Interessi');
            break;
        case 'product.php':
            generateSideContent((await utils.makePostRequest(url + location.search + '&suggestion=related', new FormData()))['result'], 'Correlati');
            break;
        default: break;
    }
}

function generateSideContent(results, title) {
    if (results.length > 0) {            
        let content = `
            <section>
                <h2>${title}</h2>
                <form action="${utils.PAGES_DIR}product.php" method="GET">`;
        for (let i = 0; i < results.length; i++) {
            const product = results[i];
            content += `
                    <button type="submit" name="search" value="${product['idProdotto']}">
                        <img src="${utils.DB_RESOURCES_DIR}${product['link']}" alt="Immagine Prodotto"/>
                        ${product['nome']}`;
            if (product['offerta'] > 0) {
                content += `
                        <ins>${product['offerta']}% ${product["prezzoScontato"]}</ins> <del>${product['prezzo']}</del><span> €</span>`;
            } else {
                content += `
                        <span>${product['prezzo']} €</span>`;
            }
            content += `
                    </button>`;
        }
        content += `
                </form>
            </section>`;
        document.querySelector('aside').innerHTML += content;
    }
}