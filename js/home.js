import * as utils from './utils.js';
displayMainContent();

function displayMainContent() {
    const main = document.querySelector("main");
    main.innerHTML = generateMainContent();
}

function generateMainContent() {
    let content = `
        <section>
            <a href="${utils.PAGES_DIR}results.php?search=switch"><img src="${utils.RESOURCES_DIR}switch.png" alt="NintendoSwitch"/></a><a
            href="${utils.PAGES_DIR}results.php?search=xbox"><img src="${utils.RESOURCES_DIR}xbox.png" alt="Xbox"/></a><a
            href="${utils.PAGES_DIR}results.php?search=ps"><img src="${utils.RESOURCES_DIR}playstation.png" alt="Playstation"/></a>
        </section>
    `;
    return content;
}