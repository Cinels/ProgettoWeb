import * as utils from './utils.js';
const url = utils.API_DIR + "profile.php";
displayMainContent();

async function displayMainContent() {
    generateMainContent(await utils.makePostRequest(url, new FormData()));
}

function generateMainContent(result) {
    // <section>
    //     <section>Profilo</section>
    //     <form action="" method="POST">
    //         <button type="submit" name="logout" value="Esci">Esci<img src="${utils.RESOURCES_DIR}exit.png" alt=""/></button>
    //     </form>
    //     <section>Notifiche</section>
    // </section>

    document.querySelector('main').innerHTML = "";

    const section = document.createElement('section');

    const img = document.createElement('img');
    img.src = utils.RESOURCES_DIR + 'exit.png';
    img.alt = '';
    
    const button = document.createElement('button');
    button.name = 'logout';
    button.textContent = "Esci";
    button.addEventListener('click', async (event) => {
        event.preventDefault();
        console.log("logout");

        const formData = new FormData();
        formData.append('logout', true);
        const result = await utils.makePostRequest(url, formData)
        if (result['logout']) {
            document.location = utils.PAGES_DIR + 'index.php';
        } else {
            generateMainContent(result);
        }
    });
    button.appendChild(img);

    section.appendChild(generateProfileSection(result['user'], result['user_type']));
    section.appendChild(button);
    section.appendChild(generateNotificationSection(result['notifications']));
    
    document.querySelector('main').appendChild(section);
}

function generateProfileSection(profile, user_type) {
    // <section>
    //     <img src="${profile['foto_profilo'] ?? utils.RESOURCES_DIR + "header/utente.png"}" alt="Foto Profilo"/>
    //     <p>Nome: ${profile['nome']} ${profile['cognome']}</p>
    //     <p>Email: ${profile['email']}</p>
    //     <p>Tipo profilo: ${user_type}</p>
    //     <button name='edit_profile'>Modifica<img src="${utils.RESOURCES_DIR}matita.png" alt=''/></button>
    // </section>

    const section = document.createElement('section');
    
    const img = document.createElement('img');
    img.src = profile['fotoProfilo'] != null ? utils.DB_RESOURCES_DIR + profile['fotoProfilo'] : utils.RESOURCES_DIR + "header/utente.png";
    img.alt = 'Foto Profilo';

    const p1 = document.createElement('p');
    p1.textContent = 'Nome: ' + profile['nome'] + ' ' + profile['cognome'];

    const p2 = document.createElement('p');
    p2.textContent = 'Email: ' + profile['email'];

    const p3 = document.createElement('p');
    p3.textContent = 'Tipo profilo: ' + user_type;

    const editImage = document.createElement('img');
    editImage.src = utils.RESOURCES_DIR + 'matita.png';
    editImage.alt = '';
    
    const button = document.createElement('button');
    button.name = 'edit_profile';
    button.textContent = 'Modifica Profilo';
    button.addEventListener('click', (event) => {
        event.preventDefault();
        document.location = utils.PAGES_DIR + 'sign_in.php?action=edit';
    });
    button.appendChild(editImage);

    section.appendChild(img);
    section.appendChild(p1);
    section.appendChild(p2);
    section.appendChild(p3);
    section.appendChild(button);

    return section;
}

function generateNotificationSection(notifications) {
    // <section>
    //     <h2><img src="${utils.RESOURCES_DIR}campanella.png" alt=""/>Notifiche</h2>
    //     <ul>
    //         for (let i = 0; i < notifications.length; i++) {
    //             const notification = notifications[i];
    //             <li>
    //                 <h3>${notification["tipo"]} ${notification["data"]}</h3>
    //                 <p>${notification["testo"]}</p>
    //                 if (notification['letta']) {
    //                     <a href="?id=${notification['idNotifica']}&notification=unread"><img src="" alt="Segna come da leggere"/></a>
    //                 } else {
    //                     <a href="?id=${notification['idNotifica']}&notification=read"><img src="" alt="Segna come gia letta"/></a>
    //                 }
    //                 <a href="?id=${notification['idNotifica']}&notification=delete"><img src="" alt="Elimina"/></a>
    //             </li>
    //         }
    //     </ul>
    // </section>

    const section = document.createElement('section');

    const img = document.createElement('img');
    img.src = utils.RESOURCES_DIR + 'campanella.png';
    img.alt = '';

    const h2 = document.createElement('h2');
    h2.textContent = 'Notifiche';

    const ul = document.createElement('ul');

    for (let i = 0; i < notifications.length; i++) {
        const notification = notifications[i];
        const li = document.createElement('li');
        const title = notification['letta'] == 1 ? document.createElement('p') : document.createElement('h3');
        title.textContent = notification['tipo'] + ' ' + notification['data'];

        const p = document.createElement('p');
        p.textContent = notification['testo'];

        const readImg = document.createElement('img');
        readImg.src = notification['letta'] == 1 ? utils.RESOURCES_DIR + 'chat_B.png' : utils.RESOURCES_DIR + 'chat_B_dot.png' ;
        readImg.alt = notification['letta'] == 1 ? 'Segna come da leggere' : 'Segna come già letta' ;
        
        const readButton = document.createElement('button');
        readButton.name = 'read';
        readButton.appendChild(readImg);
        readButton.addEventListener('click', (event) => {
            notificationListener(notification['letta'] == 1 ? 'unread' : 'read', notification['idNotifica'], event);
        });

        const deleteImg = document.createElement('img');
        deleteImg.src = utils.RESOURCES_DIR + 'cestino_B.png';
        deleteImg.alt = 'Elimina';

        const deleteButton = document.createElement('button');
        deleteButton.name = 'delete';
        deleteButton.appendChild(deleteImg);
        deleteButton.addEventListener('click', (event) => {
            notificationListener('delete', notification['idNotifica'], event);
        });
        
        li.appendChild(title);
        li.appendChild(p);
        li.appendChild(readButton);
        li.appendChild(deleteButton);
        ul.appendChild(li);
    }

    section.appendChild(img);
    section.appendChild(h2);
    section.appendChild(ul);

    return section;
}

async function notificationListener(action, id, event) {
    event.preventDefault();
    console.log(action + " " + id);

    const formData = new FormData();
    formData.append('action', action);
    formData.append('id', id);
    generateMainContent(await utils.makePostRequest(url, formData));
}