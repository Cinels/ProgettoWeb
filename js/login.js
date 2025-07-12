import * as utils from './utils.js';
displayMainContent();

function displayMainContent() {
    const main = document.querySelector("main");
    main.innerHTML = generateMainContent();

    document.querySelector("main form").addEventListener("submit", function (event) {
        event.preventDefault();
        const email = document.querySelector("#email").value;
        const password = document.querySelector("#password").value;
        login(email, password);
    });
}

function generateMainContent() {
    let content = `
        <section>
            <form action="#" method="POST">
                <h2>Accedi</h2>
                <p></p>
                <ul>
                    <li>
                        <label for="email">Email:</label><input type="email" id="email" name="email" required/>
                    </li><li>
                        <label for="password">Password:</label><input type="password" id="password" name="password" required/>
                    </li><li>
                        <button type="submit" name="submit">Accedi</button>
                    </li><li>
                        <p>o</p>
                    </li><li>
                        <a type='button' href="${utils.PAGES_DIR}sign_in.php?action=create"><button type="button">Registrati</button></a>
                    </li>
                </ul>
            </form>
        </section>
    `;
    return content;
}

async function login(email, password) {
    const url = `${utils.API_DIR}login.php`;
    const formData = new FormData();
    formData.append('email', email);
    formData.append('password', password);
    const result = await utils.makePostRequest(url, formData);
    if(result["success"]) {
        document.querySelector("form > p").innerText = "";
        location.href = utils.PAGES_DIR + 'index.php';
    } else {
        document.querySelector("form > p").innerText = result["message"];
    }
}