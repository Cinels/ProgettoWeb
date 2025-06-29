-- Tipo 1 console
-- Tipo 2 controller
-- Tipo 3 videogioco

insert into utente
values
('venditore@negozio.it', 'Franco', 'Ruccacucchi', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', "https://us-tuna-sounds-images.voicemod.net/7a1857fb-c4d1-4422-9652-fcb4ff3a9c48-1722539434495.jpg"), 
    ('cliente@negozio.it', 'Giovanna', 'Crisafulli', '6c8e6ef93f23acb9cd13cefb49ff73dcf021586fc8df7026f66bf423e30d4e0b', NULL);

insert into venditore
values
('venditore@negozio.it');

INSERT into cliente values ('cliente@negozio.it');

insert into prodotto
values
(1, 'Nintendo Switch', 259.59, 100, 'Goditi l\'esperienza completa di una console da casa, anche senza televisore. Nintendo Switch può trasformarsi, così troverai sempre dei momenti per giocare, anche quando sei impegnato. Divertiti dove, quando e con chi vuoi!', 'Memoria interna: 32 GB', true, 1, 'venditore@negozio.it'),
(2, 'Nintendo Switch Lite', 199, 100, 'Pensata per il gioco in mobilità. La console per i giocatori sempre in movimento. Nintendo Switch Lite è una console compatta, leggera e con comandi integrati che espande la famiglia Nintendo Switch.', 'Memoria interna: 32 GB', true, 1, 'venditore@negozio.it'),
(3, 'Nintendo Switch OLED', 299, 100, 'Nintendo Switch – Modello OLED dispone di uno schermo OLED da 7 pollici con una cornice più sottile. I colori intensi e l\'elevato contrasto dello schermo garantiscono un\'esperienza di gioco appagante in modalità portatile e da tavolo. Osserva i tuoi giochi prendere vita, che tu stia sfrecciando a tutta velocità su un circuito o affrontando i nemici in furiosi combattimenti.', 'Memoria interna: 32 GB', false, 1, 'venditore@negozio.it'),
(4, 'PS5 Slim', 550, 100, 'GIOCA COME MAI PRIMA D’ORA. Prova un caricamento ultra rapido con un\'unità SSD ad altissima velocità, un coinvolgimento ancora maggiore grazie al supporto per il feedback aptico, ai grilletti adattivi e all\'audio 3D e scopri una nuovissima generazione di incredibili giochi PlayStation.', 'Memoria interna: 1 TB', true, 1, 'venditore@negozio.it'),
(5, 'PS5 Pro', 749, 100, 'Scatena la potenza del gioco. Con la console PlayStation®5 Pro, i più grandi creatori di giochi al mondo possono migliorare i loro titoli con incredibili funzionalità come il ray-tracing avanzato, immagini estremamente nitide per il tuo TV 4K e un\'azione di gioco con una frequenza di fotogrammi elevata.', 'Memoria interna: 2 TB', false, 1, 'venditore@negozio.it'),
(6, 'Xbox Series S', 399.99, 100, 'Scopri la nuovissima Xbox Series S, la nostra Xbox più compatta di tutti i tempi, 100% Digitale, una console next-gen ad un prezzo accessibile', 'Memoria interna: 1 TB', true, 1, 'venditore@negozio.it'),
(7, 'Xbox Series X', 599.99, 100, 'Sperimenta il miglior valore nel settore gaming con Xbox Series S, ora disponibile con un\'unità SSD da 1 TB in Robot White. Immergiti in giochi come Avowed, Indiana Jones e l’Antico Cerchio, Call of Duty: Black Ops 6 e molti altri', 'Memoria interna: 1 TB', false, 1, 'venditore@negozio.it'),
(8, 'Steam Deck OLED', 569, 100, 'Dispositivo portatile all-in-one per i giochi per PC. Steam Deck è un ottimo punto di ingresso per i giochi PC in portabilità. Equilibra potenza, ergonomia e durata della batteria ed è progettato per essere comodo per lunghe sessioni di gioco. Steam Deck può supportare i titoli più recenti e continua a essere supportato regolarmente con aggiornamenti software.', 'Memoria interna: 512 GB', false, 1, 'venditore@negozio.it');

insert into prodotto
values (9, 'Sony PlayStation®5 - DualSense™ Wireless', 54.99, 100, 'Scopri un\'esperienza di gioco più coinvolgente e coinvolgente che dà vita all\'azione nelle tue mani. Il controller wireless DualSense offre feedback tattile coinvolgente, trigger adattivi dinamici e un microfono integrato, il tutto in un design iconico e confortevole.', '', true, 2, 'venditore@negozio.it'),
(10, 'Nintendo Switch Joy-Con (Set di 2)', 66, 100, 'Coppia di controller Joy-Con per Nintendo Switch, compatibili con tutte le versioni della console.', '', false, 2, 'venditore@negozio.it'),
(11, 'Nintendo Switch Pro Controller', 59, 100, 'Controller Pro ufficiale per Nintendo Switch, con impugnatura ergonomica e funzionalità avanzate.', '', false, 2, 'venditore@negozio.it'),
(12, 'Controller Wireless per Xbox', 64, 100, 'Controller wireless ufficiale per Xbox, compatibile con Xbox Series X|S, Xbox One, PC Windows, Android e iOS.', '', false, 2, 'venditore@negozio.it');

INSERT INTO PRODOTTO
VALUES
(13, 'The Legend of Zelda: Breath of the Wild', 59, 100, 'Un epico open-world dove Link esplora Hyrule per sconfiggere Calamity Ganon.', 'PEGI 12', false, 3, 'venditore@negozio.it'),
(14, 'Super Mario Odyssey', 59, 100, 'Mario intraprende un viaggio globale con Cappy per salvare Peach da Bowser.', 'PEGI 7', false, 3, 'venditore@negozio.it'),
(15, 'Animal Crossing: New Horizons', 59, 100, 'Crea la tua isola paradisiaca e vivi con adorabili abitanti.', 'PEGI 3', false, 3, 'venditore@negozio.it'),
(16, 'Mario Kart 8 Deluxe', 59, 100, 'Corse frenetiche con i personaggi Nintendo in circuiti spettacolari.', 'PEGI 3', false, 3, 'venditore@negozio.it'),
(17, 'Super Smash Bros. Ultimate', 59, 100, 'Combattimenti tra icone dei videogiochi in arene dinamiche.', 'PEGI 12', false, 3, 'venditore@negozio.it'),
(18, 'Pokémon Legends: Arceus', 59, 100, 'Esplora la regione di Hisui e cattura Pokémon in un\'avventura storica.', 'PEGI 7', false, 3, 'venditore@negozio.it'),
(19, 'Kirby and the Forgotten Land', 59, 100, 'Kirby esplora un mondo misterioso in un\'avventura 3D.', 'PEGI 7', false, 3, 'venditore@negozio.it'),
(20, 'Super Mario 3D World + Bowser\'s Fury', 59, 100, 'Due avventure platform in un unico pacchetto.', 'PEGI 3', false, 3, 'venditore@negozio.it'),
(21, 'Clubhouse Games: 51 Worldwide Classics', 39, 100, 'Una raccolta di 51 giochi classici da tutto il mondo.', 'PEGI 12', false, 3, 'venditore@negozio.it');

INSERT INTO PRODOTTO
VALUES
(22, 'Marvel’s Spider-Man 2', 79, 100, 'Peter Parker e Miles Morales affrontano nuove minacce in questa avventura epica.', 'PEGI 16', false, 3, 'venditore@negozio.it'),
(23, 'Hogwarts Legacy', 74, 100, 'Esplora il mondo magico di Hogwarts nel XIX secolo in questo RPG open-world.', 'PEGI 12', false, 3, 'venditore@negozio.it'),
(24, 'The Last of Us Parte II Remastered', 49, 100, 'Vivi la storia di Ellie in un mondo post-apocalittico con grafica migliorata.', 'PEGI 18', false, 3, 'venditore@negozio.it'),
(25, 'Assassin’s Creed Mirage', 49, 100, 'Torna alle origini della serie con questa avventura ambientata a Baghdad.', 'PEGI 18', false, 3, 'venditore@negozio.it'),
(26, 'Gran Turismo 7', 29, 100, 'Simulatore di guida realistico con una vasta gamma di auto e circuiti.', 'PEGI 3', true, 3, 'venditore@negozio.it'),
(27, 'Astro Bot', 69, 100, 'Un platform 3D che sfrutta al massimo le funzionalità del DualSense.', 'PEGI 7', false, 3, 'venditore@negozio.it'),
(28, 'Cyberpunk 2077', 49, 100, 'Esplora Night City in questo RPG futuristico ricco di azione e scelte.', 'PEGI 18', true, 3, 'venditore@negozio.it'),
(29, 'Baldur’s Gate 3', 69, 100, 'Un RPG fantasy basato su D&D con una storia profonda e combattimenti tattici.', 'PEGI 18', false, 3, 'venditore@negozio.it'),
(30, 'Final Fantasy VII Rebirth', 79, 100, 'Secondo capitolo del remake della saga leggendaria di Final Fantasy.', 'PEGI 16', false, 3, 'venditore@negozio.it');

INSERT INTO PRODOTTO
VALUES
(31, 'Hogwarts Legacy', 74.99, 100, 'Vivi un\'avventura magica nel mondo di Hogwarts.', 'PEGI 16', false, 3, 'venditore@negozio.it'),
(32, 'Red Dead Redemption 2', 20, 100, 'Un\'epica avventura nel selvaggio West di Rockstar Games.', 'PEGI 18', true, 3, 'venditore@negozio.it'),
(33, 'Cyberpunk 2077', 49.90, 100, 'Esplora Night City in questo RPG futuristico ricco di azione e scelte.', 'PEGI 18', true, 3, 'venditore@negozio.it'),
(34, 'Forza Horizon 5', 69.99, 100, 'Corse open-world ambientate in Messico.', 'PEGI 3', false, 3, 'venditore@negozio.it'),
(35, 'Metaphor: ReFantazio', 69, 100, 'Un RPG fantasy dai creatori di Persona, in un mondo magico.', 'PEGI 16', false, 3, 'venditore@negozio.it'),
(36, 'Halo Infinite', 10, 100, 'Da una delle saghe più iconiche dei giochi, Halo è più grande che mai. Con un\'ampia campagna open-world e un\'esperienza multiplayer dinamica free to play.', 'PEGI 16', true, 3, 'venditore@negozio.it'),
(37, 'F1® 24', 29.99, 100, 'Il gioco ufficiale del Campionato Mondiale di Formula 1 2024.', 'PEGI 3', true, 3, 'venditore@negozio.it'),
(38, 'Grand Theft Auto V: Premium Edition', 19.99, 100, 'Vivi la vita criminale a Los Santos in questa edizione completa.', 'PEGI 18', true, 3, 'venditore@negozio.it'),
(39, 'Assassin’s Creed Mirage', 19.99, 100, 'Torna alle origini della serie con questa avventura ambientata a Baghdad.', 'PEGI 18', true, 3, 'venditore@negozio.it');

insert into PIATTAFORMA
VALUES
(1, 'Nintendo Switch', 'Nintendo'),
(2, 'PS5', 'Sony'),
(3, 'Xbox', 'Microsoft'),
(4, 'Steam Deck', 'Valve');

-- Console e controller (prodotti 1-11)
INSERT INTO COMPATIBILITA
VALUES
-- Nintendo Switch
(1, 1), (2, 1), (3, 1),
-- PS5
(4, 2), (5, 2),
-- Xbox
(6, 3), (7, 3),
-- Steam Deck
(8, 4),
-- Controller
(9, 2), (10, 1), (11, 1), (12, 3);

-- Giochi Nintendo Switch (prodotti 13-21)
INSERT INTO COMPATIBILITA
VALUES
(13, 1), (14, 1), (15, 1), (16, 1), (17, 1), (18, 1), (19, 1), (20, 1), (21, 1);

-- Giochi PS5 (prodotti 22-30)
INSERT INTO COMPATIBILITA
VALUES
(22, 2), (23, 2), (24, 2), (25, 2), (26, 2), (27, 2), (28, 2), (29, 2), (30, 2);

-- Giochi Xbox (prodotti 31-39)
INSERT INTO COMPATIBILITA
VALUES
(31, 3), (32, 3), (33, 3), (34, 3), (35, 3), (36, 3), (37, 3), (38, 3), (39, 3);

-- Console
INSERT INTO IMMAGINE VALUES
('nintendo_switch_1', 1, 1, 'Console/nintendo_switch_1.jpg'),
('nintendo_switch_2', 1, 2, 'Console/nintendo_switch_2.jpg'),
('nintendo_switch_lite_1', 2, 1, 'Console/nintendo_switch_lite_1.jpg'),
('nintendo_switch_lite_2', 2, 2, 'Console/nintendo_switch_lite_2.jpg'),
('nintendo_switch_oled_1', 3, 1, 'Console/nintendo_switch_oled_1.jpg'),
('nintendo_switch_oled_2', 3, 2, 'Console/nintendo_switch_oled_2.png'),
('ps5_1', 4, 1, 'Console/ps5_1.jpg'),
('ps5_2', 4, 2, 'Console/ps5_2.jpg'),
('ps5_pro_1', 5, 1, 'Console/ps5_pro_1.jpg'),
('ps5_pro_2', 5, 2, 'Console/ps5_pro_2.jpg'),
('steam_deck_1', 8, 1, 'Console/steam_deck_1.jpg'),
('xbox_S_1', 6, 1, 'Console/xbox_S_1.jpg'),
('xbox_S_2', 6, 2, 'Console/xbox_S_2.jpg'),
('xbox_x_1', 7, 1, 'Console/xbox_x_1.jpg'),
('xbox_x_2', 7, 2, 'Console/xbox_x_2.jpg');

-- Controller
INSERT INTO IMMAGINE (nome, idProdotto, numeroProgressivo, link) VALUES
('controller_ps5_1', 9, 1, 'Controller/controller_ps5_1.jpg'),
('controller_switch_1', 11, 1, 'Controller/controller_switch_1.jpg'),
('controller_xbox_1', 12, 1, 'Controller/controller_xbox_1.jpg'),
('joycon_switch_1', 10, 1, 'Controller/joycon_switch_1.jpg');

-- Videogiochi
INSERT INTO IMMAGINE (nome, idProdotto, numeroProgressivo, link) VALUES
('zelda_botw', 13, 1, 'Videogiochi/zelda_botw.jpg'),
('super_mario_odyssey', 14, 1, 'Videogiochi/super_mario_odyssey.jpg'),
('animal_crossing', 15, 1, 'Videogiochi/animal_crossing.jpg'),
('mario_kart_8_dx', 16, 1, 'Videogiochi/mario_kart_8_dx.jpg'),
('smash', 17, 1, 'Videogiochi/smash.jpg'),
('pokemon_leggende_arceus', 18, 1, 'Videogiochi/pokemon_leggende_arceus.jpg'),
('kirby_terra_perduta', 19, 1, 'Videogiochi/kirby_terra_perduta.jpg'),
('super_mario_3d_world', 20, 1, 'Videogiochi/super_mario_3d_world.jpg'),
('51_worldwide_games', 21, 1, 'Videogiochi/51_worldwide_games.jpg'),
('marvel_spiderman_2', 22, 1, 'Videogiochi/marvel_spiderman_2.jpg'),
('hogwarts_legacy_ps5', 23, 1, 'Videogiochi/hogwarts_legacy_ps5.jpg'),
('last_of_us_2_ps5', 24, 1, 'Videogiochi/last_of_us_2_ps5.jpg'),
('assassins_creed_mirage_ps5', 25, 1, 'Videogiochi/assassins_creed_mirage_ps5.jpg'),
('gran_turismo_7_ps5', 26, 1, 'Videogiochi/gran_turismo_7_ps5.jpg'),
('astrobot', 27, 1, 'Videogiochi/astrobot.jpg'),
('cyberpunk_ps5', 28, 1, 'Videogiochi/cyberpunk_ps5.jpg'),
('baldurs_gate_3_ps5', 29, 1, 'Videogiochi/baldurs_gate_3_ps5.jpg'),
('final_fantasy_vii_ps5', 30, 1, 'Videogiochi/final_fantasy_vii_ps5.jpg'),
('hogwarts_legacy_xbox', 31, 1, 'Videogiochi/hogwarts_legacy_xbox.jpg'),
('rdr2_xbox', 32, 1, 'Videogiochi/rdr2_xbox.jpg'),
('cyberpunk_xbox', 33, 1, 'Videogiochi/cyberpunk_xbox.jpg'),
('forza_horizon_5_xbox', 34, 1, 'Videogiochi/forza_horizon_5_xbox.jpg'),
('metaphor_re_fantazio_xbox', 35, 1, 'Videogiochi/metaphor_re_fantazio_xbox.jpg'),
('halo_infinite_xbox', 36, 1, 'Videogiochi/halo_infinite_xbox.jpg'),
('f1_24', 37, 1, 'Videogiochi/f1_24.jpg'),
('gta_v_xbox', 38, 1, 'Videogiochi/gta_v_xbox.jpg'),
('assassins_creed_mirage_xbox', 39, 1, 'Videogiochi/assassins_creed_mirage_xbox.jpg');

INSERT INTO ORDINE VALUES (1, '2025-06-29', 1, '2025-06-30', 1, 'cliente@negozio.it', 'venditore@negozio.it', 50);

INSERT INTO DETTAGLIO_ORDINE VALUES (1,1,1), (11,1,1);
