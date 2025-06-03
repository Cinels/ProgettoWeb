-- Tipo 1 console
-- Tipo 2 controller
-- Tipo 3 videogioco

insert into prodotto
values
('Nintendo Switch', 259.59, 100, 'Goditi l\'esperienza completa di una console da casa, anche senza televisore. Nintendo Switch può trasformarsi, così troverai sempre dei momenti per giocare, anche quando sei impegnato. Divertiti dove, quando e con chi vuoi!', 'Memoria interna: 32 GB', true, 1, 'venditore@negozio.it'),
('Nintendo Switch Lite', 199, 100, 'Pensata per il gioco in mobilità. La console per i giocatori sempre in movimento. Nintendo Switch Lite è una console compatta, leggera e con comandi integrati che espande la famiglia Nintendo Switch.', 'Memoria interna: 32 GB', true, 1, 'venditore@negozio.it'),
('Nintendo Switch OLED', 299, 100, 'Nintendo Switch – Modello OLED dispone di uno schermo OLED da 7 pollici con una cornice più sottile. I colori intensi e l\'elevato contrasto dello schermo garantiscono un\'esperienza di gioco appagante in modalità portatile e da tavolo. Osserva i tuoi giochi prendere vita, che tu stia sfrecciando a tutta velocità su un circuito o affrontando i nemici in furiosi combattimenti.', 'Memoria interna: 32 GB', false, 1, 'venditore@negozio.it'),
('PS5 Slim', 550, 100, 'GIOCA COME MAI PRIMA D’ORA. Prova un caricamento ultra rapido con un\'unità SSD ad altissima velocità, un coinvolgimento ancora maggiore grazie al supporto per il feedback aptico, ai grilletti adattivi e all\'audio 3D e scopri una nuovissima generazione di incredibili giochi PlayStation.', 'Memoria interna: 1 TB', true, 1, 'venditore@negozio.it'),
('PS5 Pro', 749, 100, 'Scatena la potenza del gioco. Con la console PlayStation®5 Pro, i più grandi creatori di giochi al mondo possono migliorare i loro titoli con incredibili funzionalità come il ray-tracing avanzato, immagini estremamente nitide per il tuo TV 4K e un\'azione di gioco con una frequenza di fotogrammi elevata.', 'Memoria interna: 2 TB', false, 1, 'venditore@negozio.it'),
('Xbox Series S', 399.99, 100, 'Scopri la nuovissima Xbox Series S, la nostra Xbox più compatta di tutti i tempi, 100% Digitale, una console next-gen ad un prezzo accessibile', 'Memoria interna: 1 TB', true, 1, 'venditore@negozio.it'),
('Xbox Series X', 599.99, 100, 'Sperimenta il miglior valore nel settore gaming con Xbox Series S, ora disponibile con un\'unità SSD da 1 TB in Robot White. Immergiti in giochi come Avowed, Indiana Jones e l’Antico Cerchio, Call of Duty: Black Ops 6 e molti altri', 'Memoria interna: 1 TB', false, 1, 'venditore@negozio.it'),
('Steam Deck OLED', 569, 100, 'Dispositivo portatile all-in-one per i giochi per PC. Steam Deck è un ottimo punto di ingresso per i giochi PC in portabilità. Equilibra potenza, ergonomia e durata della batteria ed è progettato per essere comodo per lunghe sessioni di gioco. Steam Deck può supportare i titoli più recenti e continua a essere supportato regolarmente con aggiornamenti software.', 'Memoria interna: 512 GB', false, 1, 'venditore@negozio.it');

insert into prodotto
values ('Sony PlayStation®5 - DualSense™ Wireless', 54.99, 100, 'Scopri un\'esperienza di gioco più coinvolgente e coinvolgente che dà vita all\'azione nelle tue mani. Il controller wireless DualSense offre feedback tattile coinvolgente, trigger adattivi dinamici e un microfono integrato, il tutto in un design iconico e confortevole.', '', true, 2, 'venditore@negozio.it'),
('Nintendo Switch Joy-Con (Set di 2)', 66, 100, 'Coppia di controller Joy-Con per Nintendo Switch, compatibili con tutte le versioni della console.', '', false, 2, 'venditore@negozio.it'),
('Nintendo Switch Pro Controller', 59, 100, 'Controller Pro ufficiale per Nintendo Switch, con impugnatura ergonomica e funzionalità avanzate.', '', false, 2, 'venditore@negozio.it'),
('Controller Wireless per Xbox', 64, 100, 'Controller wireless ufficiale per Xbox, compatibile con Xbox Series X|S, Xbox One, PC Windows, Android e iOS.', '', false, 2, 'venditore@negozio.it');

INSERT INTO PRODOTTO (nome, prezzo, quantitàDisponibile, descrizione, proprietà, offerta, tipo, idVenditore)
VALUES
('The Legend of Zelda: Breath of the Wild', 59, 100, 'Un epico open-world dove Link esplora Hyrule per sconfiggere Calamity Ganon.', 'PEGI 12', false, 3, 'venditore@negozio.it'),
('Super Mario Odyssey', 59, 100, 'Mario intraprende un viaggio globale con Cappy per salvare Peach da Bowser.', 'PEGI 7', false, 3, 'venditore@negozio.it'),
('Animal Crossing: New Horizons', 59, 100, 'Crea la tua isola paradisiaca e vivi con adorabili abitanti.', 'PEGI 3', false, 3, 'venditore@negozio.it'),
('Mario Kart 8 Deluxe', 59, 100, 'Corse frenetiche con i personaggi Nintendo in circuiti spettacolari.', 'PEGI 3', false, 3, 'venditore@negozio.it'),
('Super Smash Bros. Ultimate', 59, 100, 'Combattimenti tra icone dei videogiochi in arene dinamiche.', 'PEGI 12', false, 3, 'venditore@negozio.it'),
('Pokémon Legends: Arceus', 59, 100, 'Esplora la regione di Hisui e cattura Pokémon in un\'avventura storica.', 'PEGI 7', false, 3, 'venditore@negozio.it'),
('Kirby and the Forgotten Land', 59, 100, 'Kirby esplora un mondo misterioso in un\'avventura 3D.', 'PEGI 7', false, 3, 'venditore@negozio.it'),
('Super Mario 3D World + Bowser\'s Fury', 59, 100, 'Due avventure platform in un unico pacchetto.', 'PEGI 3', false, 3, 'venditore@negozio.it'),
('Clubhouse Games: 51 Worldwide Classics', 39, 100, 'Una raccolta di 51 giochi classici da tutto il mondo.', 'PEGI 12', false, 3, 'venditore@negozio.it');

INSERT INTO PRODOTTO (nome, prezzo, quantitàDisponibile, descrizione, proprietà, offerta, tipo, idVenditore)
VALUES
('Marvel’s Spider-Man 2', 79, 100, 'Peter Parker e Miles Morales affrontano nuove minacce in questa avventura epica.', 'PEGI 16', false, 3, 'venditore@negozio.it'),
('Hogwarts Legacy', 74, 100, 'Esplora il mondo magico di Hogwarts nel XIX secolo in questo RPG open-world.', 'PEGI 12', false, 3, 'venditore@negozio.it'),
('The Last of Us Parte II Remastered', 49, 100, 'Vivi la storia di Ellie in un mondo post-apocalittico con grafica migliorata.', 'PEGI 18', false, 3, 'venditore@negozio.it'),
('Assassin’s Creed Mirage', 49, 100, 'Torna alle origini della serie con questa avventura ambientata a Baghdad.', 'PEGI 18', false, 3, 'venditore@negozio.it'),
('Gran Turismo 7', 29, 100, 'Simulatore di guida realistico con una vasta gamma di auto e circuiti.', 'PEGI 3', true, 3, 'venditore@negozio.it'),
('Astro Bot', 69, 100, 'Un platform 3D che sfrutta al massimo le funzionalità del DualSense.', 'PEGI 7', false, 3, 'venditore@negozio.it'),
('Cyberpunk 2077', 49, 100, 'Esplora Night City in questo RPG futuristico ricco di azione e scelte.', 'PEGI 18', true, 3, 'venditore@negozio.it'),
('Baldur’s Gate 3', 69, 100, 'Un RPG fantasy basato su D&D con una storia profonda e combattimenti tattici.', 'PEGI 18', false, 3, 'venditore@negozio.it'),
('Final Fantasy VII Rebirth', 79, 100, 'Secondo capitolo del remake della saga leggendaria di Final Fantasy.', 'PEGI 16', false, 3, 'venditore@negozio.it');

INSERT INTO PRODOTTO (nome, prezzo, quantitàDisponibile, descrizione, proprietà, offerta, tipo, idVenditore)
VALUES
('Hogwarts Legacy', 74.99, 100, 'Vivi un\'avventura magica nel mondo di Hogwarts.', 'PEGI 16', false, 3, 'venditore@negozio.it'),
('Red Dead Redemption 2', 20, 100, 'Un\'epica avventura nel selvaggio West di Rockstar Games.', 'PEGI 18', true, 3, 'venditore@negozio.it'),
('Cyberpunk 2077', 49.90, 100, 'Esplora Night City in questo RPG futuristico ricco di azione e scelte.', 'PEGI 18', true, 3, 'venditore@negozio.it'),
('Forza Horizon 5', 69.99, 100, 'Corse open-world ambientate in Messico.', 'PEGI 3', false, 3, 'venditore@negozio.it'),
('Metaphor: ReFantazio', 69, 100, 'Un RPG fantasy dai creatori di Persona, in un mondo magico.', 'PEGI 16', false, 3, 'venditore@negozio.it'),
('Halo Infinite', 10, 100, 'Da una delle saghe più iconiche dei giochi, Halo è più grande che mai. Con un\'ampia campagna open-world e un\'esperienza multiplayer dinamica free to play.', 'PEGI 16', true, 3, 'venditore@negozio.it'),
('F1® 24', 29.99, 100, 'Il gioco ufficiale del Campionato Mondiale di Formula 1 2024.', 'PEGI 3', true, 3, 'venditore@negozio.it'),
('Grand Theft Auto V: Premium Edition', 19.99, 100, 'Vivi la vita criminale a Los Santos in questa edizione completa.', 'PEGI 18', true, 3, 'venditore@negozio.it'),
('Assassin’s Creed Mirage', 19.99, 100, 'Torna alle origini della serie con questa avventura ambientata a Baghdad.', 'PEGI 18', true, 3, 'venditore@negozio.it');


