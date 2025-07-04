-- *********************************************
-- * SQL MySQL generation                      
-- *--------------------------------------------
-- * DB-MAIN version: 11.0.2              
-- * Generator date: Sep 14 2021              
-- * Generation date: Thu Jun  5 01:33:41 2025 
-- * LUN file: C:\xampp\htdocs\ProgettoWeb\database\database.lun 
-- * Schema: negozio_logico/1-1 
-- ********************************************* 


-- Database Section
-- ________________ 

create database negozio_logico;
use negozio_logico;


-- Tables Section
-- _____________ 

create table CARRELLO (
     idProdotto int not null,
     idCliente varchar(40) not null,
     quantita int not null,
     constraint IDCARRELLO primary key (idCliente, idProdotto));

create table CLIENTE (
     email varchar(40) not null,
     constraint FKR_1_ID primary key (email));

create table COMPATIBILITA (
     idProdotto int not null,
     idPiattaforma int not null,
     constraint IDCOMPATIBILITA primary key (idPiattaforma, idProdotto));

create table CRONOLOGIA_PRODOTTI (
     idCliente varchar(40) not null,
     idProdotto int not null,
     oraRicerca datetime not null,
     constraint IDCRONOLOGIA_PRODOTTI primary key (idCliente, idProdotto));

create table CRONOLOGIA_RICERCA (
     idCliente varchar(40) not null,
     testo varchar(50) not null,
     oraRicerca datetime not null,
     constraint IDCRONOLOGIA_RICERCA primary key (idCliente, testo));

create table DETTAGLIO_ORDINE (
     idProdotto int not null,
     idOrdine int not null,
     quantita int not null,
     constraint IDDETTAGLIO_ORDINE primary key (idOrdine, idProdotto));

create table IMMAGINE (
     nome varchar(30) not null,
     idProdotto int not null,
     numeroProgressivo char(1) not null,
     link varchar(500) not null,
     constraint IDIMMAGINE primary key (idProdotto, numeroProgressivo));

create table LISTA_PREFERITI (
     idCliente varchar(40) not null,
     idProdotto int not null,
     constraint IDLISTA_PREFERITI primary key (idCliente, idProdotto));

create table NOTIFICA (
     idNotifica int not null AUTO_INCREMENT,
     tipo varchar(20) not null,
     testo varchar(500) not null,
     letta char not null,
     idUtente varchar(40) not null,
     constraint IDNOTIFICA primary key (idNotifica));

create table ORDINE (
     idOrdine int not null AUTO_INCREMENT,
     dataOrdine date not null,
     statoOrdine int not null,
     dataArrivoPrevista date not null,
     tipoPagamento int not null,
     idCliente varchar(40) not null,
     idVenditore varchar(40) not null,
     costoTotale int not null,
     constraint IDORDINE_ID primary key (idOrdine));

create table PIATTAFORMA (
     idPiattaforma int not null AUTO_INCREMENT,
     nome varchar(30) not null,
     azienda varchar(30) not null,
     constraint IDPIATTAFORMA primary key (idPiattaforma));

create table PRODOTTO (
     idProdotto int not null AUTO_INCREMENT,
     nome varchar(50) not null,
     prezzo number(3,2) not null,
     quantitaDisponibile int not null,
     descrizione varchar(500) not null,
     proprieta varchar(300) not null,
     offerta int not null,
     tipo int not null,
     idVenditore varchar(40) not null,
     constraint IDPRODOTTO_ID primary key (idProdotto));

create table RECENSIONE (
     idRecensione int not null AUTO_INCREMENT,
     descrizione varchar(300),
     voto int not null,
     idProdotto int not null,
     idCliente varchar(40) not null,
     constraint IDRECENSIONE primary key (idRecensione),
     constraint IDRECENSIONE_1 unique (idProdotto, idCliente));

create table UTENTE (
     email varchar(40) not null,
     nome varchar(30) not null,
     cognome varchar(30) not null,
     password varchar(64) not null,
     fotoProfilo varchar(500),
     constraint IDUTENTE primary key (email));

create table VENDITORE (
     email varchar(40) not null,
     constraint FKR_ID primary key (email));


-- Constraints Section
-- ___________________ 

alter table CARRELLO add constraint FKcar_CLI
     foreign key (idCliente)
     references CLIENTE (email);

alter table CARRELLO add constraint FKcar_PRO
     foreign key (idProdotto)
     references PRODOTTO (idProdotto);

alter table CLIENTE add constraint FKR_1_FK
     foreign key (email)
     references UTENTE (email);

alter table COMPATIBILITA add constraint FKcom_PIA
     foreign key (idPiattaforma)
     references PIATTAFORMA (idPiattaforma);

alter table COMPATIBILITA add constraint FKcom_PRO
     foreign key (idProdotto)
     references PRODOTTO (idProdotto);

alter table CRONOLOGIA_PRODOTTI add constraint FKgua_CLI
     foreign key (idCliente)
     references CLIENTE (email);

alter table CRONOLOGIA_PRODOTTI add constraint FKgua_PRO
     foreign key (idProdotto)
     references PRODOTTO (idProdotto);

alter table CRONOLOGIA_RICERCA add constraint FKCLI_cro
     foreign key (idCliente)
     references CLIENTE (email);

alter table DETTAGLIO_ORDINE add constraint FKcon_ORD
     foreign key (idOrdine)
     references ORDINE (idOrdine);

alter table DETTAGLIO_ORDINE add constraint FKcon_PRO
     foreign key (idProdotto)
     references PRODOTTO (idProdotto);

alter table IMMAGINE add constraint FKR
     foreign key (idProdotto)
     references PRODOTTO (idProdotto);

alter table LISTA_PREFERITI add constraint FKpre_PRO
     foreign key (idProdotto)
     references PRODOTTO (idProdotto);

alter table LISTA_PREFERITI add constraint FKpre_CLI
     foreign key (idCliente)
     references CLIENTE (email);

alter table NOTIFICA add constraint FKriceve
     foreign key (idUtente)
     references UTENTE (email);

-- Not implemented
-- alter table ORDINE add constraint IDORDINE_CHK
--     check(exists(select * from DETTAGLIO_ORDINE
--                  where DETTAGLIO_ORDINE.idOrdine = idOrdine)); 

alter table ORDINE add constraint FKeffettua
     foreign key (idCliente)
     references CLIENTE (email);

alter table ORDINE add constraint FKgestisce
     foreign key (idVenditore)
     references VENDITORE (email);

-- Not implemented
-- alter table PRODOTTO add constraint IDPRODOTTO_CHK
--     check(exists(select * from COMPATIBILITA
--                  where COMPATIBILITA.idProdotto = idProdotto)); 

alter table PRODOTTO add constraint FKvende
     foreign key (idVenditore)
     references VENDITORE (email);

alter table RECENSIONE add constraint FKsu
     foreign key (idProdotto)
     references PRODOTTO (idProdotto);

alter table RECENSIONE add constraint FKlascia
     foreign key (idCliente)
     references CLIENTE (email);

alter table VENDITORE add constraint FKR_FK
     foreign key (email)
     references UTENTE (email);

-- Index Section
-- _____________ 

-- Procedure Section
-- _____________

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `createOrder`(IN `vCliente` VARCHAR(40) CHARSET utf8, IN `vVenditore` VARCHAR(40) CHARSET utf8)
    MODIFIES SQL DATA
BEGIN
DECLARE somma int;
DECLARE vOrd int;

SELECT SUM((prezzo - prezzo*(offerta/100)) * C.quantita) into somma
FROM prodotto P, carrello C
where P.idProdotto = C.idProdotto and C.idCliente = vCliente;

INSERT INTO ORDINE (dataOrdine,
statoOrdine,
dataArrivoPrevista,
tipoPagamento,
idCliente,
idVenditore,
costoTotale) 
VALUES (CURDATE(), 1, DATE_ADD(CURDATE(), INTERVAL 1 DAY), 1, vCliente, vVenditore, somma);

SET vOrd = LAST_INSERT_ID();

INSERT INTO DETTAGLIO_ORDINE SELECT idProdotto, vOrd, quantita FROM CARRELLO WHERE idCliente = vCliente;

DELETE FROM CARRELLO WHERE idCliente = vCliente;
end$$
DELIMITER ;

