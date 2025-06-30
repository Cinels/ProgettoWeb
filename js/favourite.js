import * as paths from './paths.js';
displayMainContent();

async function displayMainContent() {
    const url = paths.API_DIR + "cart.php";
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
            <h2>Preferiti</h2>
            <ul>`;
    for (let i = 0; i < products.length; i++) {
        let product = products[i];
        content += `
                <li>
                    <a href="${paths.PAGES_DIR}product.php?search=${product["idProdotto"]}">
                        <img src="${product['link']}" alt="Immagine Prodotto"/><br/>
                        ${product['nome']}<br/>`;
        if (product["offerta"] > 0) {
            let sale = product["prezzo"] - product["prezzo"]*(product[offerta]/100);
            content += `<ins>${product["offerta"]}% ${sale}</ins> <del>${product["prezzo"]}</del> €"`;
        } else {
            content += `<p>${product["prezzo"]} €</p>`;
        }
        content += `    <p>${product["media_recensioni"]} ${product["num_recensioni"]}</p>
                        <p>Venditore: ${product["idVenditore"]}</p>
                        <p>Consegna prevista per <?php echo strftime("%A %d %B", strtotime('+1 day', time())); ?></p>
                    </a>
                    <a href="?id=${product["idProdotto"]}&remove">Rimuovi<img src="${paths.RESOURCES_DIR}cestino_B.png" alt=""></a>
                    <a href="?id=${product["IdProdotto"]}&cart">Sposta nel Carrello<img src="${paths.RESOURCES_DIR}carrello_B.png" alt=""></a>
                </li>`;
    }
    content +=`
            </ul>
        </section>
    `;
    return content;
}