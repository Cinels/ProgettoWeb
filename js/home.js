import * as paths from './paths.js';
displayMainContent();

function displayMainContent() {
    const main = document.querySelector("main");
    main.innerHTML += generateMainContent();
}

function generateMainContent() {
    let content = `
        <section>
            <a href="${paths.PAGES_DIR}results.php?search=ps"><img src="${paths.RESOURCES_DIR}playstation.png" alt="Playstation"/></a>
            <a href="${paths.PAGES_DIR}results.php?search=switch"><img src="${paths.RESOURCES_DIR}switch.png" alt="Nintendo Switch"/></a>
            <a href="${paths.PAGES_DIR}results.php?search=xbox"><img src="${paths.RESOURCES_DIR}xbox.png" alt="Xbox"/></a>
        </section>
    `;
    return content;
}