import * as utils from './utils.js';
const getParams = window.location.search;
const urlParams = new URLSearchParams(getParams);
const url = utils.API_DIR + "sign_in.php" + getParams;
displayMainContent();

async function displayMainContent() {
    const result = await utils.makePostRequest(url, new FormData());
    if (urlParams.get('action') === 'edit') {
        generateProfileEditContent(result);
    } else {
        generateSignInContent(result);
    }
}

function generateSignInContent(result) {
    let content = `
    <section>
        <form action="#" method="POST" enctype="multipart/form-data">
            <h2>Registrati</h2>
            <p></p>
            <ul>
                <li>
                    <input type="file" name="image" accept="image/*"/>
                </li><li>
                    <label for="name">Nome:</label><input type="text" id="name" name="name" required/>
                </li><li>
                    <label for="surname">Cognome:</label><input type="text" id="surname" name="surname" required/>
                </li><li>
                    <label for="email">Email:</label><input type="email" id="email" name="email" required/>
                </li><li>
                    <label for="password">Password:</label><input type="password" id="password" name="password" required/>
                </li><li>
                    <label for="check_password">Conferma Password:</label><input type="password" id="check_password" name="check_password" required/>
                </li><li>
                    <input type="submit" name="submit" value="Registrati" />
                </li><li>
                    <p>o</p>
                </li><li>
                    <a href="${utils.PAGES_DIR}login.php"><input type="button" value="Accedi" /></a>
                </li>
            </ul>
        </form>
    </section>`;

    document.querySelector('main').innerHTML = content;

    const form = document.querySelector('main form');
    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        const image = document.querySelector('main form input').files[0] ?? null;
        console.log('image: ' + image + ', name: ' + document.querySelector('#name').value 
            + ', surname: ' + document.querySelector('#surname').value + ', email: ' + document.querySelector('#email').value
            + ', password: ' + document.querySelector('#password').value + ', check password: ' + document.querySelector('#check_password').value);

        const formData = new FormData();
        formData.append('image', image);
        formData.append('name', document.querySelector('#name').value);
        formData.append('surname', document.querySelector('#surname').value);
        formData.append('email', document.querySelector('#email').value);
        formData.append('password', document.querySelector('#password').value);
        formData.append('check_password', document.querySelector('#check_password').value);
        const result = await utils.makePostRequest(url, formData);
        if(result["signin"] === 'success') {
            document.querySelector("form > p").innerText = "";
            location.href = utils.PAGES_DIR + 'index.php';
        } else {
            document.querySelector("form > p").innerText = result["erroresignin"];
        }
    });
}

function generateProfileEditContent(result) {
    const user = result['user'];
    let content = `
    <section>
        <form action="#" method="POST" enctype="multipart/form-data">
            <h2>Modifica Profilo</h2>
            <p></p>
            <ul>
                <li>
                    <input type="file" name="image" accept="image/*" />
                </li><li>
                    <label for="name">Nome:</label><input type="text" id="name" name="name" value='${user['nome']}' required/>
                </li><li>
                    <label for="surname">Cognome:</label><input type="text" id="surname" name="surname" value='${user['cognome']}' required/>
                </li><li>
                    <label for="old_password">Vecchia Password:</label><input type="password" id="old_password" name="old_password" required/>
                </li><li>
                    <label for="password">Nuova Password:</label><input type="password" id="password" name="password"/>
                </li><li>
                    <label for="check_password">Conferma Password:</label><input type="password" id="check_password" name="check_password"/>
                </li><li>
                    <a href="${utils.PAGES_DIR}profile.php"><input type="button" value="Annulla" /></a><input type="submit" name="submit" value="Conferma" />
                </li>
            </ul>
        </form>
    </section>`;

    document.querySelector('main').innerHTML = content;

    const form = document.querySelector('main form');
    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        const image = document.querySelector('main form input').files[0] ?? null;
        console.log('image: ' + image + ', name: ' + document.querySelector('#name').value 
            + ', surname: ' + document.querySelector('#surname').value + ', old password: ' + document.querySelector('#old_password').value
            + ', new password: ' + document.querySelector('#password').value + ', check password: ' + document.querySelector('#check_password').value);

        const formData = new FormData();
        formData.append('image', image);
        formData.append('name', document.querySelector('#name').value);
        formData.append('surname', document.querySelector('#surname').value);
        formData.append('old_password', document.querySelector('#old_password').value);
        formData.append('password', document.querySelector('#password').value);
        formData.append('check_password', document.querySelector('#check_password').value);
        const result = await utils.makePostRequest(url, formData);
        if(result["edit"] === 'success') {
            document.querySelector("form > p").innerText = "";
            location.href = utils.PAGES_DIR + 'profile.php';
        } else {
            document.querySelector("form > p").innerText = result["erroresignin"];
        }
    });
}