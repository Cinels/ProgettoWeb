export const API_DIR = "../api/";
export const PAGES_DIR = "../pages/";
export const RESOURCES_DIR = "../resources/";
export const DB_RESOURCES_DIR = "../resources/database_img/";

export async function makePostRequest(url, formData) {
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
        return json;
    } catch (error) {
        console.error(error.message);
    }
}

export function generateProductImage(product) {
    // <a href="${paths.PAGES_DIR}product.php?search=${product["idProdotto"]}">
    //     <img src="${paths.DB_RESOURCES_DIR}${product['link']}" alt="Immagine Prodotto"/><br/>
    // </a>
    
    const a = document.createElement('a');
    a.href = PAGES_DIR + 'product.php?search=' + product['idProdotto'];
    
    const img_product = document.createElement('img');
    img_product.src = DB_RESOURCES_DIR + product['link'];
    img_product.alt = '';

    a.appendChild(img_product);

    return a;
}

export function generateProductSection(product) {
    // <a href="${paths.PAGES_DIR}product.php?search=${product["idProdotto"]}">
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
    a.href = PAGES_DIR + 'product.php?search=' + product['idProdotto'];
    
    // const img_product = document.createElement('img');
    // img_product.src = DB_RESOURCES_DIR + product['link'];
    // img_product.alt = '';

    const span = document.createElement('span');
    span.textContent = product['nome'];

    const price = document.createElement('p');
    if (product["offerta"] > 0) {
        price.innerHTML = `<ins>${product["offerta"]}% ${product['prezzoScontato']}</ins> <del>${product["prezzo"]}</del>€`;;
    } else {
        price.innerText = product['prezzo'] + '€';            
    }
    
    const p1 = document.createElement('p');
    p1.innerText = product['media_recensioni'].substring(0, 3) + " (" + product['num_recensioni'] + ")";
    p1.appendChild(generateReviewStars(product['media_recensioni']));

    const p2 = document.createElement('p');
    p2.innerText = product['idVenditore'];

    const options = {'weekday': 'long', 'month': 'long', 'day': '2-digit'};
    const date = new Date(new Date().setDate(new Date().getDate() + 1)).toLocaleString('it-IT', options);
    const p3 = document.createElement('p');
    p3.innerText = "Consegna prevista per: " + date;

    // a.appendChild(img_product);
    a.appendChild(span);
    a.appendChild(price);
    a.appendChild(p1);
    a.appendChild(p2);
    a.appendChild(p3);
    
    return a;
}

export function generateReviewStars(vote, alt = 'Media e numero recensioni') {
    const image = document.createElement('img');
    const number = parseFloat(vote);
    let i;
    for (i = 5; number < i && i > 0; i-= 0.5);
    image.src = RESOURCES_DIR + i + '_star.png';
    image.alt = alt;

    return image;
}

export function alertQuantity(richieste, disponibili) {
    alert(`Quantità del prodotto non sufficiente!\nRichieste: ${richieste} Disponibili: ${disponibili}`);
}