import * as utils from './utils.js';
const url = utils.API_DIR + "payment.php";
displayMainContent();

async function displayMainContent() {
    generateMainContent(await utils.makePostRequest(url, new FormData()));
}

function generateMainContent(result) {
    // <section>
    //     <h2>Pagamento</h2>
    //     <!-- Rifai vedere somma -->
    //     <p>Totale articoli: ${result['total']} €</p>
    //     <p>Costi di spedizione: 2</p>
    //     <strong>Totale da pagare:</strong>
    //     <p>Consegna prevista:<p>
    //     <p>Via Cesare Pavese, 50, 47521 Cesena FC<p>
    
    //     <form>dati pagamento</form>
    // </section>

    document.querySelector('main').innerHTML = "";

    const section = document.createElement('section');

    const h2 = document.createElement('h2');
    h2.textContent = 'Pagamento';

    const p1 = document.createElement('p');
    p1.textContent = "Totale articoli: " + result['total'] + ' €';

    const deliveryCosts = 2*result['num_products'];
    const p2 = document.createElement('p');
    p2.textContent = "Costi di spedizione: " + deliveryCosts + ' €';

    const strong = document.createElement('strong');
    strong.textContent = 'Totale da pagare: ' + (result['total'] + deliveryCosts) + ' €';
    
    const options = {'weekday': 'long', 'month': 'long', 'day': '2-digit'};
    const date = new Date(new Date().setDate(new Date().getDate() + 1)).toLocaleString('it-IT', options);
    const p3 = document.createElement('p');
    p3.innerText = "Consegna prevista per: " + date;

    const p4 = document.createElement('p');
    p4.innerText = 'Via Cesare Pavese, 50, 47521 Cesena FC';

    section.appendChild(h2);
    section.appendChild(p1);
    section.appendChild(p2);
    section.appendChild(p3);
    section.appendChild(p4);
    section.appendChild(generateInteractionForm());
    
    document.querySelector('main').appendChild(section);
}

function generateInteractionForm() {
    // <form action="" method="POST">
    //     <p>errori</p>
    //     <label for="n_card">Numero carta:</label>
    //     <input type="text" id="n_card" name="card_number" inputmode="numeric" pattern="\d{16}" minlength="16" maxlength="16" required/></br>
    //     <label for="exp_date">Data di scadenza:</label>
    //     <input type="month" id="exp_date" name="expire_date" min="<?php echo date("Y") ?>-<?php echo date("m")?>" max="<?php echo date("Y")+10?>-<?php echo date("m")?>" required/></br>
    //     <label for="ccv">CCV:</label>
    //     <input type="text" id="ccv" name="ccv" inputmode="numeric" pattern="\d{3}" maxlength="3" required/></br>
    //     <input type="submit" value="Acquista ora">
    // </form>

    const form = document.createElement('form');
    const p = document.createElement('p');

    const label1 = document.createElement('label');
    label1.setAttribute('for', 'n_card');
    label1.textContent = 'Numero carta: ';

    const input1 = document.createElement('input');
    input1.type = 'text';
    input1.id = 'n_card';
    input1.name = 'n_card';
    input1.pattern = '\\d{16}';
    input1.minLength = 16;
    input1.maxLength = 16;
    input1.required = true;

    const label2 = document.createElement('label');
    label2.setAttribute('for', 'exp_date');
    label2.textContent = 'Data di scadenza: ';

    const input2 = document.createElement('input');
    input2.type = 'month';
    input2.id = 'exp_date';
    input2.name = 'expire_date';
    input2.min = new Date().getFullYear() + "-" + String(new Date().getMonth() + 1).padStart(2, '0');
    input2.max = (new Date().getFullYear() + 10) + "-" + String(new Date().getMonth() + 1).padStart(2, '0');
    input2.required = true;

    const label3 = document.createElement('label');
    label3.setAttribute('for', 'ccv');
    label3.textContent = 'CCV: ';

    const input3 = document.createElement('input');
    input3.type = 'text';
    input3.id = 'ccv';
    input3.name = 'ccv';
    input3.pattern = '\\d{3}';
    input3.maxLength = 3;
    input3.required = true;

    const cancelImage = document.createElement('img');
    cancelImage.src = utils.RESOURCES_DIR + 'x.png';
    cancelImage.alt = '';

    const cancelButton = document.createElement('button');
    cancelButton.type = 'button';
    cancelButton.textContent = 'Annulla';
    cancelButton.appendChild(cancelImage);
    cancelButton.addEventListener('click', (event) => {
        event.preventDefault();
        location.href = utils.PAGES_DIR + 'cart.php';
    });
    
    const buyImage = document.createElement('img');
    buyImage.src = utils.RESOURCES_DIR + 'pay.png';
    buyImage.alt = '';
    
    const buyButton = document.createElement('button');
    buyButton.textContent = 'Acquista ora';
    buyButton.appendChild(buyImage);
    buyButton.addEventListener('click', async (event) => {
        event.preventDefault();
        console.log('n_card: ' + input1.value + ', exp_date: ' + input2.value + ', ccv: ' + input3.value);

        const formData = new FormData();
        formData.append('card_number', input1.value);
        formData.append('expire_date', input2.value);
        formData.append('ccv', input3.value);
        const json = await utils.makePostRequest(url, formData);
        if (json['hasOrdered']) {
            alert('Ordine effettuato');
            location.href = utils.PAGES_DIR + 'orders.php';
        } else {
            document.querySelector('main form p').innerText = 'Errore durante il pagamento!';
            generateMainContent(json);
        }
    });

    form.appendChild(p);
    form.appendChild(label1);
    form.appendChild(input1);
    form.appendChild(document.createElement('br'));
    form.appendChild(label2);
    form.appendChild(input2);
    form.appendChild(document.createElement('br'));
    form.appendChild(label3);
    form.appendChild(input3);
    form.appendChild(document.createElement('br'));
    form.appendChild(cancelButton);
    form.appendChild(buyButton);

    return form;
}