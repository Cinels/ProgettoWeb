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
        main.innerHTML = content;
    } catch (error) {
        console.log(error.message);
    }
}

function generateMainContent(result) {
    const orders = result['result'];
    let content = `
        <section>
            <h2>Ordini</h2>
            <ul>`;
    for (let i = 0; i < orders.length; i++) {
        const order = orders[i];
        console.log(order);
        const details = result['details'][order['idOrdine']];
        content += `
                <li>
                    <p>N° Ordine: ${order['idOrdine']}</p>
                    <p>Totale: ${order['costoTotale']} €</p>
                    <p>Data ordine: ${order['dataOrdine']}</p>
                    <p>Stato ordine: ${result['order_state'][order['statoOrdine']]}</p>
                    <p>Consegna prevista: ${order['dataArrivoPrevista']}</p>
                    <p>${result['type']}: ${order['idP']}</p>

                    <ul>`;
        for (let j = 0; j < details.length; j++) {
            const detail = details[j];
            content += `<li>
                            <a href="${utils.PAGES_DIR}product.php?${detail["idProdotto"]}">
                                <img src="${utils.DB_RESOURCES_DIR}${detail['link']}" alt="Immagine Prodotto"/><br/>
                                <p>${detail["nome"]}</p><br/>`;
            if (detail['offerta'] > 0) {
                content += `    <ins>${detail["offerta"]}% ${detail['prezzoScontato']}</ins> <del>${detail["prezzo"]}</del> €"`;
            } else {
                content += `    <p>${detail["prezzo"]} €</p>`;
            }
            const number = parseFloat(detail['media_recensioni']);
            let k;
            for (k = 5; number < k && k > 0; k-= 0.5);            
            content += `        <p>${detail['media_recensioni'].substring(0, 3)} (${detail['num_recensioni']})
                                    <img src='${utils.RESOURCES_DIR + k}_star.png' alt='Media e numero recensioni'/>
                                </p>
                                <p>Descrizione: ${detail['descrizione']}</p>
                                <p>Quantità: ${detail['quantita']}</p>
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