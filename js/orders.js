import * as utils from './utils.js';
const url = utils.API_DIR + "orders.php";
displayMainContent();

async function displayMainContent() {
    generateMainContent(await utils.makePostRequest(url, new FormData()));
}

function generateMainContent(result) {
    const orders = result['result'];
    let content = `
        <section>
            <header>
                <h2>Ordini</h2>
            </header>
            <ul>`;
    for (let i = 0; i < orders.length; i++) {
        const order = orders[i];
        const details = result['details'][order['idOrdine']];
        content += `
                <li>
                    <strong>N° Ordine: ${order['idOrdine']}</strong>
                    <strong>Totale: ${order['costoTotale']} €</strong>
                    <p>Data ordine: ${order['dataOrdine']}</p>`;
        if (result['type'] == 'Venditore') {
            content += `<p><span>Stato ordine: </span><strong>${result['order_state'][order['statoOrdine']]}</strong></p>`;
        } else {
            content += `<form action="#" method="POST">
                            <label for='stato${order['idOrdine']}'>Stato ordine: </label> 
                            <input type="hidden" name="id" value="${order["idOrdine"]}">
                            <select id="stato${order['idOrdine']}" name="stato" required>
                            
                                <option value="" disabled> --- Scegli uno stato --- </option>
                                <option value="1" ${order['statoOrdine'] === 1 ? 'selected' : ''}>${result['order_state'][0]}</option>
                                <option value="2" ${order['statoOrdine'] === 2 ? 'selected' : ''}>${result['order_state'][1]}</option>
                                <option value="3" ${order['statoOrdine'] === 3 ? 'selected' : ''}>${result['order_state'][2]}</option>
                                <option value="4" ${order['statoOrdine'] === 4 ? 'selected' : ''}>${result['order_state'][3]}</option>
                            </select>
                        </form>`;
        }
        content += `<p>Consegna prevista: ${order['dataArrivoPrevista']}</p>
                    <p>${result['type']}: ${order['idP']}</p>

                    <ul>`;
        for (let j = 0; j < details.length; j++) {
            const detail = details[j];
            content += `<li>
                            <a href="${utils.PAGES_DIR}product.php?search=${detail["idProdotto"]}">
                                <img src="${utils.DB_RESOURCES_DIR}${detail['link']}" alt="Immagine Prodotto"/>
                                <p>${detail["nome"]}</p>`;
            if (detail['offerta'] > 0) {
                content += `    <p><ins>${detail["offerta"]}% ${detail['prezzoScontato']}</ins> <del>${detail["prezzo"]}</del>€</p>`;
            } else {
                content += `    <p>${detail["prezzo"]}€</p>`;
            }
            const number = parseFloat(detail['media_recensioni']);
            let k;
            for (k = 5; number < k && k > 0; k-= 0.5);            
            content += `        <p>${detail['media_recensioni'].substring(0, 3)} (${detail['num_recensioni']})
                                    <img src='${utils.RESOURCES_DIR + k}_star.png' alt='Media e numero recensioni'/>
                                </p>
                                <!-- <p>Descrizione: ${detail['descrizione']}</p> -->
                                <p>Quantità: ${detail['quantita']}</p>
                            </a>
                        </li>`;
        }
        content += `</ul>
                </li>`;
    }
    content += `
            </ul>
        </section>`;
    
    document.querySelector('main').innerHTML = content;

    addFormListeners(result['type']);
}

function addFormListeners(user_type) {
    if(user_type === 'Cliente') {
        const forms = document.querySelectorAll('main section ul li form');
        forms.forEach(form => {
            form.addEventListener('change', async (event) => {
                event.preventDefault();
                console.log('id: ' + form.querySelector('input').value + ', new state: ' + form.querySelector('select').value);

                const formData = new FormData();
                formData.append('id', form.querySelector('input').value);
                formData.append('state', form.querySelector('select').value);
                generateMainContent(await utils.makePostRequest(url, formData));
            });
        });
    }
}