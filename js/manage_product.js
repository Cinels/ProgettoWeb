import * as utils from './utils.js';
const getParams = window.location.search;
const url = utils.API_DIR + "manage_product.php" + getParams;
displayMainContent();

async function displayMainContent() {
    generateMainContent(await utils.makePostRequest(url, new FormData()));
}

function generateMainContent(result) {
    // <section>
    //     <h2><?php echo $templateParams["h2"] ?></h2>
    //     <form action="#" method="POST" enctype="multipart/form-data">
    //         <?php if (isset($templateParams['id'])):
    //             echo "<input type=\"hidden\" name=\"update\" value=".$templateParams['id'].">";
    //         endif;?>

    //         <label for="image1">Immagine 1:<img src="<?php echo (isset($templateParams['id'])) ? DB_RESOURCES_DIR.$templateParams['images'][0]['link'] : ""?>" /></label><br>
    //         <input type="file" name="image1" id="image1" accept="image/*" <?php echo (!isset($templateParams['id']) ? "required" : "") ?>/><br><br>

    //         <label for="image2">Immagine 2:<img src="<?php echo (isset($templateParams['id'])) ? DB_RESOURCES_DIR.$templateParams['images'][1]['link'] : ""?>" /></label><br>
    //         <input type="file" name="image2" id="image2" accept="image/*"/><br><br>

    //         <label for="nome">Nome:</label><br>
    //         <input type="text" id="nome" name="nome" maxlength="50" value ="<?php echo $templateParams["product"]["nome"] ?? "" ?>" required><br><br>

    //         <label for="prezzo">Prezzo (€):</label><br>
    //         <input type="number" id="prezzo" name="prezzo" step="0.01" min="0" max="9999.99" value ="<?php echo $templateParams["product"]["prezzo"] ?? "" ?>" required><br><br>

    //         <label for="quantita">Quantità Disponibile:</label><br>
    //         <input type="number" id="quantita" name="quantitaDisponibile" min="0" value ="<?php echo $templateParams["product"]["quantitaDisponibile"] ?? "" ?>" required><br><br>

    //         <label for="descrizione">Descrizione:</label><br>
    //         <textarea id="descrizione" name="descrizione" maxlength="500" rows="10" cols="50" required><?php echo $templateParams["product"]["descrizione"] ?? "" ?></textarea><br><br>

    //         <label for="proprieta">Proprietà:</label><br>
    //         <textarea id="proprieta" name="proprieta" maxlength="300" rows="5" cols="25"><?php echo $templateParams["product"]["proprieta"] ?? "" ?></textarea><br><br>

    //         <label for="offerta">Offerta (%):</label><br>
    //         <input type="number" id="offerta" name="offerta" min="0" max="99" value ="<?php echo $templateParams["product"]["offerta"] ?? "" ?>" required><br><br>

    //         <label for="tipo">Tipo :</label><br>
    //         <select id="tipo" name="tipo" required>
    //             <option value="">-- Seleziona un tipo --</option>
    //             <option value="1" <?php echo $templateParams["product"]["tipo"] == 1 ? "selected" : "" ?>>Console</option>
    //             <option value="2" <?php echo $templateParams["product"]["tipo"] == 2 ? "selected" : "" ?>>Controller</option>
    //             <option value="3" <?php echo $templateParams["product"]["tipo"] == 3 ? "selected" : "" ?>>Videogioco</option>
    //         </select><br><br>

    //         <label for="piattaforma">Piattaforma :</label><br>
    //         <select id="piattaforma" name="piattaforma" required>
    //             <option value="">-- Seleziona un piattaforma --</option>
    //             <option value="1" <?php echo $templateParams["product"]["idPiattaforma"] == 1 ? "selected" : "" ?>>Nintendo</option>
    //             <option value="2" <?php echo $templateParams["product"]["idPiattaforma"] == 2 ? "selected" : "" ?>>Sony</option>
    //             <option value="3" <?php echo $templateParams["product"]["idPiattaforma"] == 3 ? "selected" : "" ?>>Microsoft</option>
    //         </select><br><br>

    //         <button type="submit"><?php echo $templateParams["h2"] ?><img src="<?php echo RESOURCES_DIR."Marco_semplice_W.png"?>" alt="" name ="update" /></button>
    //     </form>
    //     <?php if(isset($templateParams['id'])): ?>
    //         <a href="product.php?search=<?php echo $templateParams['id'] ?>"><button type="button">Annulla<img src="<?php echo RESOURCES_DIR."x.png"?>" alt="" name ="cancel"/></button><a>
    //     <?php endif; ?>
    // </section>

    document.querySelector('main').innerHTML = "";

    const section = document.createElement('section');

    const h2 = document.createElement('h2');
    h2.textContent = getParams.length > 0 ? 'Modifica Prodotto' : 'Inserisci Prodotto';

    const form = document.createElement('form');
    form.enctype = "multipart/form-data";

    // <label for="image1">Immagine 1:<img src="<?php echo (isset($templateParams['id'])) ? DB_RESOURCES_DIR.$templateParams['images'][0]['link'] : ""?>" /></label><br>
    // <input type="file" name="image1" id="image1" accept="image/*" <?php echo (!isset($templateParams['id']) ? "required" : "") ?>/><br><br>

    // <label for="image2">Immagine 2:<img src="<?php echo (isset($templateParams['id'])) ? DB_RESOURCES_DIR.$templateParams['images'][1]['link'] : ""?>" /></label><br>
    // <input type="file" name="image2" id="image2" accept="image/*"/><br><br>

    const image1label = document.createElement('label');
    image1label.setAttribute('for', 'image1');
    image1label.textContent = 'Immagine 1:';
    if (getParams.length > 0) {
        const image1 = document.createElement('img');
        image1.src = utils.DB_RESOURCES_DIR + result['images'][0]['link'];
        image1.alt = 'Immagine 1 Prodotto';
        image1label.appendChild(image1);
    }
    const image1input = document.createElement('input');
    image1input.type = 'file';
    image1input.name = 'image1';
    image1input.id = 'image1';
    image1input.accept = 'image/*';
    image1input.required = getParams.length == 0;

    const image2label = document.createElement('label');
    image2label.setAttribute('for', 'image2');
    image2label.textContent = 'Immagine 2:';
    if (getParams.length > 0) {
        const image2 = document.createElement('img');
        image2.src = utils.DB_RESOURCES_DIR + result['images'][1]['link'];
        image2.alt = 'Immagine 2 Prodotto';
        image2label.appendChild(image2);
    }
    const image2input = document.createElement('input');
    image2input.type = 'file';
    image2input.name = 'image2';
    image2input.id = 'image2';
    image2input.accept = 'image/*';

    const label1 = document.createElement('label');
    label1.setAttribute('for', 'name');
    label1.textContent = 'Nome:';
    const input1 = document.createElement('input');
    input1.type = 'text';
    input1.id = 'name';
    input1.name = 'name';
    input1.maxLength = 50;
    input1.required = true;
    input1.value = getParams.length > 0 ? result['result']['nome'] : '';

    const label2 = document.createElement('label');
    label2.setAttribute('for', 'price');
    label2.textContent = 'Prezzo (€)';
    const input2 = document.createElement('input');
    input2.type = 'number';
    input2.id = 'price';
    input2.name = 'price';
    input2.step = 0.01;
    input2.min = 0.00;
    input2.max = 9999.99;
    input2.value = getParams.length > 0 ? result['result']['prezzo'] : '';
    input2.required = true;

    const label3 = document.createElement('label');
    label3.setAttribute('for', 'quantity');
    label3.textContent = 'Quantità Disponibile:';
    const input3 = document.createElement('input');
    input3.type = 'number';
    input3.id = 'quantity';
    input3.name = 'quantity';
    input3.min = 0;
    input3.value = getParams.length > 0 ? result['result']['quantitaDisponibile'] : '';
    input3.required = true;

    const label4 = document.createElement('label');
    label4.setAttribute('for', 'description');
    label4.textContent = 'Descrizione:';
    const textarea4 = document.createElement('textarea');
    textarea4.id = 'description';
    textarea4.name = 'description';
    textarea4.maxLength = 500;
    textarea4.rows = 10;
    textarea4.cols = 50;
    textarea4.value = getParams.length > 0 ? result['result']['descrizione'] : '';
    textarea4.required = true;

    const label5 = document.createElement('label');
    label5.setAttribute('for', 'property');
    label5.textContent = 'Proprietà:';
    const textarea5 = document.createElement('textarea');
    textarea5.id = 'property';
    textarea5.name = 'property';
    textarea5.maxLength = 300;
    textarea5.rows = 6;
    textarea5.cols = 50;
    textarea5.value = getParams.length > 0 ? result['result']['proprieta'] : '';
    textarea5.required = true;

    const label6 = document.createElement('label');
    label6.setAttribute('for', 'sale');
    label6.textContent = 'Offerta (%):';
    const input6 = document.createElement('input');
    input6.id = 'sale';
    input6.type = 'number';
    input6.name = 'sale';
    input6.min = 0;
    input6.max = 100;
    input6.value = getParams.length > 0 ? result['result']['offerta'] : '';
    input6.required = true;

    const label7 = document.createElement('label');
    label7.setAttribute('for', 'type');
    label7.textContent = "Tipo:";
    const select7 = document.createElement('select');
    select7.id = 'type';
    select7.name = 'type';
    const option7_0 = document.createElement('option');
    option7_0.value = '';
    option7_0.text = '>-- Seleziona un tipo --<';
    option7_0.disabled = true;
    option7_0.selected = getParams.length == 0;
    const option7_1 = document.createElement('option');
    option7_1.value = '1';
    option7_1.selected = getParams.length > 0 && result['result']['tipo'] == 1;
    option7_1.text = 'Console';
    const option7_2 = document.createElement('option');
    option7_2.value = '2';
    option7_2.selected = getParams.length > 0 && result['result']['tipo'] == 2;
    option7_2.text = 'Accessori';
    const option7_3 = document.createElement('option');
    option7_3.value = '3';
    option7_3.selected = getParams.length > 0 && result['result']['tipo'] == 3;
    option7_3.text = 'Videogiochi';
    select7.appendChild(option7_0);
    select7.appendChild(option7_1);
    select7.appendChild(option7_2);
    select7.appendChild(option7_3);

    const p8 = document.createElement('p');
    p8.textContent = "Piattaforma:";
    const input8_1 = document.createElement('input');
    input8_1.type = 'checkbox';
    input8_1.id = 'nintendo';
    input8_1.name = 'platform';
    input8_1.value = 1;
    input8_1.selected = getParams.length > 0 && result['result']['idPiattaforma'] == 1;
    const label8_1 = document.createElement('label');
    label8_1.setAttribute('for', 'nintendo')
    label8_1.textContent = 'Nintendo';
    const input8_2 = document.createElement('input');
    input8_2.type = 'checkbox';
    input8_2.id = 'sony';
    input8_2.name = 'platform';
    input8_2.value = 2;
    input8_2.selected = getParams.length > 0 && result['result']['idPiattaforma'] == 2;
    const label8_2 = document.createElement('label');
    label8_2.setAttribute('for', 'sony')
    label8_2.textContent = 'Sony';
    const input8_3 = document.createElement('input');
    input8_3.type = 'checkbox';
    input8_3.id = 'microsoft';
    input8_3.name = 'platform';
    input8_3.value = 3;
    input8_3.selected = getParams.length > 0 && result['result']['idPiattaforma'] == 3;
    const label8_3 = document.createElement('label');
    label8_3.setAttribute('for', 'microsoft')
    label8_3.textContent = 'Microsoft';

    const cancelImg = document.createElement('img');
    cancelImg.src = utils.RESOURCES_DIR + 'x.png';
    cancelImg.alt = '';
    const cancelButton = document.createElement('button');
    cancelButton.type = 'button';
    cancelButton.textContent = 'Annulla';
    cancelButton.appendChild(cancelImg);
    cancelButton.addEventListener('click', (event) => {
        event.preventDefault();
        history.go(-1);
    });

    const saveImg = document.createElement('img');
    saveImg.src = utils.RESOURCES_DIR + 'Marco_semplice_W.png';
    saveImg.alt = '';
    const saveButton = document.createElement('button');
    saveButton.textContent = 'Salva';
    saveButton.type = 'submit';
    saveButton.appendChild(saveImg);

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        
        if (select7.value !== '' && new FormData(event.target).getAll('platform').length > 0) {
            const image1 = document.querySelector('#image1').files[0] ?? null;
            const image2 = document.querySelector('#image2').files[0] ?? null;
            console.log('image1: ' + image1 + ', image2: '+ image2 + ', nome: ' + input1.value + ", prezzo: " + input2.value
                + ", quantità: " + input3.value + ", descrizione: " + textarea4.value + ", proprietà: " + textarea5.value + ", offerta: "
                + input6.value + ", tipo: " + select7.value + ", piattaforma: " + new FormData(event.target).getAll('platform'));
        
            const formData = new FormData();  
            formData.append('image1', image1);
            formData.append('image2', image2);
            formData.append('name', input1.value);
            formData.append('price', input2.value);
            formData.append('quantity', input3.value);
            formData.append('description', textarea4.value);
            formData.append('property', textarea5.value);
            formData.append('sale', input6.value);
            formData.append('type', select7.value);
            formData.append('platform', new FormData(event.target).getAll('platform'));
            const result = await utils.makePostRequest(url, formData);
            if (result['success'] != null) {
                location.href = utils.PAGES_DIR + 'product.php?search' + result['success'];
            } else {
                generateMainContent(result);
            }
        }
    });

    form.appendChild(image1label);
    form.appendChild(image1input);
    form.appendChild(document.createElement('br'));
    form.appendChild(image2label);
    form.appendChild(image2input);
    form.appendChild(document.createElement('br'));
    form.appendChild(label1);
    form.appendChild(input1);
    form.appendChild(document.createElement('br'));
    form.appendChild(label2);
    form.appendChild(input2);
    form.appendChild(document.createElement('br'));
    form.appendChild(label3);
    form.appendChild(input3);
    form.appendChild(document.createElement('br'));
    form.appendChild(label4);
    form.appendChild(textarea4);
    form.appendChild(document.createElement('br'));
    form.appendChild(label5);
    form.appendChild(textarea5);
    form.appendChild(document.createElement('br'));
    form.appendChild(label6);
    form.appendChild(input6);
    form.appendChild(document.createElement('br'));
    form.appendChild(label7);
    form.appendChild(select7);
    form.appendChild(document.createElement('br'));
    form.appendChild(p8);
    form.appendChild(input8_1);
    form.appendChild(label8_1);
    form.appendChild(input8_2);
    form.appendChild(label8_2);
    form.appendChild(input8_3);
    form.appendChild(label8_3);
    form.appendChild(document.createElement('br'));
    form.appendChild(cancelButton);
    form.appendChild(saveButton);

    section.appendChild(h2);
    section.appendChild(form);

    document.querySelector('main').appendChild(section);
}