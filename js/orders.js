import * as utils from './utils.js';
displayMainContent();

async function displayMainContent() {
    const url = utils.API_DIR + "orders.php";
    try {
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }
        const json = await response.json();
        console.log(json);
        const content = generateMainContent(json);
        const main = document.querySelector("main");
        main.innerHTML += content;
    } catch (error) {
        console.log(error.message);
    }
}

function generateMainContent(products) {
    let content = `
        <section>
            <h2>Ordini</h2>
            <ul>`;
    for (let i = 0; i < !products['empty'] && products['result'].length; i++) {
        let product = products['result'][i];
        let details = products['details'][product['idOrdine']];
        content += `
                <li>
                    <p>N° Ordine: ${product['idOrdine']}</p>
                    <p>Totale: ${product['costoTotale']} €</p>
                    <p>Data ordine: ${product['dataOrdine']}</p>
                    <p>Stato ordine: ${product['statoOrdine']}</p>
                    <p>Consegna: ${product['dataArrivoPrevista']}</p>
                    <p>Venditore: ${product['idVenditore']}</p>

                    <ul>`;
        for (let j = 0; j < details.length; j++) {
            content =+ `<li>
                            <a href="${utils.PAGES_DIR}product.php?${details["idProdotto"]}">
                                <img src="${utils.DB_RESOURCES_DIR}${details['link']}" alt="Immagine Prodotto"/><br/>
                                ${details["nome"]}<br/>`;
            if (details['offerta'] > 0) {
                let sale = details["prezzo"] - details["prezzo"]*(details["offerta"]/100);
                content += `    <ins>${details["offerta"]}% ${sale}</ins> <del>${details["prezzo"]}</del> €"`;
            } else {
                content += `    <p>${details["prezzo"]} €</p>`;
            }
            content += `        <p>${details['media_recensioni']} ${details['num_recensioni']}</p>
                                <p>Descrizione: ${details['descrizione']}</p>
                                <p>Quantità: ${details['quantita']}</p>
                            </a>
                        </li>`;
        }
        content += `</ul>
                </li>`;
    }
    content +=`
            </ul>
        </section>`;
    return content;
}