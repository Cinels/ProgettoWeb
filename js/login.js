import * as utils from './utils.js';
displayMainContent();

function displayMainContent() {
    const main = document.querySelector("main");
    main.innerHTML += generateMainContent();

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
            <h2>Accedi</h2>
            <form action="#" method="POST">`;
    // if(typeof input !== 'undefined') {
        content += `<p></p>`;
    // }
    content += `<ul>
                    <li>
                        <label for="email">Email:</label><input type="email" id="email" name="email" required/>
                    </li><li>
                        <label for="password">Password:</label><input type="password" id="password" name="password" required/>
                    </li><li>
                        <input type="submit" name="submit" value="Accedi" />
                    </li><li>
                        <p>o</p>
                    </li><li>
                        <a href="${utils.PAGES_DIR}sign_in.php"><input type="button" value="Registrati" /></a>
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
        if(json["success"]) {
            document.querySelector("form > p").innerText = "";
            location.href = utils.PAGES_DIR + "index.php";
        } else {
            document.querySelector("form > p").innerText = json["message"];
        }
    } catch (error) {
        console.log(error.message);
    }
}