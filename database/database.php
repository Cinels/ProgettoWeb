<?php
class DatabaseHelper {
    private $db;
    
    public function __construct($servername, $username, $password, $dbname, $port){
        $this->db = new mysqli($servername, $username, $password, $dbname, $port);
        if ($this->db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }
        if(!isset($_SESSION["is_logged"])) {
            $_SESSION["is_logged"] = false;
            $_SESSION["user_type"] = null;
            $_SESSION["user"] = null;
        }
    }

    /**
     * Query mancanti:
     * Creazione di un ordine
     * Creazione di una notifica
     * Inserimento cronologia ricerca
     * aggiungere dove si calcola la media delle recensioni anche un get num recensioni
     */

    public function isLogged() {
        return $_SESSION["is_logged"] ?? false;
    }
    
    public function getUserType() {
        return $_SESSION["user_type"] ?? null;
    }

    public function getProfileImage() {
        return $_SESSION["user"]['fotoProfilo'] ?? null;
    }

    public function getUser() {
        return $_SESSION["user"] ?? null;
    }

    public function checkLogin($email, $password){
        $encryptedPassword = hash('sha256', $password);
        $query = "SELECT email, nome, cognome, fotoProfilo FROM UTENTE WHERE email = ? AND password = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ss', $email, $encryptedPassword);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        if (count($data) == 1) {
            $_SESSION["is_logged"] = true;
            $_SESSION["user"] = $data[0];
            if (!isset($_SESSION["user"]['fotoProfilo']) || !file_exists("../resources/database_img/".$_SESSION["user"]['fotoProfilo'])) {
                $_SESSION["user"]['fotoProfilo'] = null;
            }
            if($this->isClientProfile($email)) {
                $_SESSION["user_type"] = "client";
            } else {
                $_SESSION["user_type"] = "vendor";
            }
            return true;
        }

        return false;
    }

    public function signIn($name, $surname, $email, $password, $image) {
        if ($this->isEmailAvailable($email)) {
            $encryptedPassword = hash('sha256', $password);
            $query = "INSERT INTO UTENTE (email, nome, cognome, password, fotoProfilo) VALUE (?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('sssss', $email, $name, $surname, $encryptedPassword, $image);
            $stmt->execute();

            $query = "INSERT INTO CLIENTE (email) VALUE (?);";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s', $email);
            $stmt->execute();
            return $this->checkLogin($email, $password);
        }
        return false;
    }

    public function editProfile($name, $surname, $old_password, $new_password, $image) {
        $email = $_SESSION['user']['email'];
        $pro_pic = $image ?? $_SESSION['user']['fotoProfilo'];
        $encryptedPassword = hash('sha256', $new_password ?? $old_password);
        $query = "UPDATE UTENTE SET nome = ?, cognome = ?, password = ?, fotoProfilo = ? WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sssss', $name, $surname, $encryptedPassword, $pro_pic, $email);
        $stmt->execute();
        return $this->checkLogin($email, $new_password ?? $old_password);
    }

    public function logout() {
        $_SESSION["is_logged"] = false;
        $_SESSION["user"] = null;
    }

    public function getNotifications() {
        if ($this->isLogged()) {
            $query = "SELECT idNotifica, tipo, testo, letta, data FROM NOTIFICA WHERE idUtente = ? ORDER BY idNotifica DESC";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s', $_SESSION["user"]['email']);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function readNotification($idNotification) {
        error_log('ehi');
        if ($this->isLogged()) {
            $query = "UPDATE NOTIFICA SET letta = ? WHERE idNotifica = ?";
            $true = 1;
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ii', $true, $idNotification);
            $stmt->execute();
        }
    }

    public function unreadNotification($idNotification) {
        if ($this->isLogged()) {
            $query = "UPDATE NOTIFICA SET letta = ? WHERE idNotifica = ?";
            $false = 0;
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ii', $false, $idNotification);
            $stmt->execute();
        }
    }

    public function deleteNotification($idNotification) {
        if ($this->isLogged()) {
            $query = "DELETE FROM NOTIFICA WHERE idNotifica = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $idNotification);
            $stmt->execute();
        }
    }

    public function modifyPassword($oldPassword, $newPassword) {
        if ($this->isLogged()) {
            $encryptedPassword = hash('sha256', $oldPassword);
            $query = "SELECT email, password FROM UTENTE WHERE email = ? AND password = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ss', $_SESSION["user"]['email'], $encryptedPassword);
            $stmt->execute();
            $result = $stmt->get_result();
            if(count($result->fetch_all(MYSQLI_ASSOC)) == 1) {
                $encryptedPassword = hash('sha256', $newPassword);
                $query = "UPDATE UTENTE SET password = ? WHERE email = ?";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param('ss', $encryptedPassword, $_SESSION["user"]['email']);
                $stmt->execute();
                $result = $stmt->get_result();
            }
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function getProduct($id) {
        $query = "SELECT P.idProdotto, nome, prezzo, ROUND(prezzo - prezzo*(offerta/100), 2) AS prezzoScontato, quantitaDisponibile, P.descrizione, proprieta, offerta, tipo, idVenditore, "
                ."ROUND(COALESCE(AVG(voto), 0), 1) as media_recensioni, count(voto) as num_recensioni "
                ."FROM PRODOTTO P LEFT JOIN RECENSIONE R ON P.idProdotto = R.idProdotto WHERE P.idProdotto = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getProductImages($id) {
        $query = "SELECT numeroProgressivo, link FROM IMMAGINE WHERE idProdotto = ? ORDER BY numeroProgressivo";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addToFavourites($idProdotto, $idCliente) {
            $query = "INSERT INTO LISTA_PREFERITI (idCliente, idProdotto) VALUE (?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('si', $idCliente, $idProdotto);
            $stmt->execute();
    }

    public function removeFromFavourites($idProdotto) {
        if ($this->isLogged() && $this->getUserType()=="client") {
            $query = "DELETE FROM LISTA_PREFERITI WHERE idCliente = ? AND idProdotto = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('si', $_SESSION["user"]['email'], $idProdotto);
            $stmt->execute();
        }
    }

    public function addToCart($idProdotto, $n) {
        if ($this->isLogged() && $this->getUserType()=="client") {
            $query = "SELECT quantita FROM CARRELLO WHERE idProdotto = ? AND idCliente = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('is', $idProdotto, $_SESSION["user"]['email']);
            $stmt->execute();
            $result = $stmt->get_result();
            if (count($result->fetch_all(MYSQLI_ASSOC)) == 0) {
                $query = "INSERT INTO CARRELLO (idProdotto, idCliente, quantita) VALUE (?, ?, ?)";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param('isi', $idProdotto, $_SESSION["user"]['email'], $n);
                $stmt->execute();
            } else {
                $query = "UPDATE CARRELLO SET quantita = quantita + ? WHERE idProdotto = ? AND idCliente = ?";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param('iis', $n, $idProdotto, $_SESSION["user"]['email']);
                $stmt->execute();
            }
        }
    }

    public function removeFromCart($idProdotto, $idCliente) {
            $query = "DELETE FROM CARRELLO WHERE idProdotto = ? AND idCliente = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('is', $idProdotto, $idCliente);
            $stmt->execute();
    }
     
    public function removeOneFromCart($idProdotto) {
        if ($this->isLogged() && $this->getUserType()=="client") {
            $query = "SELECT quantita FROM CARRELLO WHERE idProdotto = ? AND idCliente = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('is', $idProdotto, $_SESSION["user"]['email']);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->fetch_all(MYSQLI_ASSOC)[0]['quantita'] > 1) {
                $query = "UPDATE CARRELLO SET quantita = quantita - 1 WHERE idProdotto = ? AND idCliente = ?";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param('is', $idProdotto, $_SESSION["user"]['email']);
                $stmt->execute();
            } else {
                $this->removeFromCart($idProdotto, $_SESSION["user"]['email']);
            }
        }
    }

    public function getCartQuantity($idProdotto) {
        if ($this->isLogged() && $this->getUserType()=="client") {
            $query = "SELECT quantita FROM CARRELLO WHERE idProdotto = ? AND idCliente = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('is', $idProdotto, $_SESSION["user"]['email']);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function moveToCart($idProdotto) {
        if ($this->isLogged() && $this->getUserType()=="client") {
            $this->removeFromFavourites($idProdotto);
            $this->addToCart($idProdotto, 1);
        }
    }

    public function moveToFavourites($idProdotto, $idCliente) {
            var_dump("p: ". $idProdotto);
            var_dump("c: ". $idCliente);
            $this->removeFromCart($idProdotto, $idCliente);
            $this->addToFavourites($idProdotto, $idCliente);
    }

    public function getProductsOnSale($n) {
        $query = "SELECT P.idProdotto, P.nome, prezzo, offerta, link, ROUND(prezzo - prezzo*(offerta/100), 2) AS prezzoScontato FROM PRODOTTO P, IMMAGINE I "
        ."WHERE offerta > 0 AND P.idProdotto = I.idProdotto AND I.numeroProgressivo = 1 "
        ."ORDER BY offerta desc LIMIT ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $n);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getRelatedProducts($idProdotto, $n) {
        $query = "SELECT idPiattaforma FROM COMPATIBILITA WHERE idProdotto = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $idProdotto);
        $stmt->execute();
        $result = $stmt->get_result();
        $idPiattaforma = $result->fetch_all(MYSQLI_ASSOC)[0]['idPiattaforma'];

        $query = "SELECT P.idProdotto, P.nome, prezzo, offerta, link, ROUND(prezzo - prezzo*(offerta/100), 2) AS prezzoScontato FROM PRODOTTO P, COMPATIBILITA C, IMMAGINE I "
                ."WHERE P.idProdotto = C.idProdotto AND C.idPiattaforma = ? AND C.idProdotto != ? AND P.idProdotto = I.idProdotto AND I.numeroProgressivo = 1 "
                ."LIMIT ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('iii', $idPiattaforma, $idProdotto, $n);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getYourInterestProducts($n) {
        $query = "SELECT distinct P.idProdotto, P.nome, prezzo, offerta, link, ROUND(prezzo - prezzo*(offerta/100), 2) AS prezzoScontato "
                ."FROM PRODOTTO P, CRONOLOGIA_PRODOTTI C, IMMAGINE I "
                ."WHERE P.idProdotto = C.idProdotto AND C.idCliente = ? AND P.idProdotto = I.idProdotto AND I.numeroProgressivo = 1 "
                ."LIMIT ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('si', $_SESSION["user"]['email'], $n);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getProductsFromResearch($searched) {
        $query = "SELECT distinct p.idProdotto, P.nome, prezzo, offerta, link, ROUND(prezzo - prezzo*(offerta/100), 2) AS prezzoScontato "
            ."FROM PRODOTTO P, IMMAGINE I, PIATTAFORMA PI, COMPATIBILITA C "
            ."WHERE P.idProdotto = I.idProdotto "
            ."AND P.idProdotto = C.idProdotto "
            ."AND PI.idPiattaforma = C.idPiattaforma "
            ."AND numeroProgressivo = 1 "
            ."AND (P.nome LIKE ? OR PI.nome LIKE ? OR PI.azienda LIKE ?)";
        $tosearch = '%'.$searched.'%';
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sss', $tosearch, $tosearch, $tosearch);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTrendProducts($n) {
        $query = "SELECT P.idProdotto, P.nome, prezzo, offerta, link, ROUND(prezzo - prezzo*(offerta/100), 2) AS prezzoScontato "
                ."FROM PRODOTTO P, IMMAGINE I, DETTAGLIO_ORDINE D "
                ."WHERE P.idProdotto = I.idProdotto "
                ."AND D.idProdotto = P.idProdotto "
                ."AND numeroProgressivo = 1 "
                ."group by P.idProdotto, P.nome, prezzo, offerta, link "
                ."order by sum(D.quantita) desc, count(P.idProdotto) desc "
                ."limit ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $n);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getOrders() {
        if ($this->isLogged()) {
            $query = "SELECT idOrdine, dataOrdine, statoOrdine, dataArrivoPrevista, costoTotale, ";
            if($this->getUserType()=="client") {
                $query = $query."idVenditore as idP FROM ORDINE WHERE idCliente = ? ORDER BY idOrdine DESC";
            } elseif ($this->getUserType()=="vendor") {
                $query = $query."idCliente as idP FROM ORDINE WHERE idVenditore = ? ORDER BY idOrdine DESC";
            }
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s', $_SESSION["user"]['email']);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function getOrderDetails($idOrdine) {
        if ($this->isLogged()) {
            $query = "SELECT P.idProdotto, P.nome, prezzo, offerta, P.descrizione, quantita, I.link, ROUND(prezzo - prezzo*(offerta/100), 2) AS prezzoScontato, "
                    ."ROUND(COALESCE(AVG(voto), 0), 1) as media_recensioni, count(voto) as num_recensioni "
                    ."FROM DETTAGLIO_ORDINE D JOIN PRODOTTO P ON P.idProdotto = D.idProdotto "
                    ."JOIN IMMAGINE I ON P.idProdotto = I.idProdotto "
                    ."LEFT JOIN RECENSIONE R ON P.idProdotto = R.idProdotto "
                    ."WHERE I.numeroProgressivo = 1 AND D.idOrdine = ? "
                    ."GROUP BY P.idProdotto, P.nome, prezzo, offerta, P.descrizione, quantita, I.link";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $idOrdine);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function getCart() {
        if ($this->isLogged() && $this->getUserType()=="client") {
            $query = "SELECT P.idProdotto, P.nome, prezzo, offerta, quantita, idVenditore, I.link, ROUND(prezzo - prezzo*(offerta/100), 2) AS prezzoScontato, "
                    ."ROUND(COALESCE(AVG(voto), 0), 1) as media_recensioni, count(voto) as num_recensioni "
                    ."FROM CARRELLO C JOIN PRODOTTO P ON P.idProdotto = C.idProdotto "
                    ."JOIN immagine i ON P.idProdotto = I.idProdotto "
                    ."LEFT JOIN RECENSIONE R ON P.idProdotto = R.idProdotto "
                    ."WHERE I.numeroProgressivo = 1 AND C.idCliente = ? "
                    ."GROUP BY P.idProdotto, P.nome, prezzo, offerta, quantita, idVenditore, I.link";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s', $_SESSION["user"]['email']);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function getAvailableProducts($idProdotto) {
        $query = "SELECT quantitaDisponibile FROM PRODOTTO WHERE idProdotto = ? ";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $idProdotto);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getFavourites() {
        if ($this->isLogged() && $this->getUserType()=="client") {
            $query = "SELECT P.idProdotto, P.nome, prezzo, offerta, ROUND(prezzo - prezzo*(offerta/100), 2) AS prezzoScontato, idVenditore, I.link, "
                    ."ROUND(COALESCE(AVG(voto), 0), 1) as media_recensioni, count(voto) as num_recensioni "
                    ."FROM LISTA_PREFERITI L JOIN PRODOTTO P ON P.idProdotto = L.idProdotto "
                    ."JOIN IMMAGINE I ON P.idProdotto = I.idProdotto "
                    ."LEFT JOIN RECENSIONE R ON P.idProdotto = R.idProdotto "
                    ."WHERE I.numeroProgressivo = 1 AND L.idCliente = ? "
                    ."GROUP BY P.idProdotto, P.nome, prezzo, offerta, idVenditore, I.link";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s', $_SESSION["user"]['email']);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function getReviews($idProdotto, $n = -1) {
        $query = "SELECT nome, cognome, voto, descrizione FROM RECENSIONE R, CLIENTE C, UTENTE U WHERE R.idCliente = C.email AND U.email = C.email AND idProdotto = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $idProdotto);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function isProductFavourite($idProdotto) {
        if ($this->isLogged() && $this->getUserType()=="client") {
            $query = "SELECT idProdotto FROM LISTA_PREFERITI WHERE idProdotto = ? AND idCliente = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('is', $idProdotto, $_SESSION["user"]['email']);
            $stmt->execute();
            $result = $stmt->get_result();
            return count($result->fetch_all(MYSQLI_ASSOC)) > 0;
        }
    }

    public function isProductInCart($idProdotto) {
        if ($this->isLogged() && $this->getUserType()=="client") {
            $query = "SELECT idProdotto FROM CARRELLO WHERE idProdotto = ? AND idCliente = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('is', $idProdotto, $_SESSION["user"]['email']);
            $stmt->execute();
            $result = $stmt->get_result();
            return count($result->fetch_all(MYSQLI_ASSOC)) > 0;
        }
    }

    public function getVendorProducts() {
        if ($this->isLogged() && $this->getUserType() == "vendor") {
            $query = "SELECT P.idProdotto, P.nome, prezzo, offerta, P.descrizione, quantitaDisponibile, I.link, ROUND(prezzo - prezzo*(offerta/100), 2) AS prezzoScontato, "
                    ."ROUND(COALESCE(AVG(voto), 0), 1) as media_recensioni, count(voto) as num_recensioni "
                    ."FROM VENDITORE V JOIN PRODOTTO P ON P.idVenditore = V.email "
                    ."JOIN IMMAGINE I ON P.idProdotto = I.idProdotto "
                    ."LEFT JOIN RECENSIONE R ON P.idProdotto = R.idProdotto "
                    ."WHERE I.numeroProgressivo = 1 AND V.email = ? "
                    ."GROUP BY P.idProdotto, P.nome, prezzo, offerta, P.descrizione, quantitaDisponibile, I.link";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s', $_SESSION["user"]['email']);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function updateOrderState($id, $new_state) {
        if ($this->isLogged() && $this->getUserType() == "vendor") {
            $query = "UPDATE ORDINE SET statoOrdine = ? WHERE idOrdine = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ii', $new_state, $id);
            $stmt->execute();
            $query = "INSERT INTO NOTIFICA (tipo, testo, letta, idUtente, idOrdine) "
                ."VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $type = 'Aggiornamento ordine';
            $zero = 0;
            $client = $this->getClientByOrder($id);
            $message = "Il tuo ordine N°".$id." è stato aggiornato, controlla nella pagina dei tuoi ordini";
            $stmt->bind_param('ssisi', $type, $message, $zero, $client, $id);
            $stmt->execute();
        }
    }

    public function getProductForUpdate($id) {
        if ($this->isLogged() && $this->getUserType() == "vendor") {
            $query = "SELECT nome, prezzo, quantitaDisponibile, descrizione, proprieta, offerta, tipo, idPiattaforma FROM PRODOTTO P, COMPATIBILITA C WHERE C.idProdotto = P.idProdotto AND P.idProdotto = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function updateProduct($id, $nome, $prezzo, $quantita, $descrizione, $proprieta, $offerta, $tipo, $piattaforma) {
        if ($this->isLogged() && $this->getUserType() == "vendor") {
            $query = "UPDATE PRODOTTO SET nome = ?, prezzo = ?, quantitaDisponibile = ?, descrizione = ?, proprieta = ?, offerta = ?, tipo = ? WHERE idProdotto = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('sdissiii', $nome, $prezzo, $quantita, $descrizione, $proprieta, $offerta, $tipo, $id);
            $stmt->execute();
            $query = "UPDATE COMPATIBILITA SET idPiattaforma = ? WHERE idProdotto = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ii', $piattaforma, $id);
            $stmt->execute();
            $this->manageLowQuantity($id, $quantita);
        }
    }

    public function insertProduct($nome, $prezzo, $quantita, $descrizione, $proprieta, $offerta, $tipo, $piattaforma, $immagine1, $immagine2) {
        if ($this->isLogged() && $this->getUserType() == "vendor") {
            $query = "INSERT INTO PRODOTTO (nome, prezzo, quantitaDisponibile, descrizione, proprieta, offerta, tipo, idVenditore) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $uno = 1;
            $due = 2;
            $stmt->bind_param('sdissiis', $nome, $prezzo, $quantita, $descrizione, $proprieta, $offerta, $tipo, $_SESSION["user"]['email']);
            $stmt->execute();
            $id = $stmt->insert_id;
            $query = "INSERT INTO COMPATIBILITA VALUES (?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ii', $id, $piattaforma);
            $stmt->execute();
            $query = "INSERT INTO IMMAGINE VALUES (?, ?, ?, ?), (?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $nomeimg1=$nome.'_1';
            $nomeimg2=$nome.'_2';
            // var_dump($immagine1);
            // var_dump($immagine2);
            $stmt->bind_param('siissiis', $nomeimg1, $id, $uno, $immagine1, $nomeimg2, $id, $due, $immagine2);
            $stmt->execute();
            return $id;
        }
    }
    
    public function createOrder($idVenditore) {
        if ($this->isLogged() && $this->getUserType() == "client") {
            $this->db->query("SET @id = 0;");
            $query = "CALL createOrder(?, ?, @id)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ss', $_SESSION["user"]['email'], $idVenditore);
            if (!$stmt->execute()) {
                die("Errore nella stored procedure: ".$stmt->error);
            }
            $result = $this->db->query("SELECT @id AS id");
            $row = $result->fetch_assoc();
            return $row['id'];
        }
    }

    public function updateHistory($product) {
        if ($this->isLogged() && $this->getUserType() == "client") {
            $query = "INSERT INTO cronologia_prodotti VALUES (?, ?, NOW()) ON DUPLICATE KEY UPDATE oraRicerca = NOW()";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('si', $_SESSION["user"]['email'], $product);
            $stmt->execute();
        }
    }

    public function hasBuyedIt($product) {
        if ($this->isLogged() && $this->getUserType() == "client") {
            $query = "SELECT * FROM ORDINE O, DETTAGLIO_ORDINE D WHERE O.idOrdine = D.idOrdine AND idCliente = ? AND idProdotto = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('si', $_SESSION["user"]['email'], $product);
            $stmt->execute();
            $result = $stmt->get_result();
            return count($result->fetch_all(MYSQLI_ASSOC)) > 0;
        }
    }

    public function writeReview($product, $vote, $desc) {
        if($this->isLogged() && $this->getUserType() == "client") {
            $query = "INSERT INTO RECENSIONE (descrizione, voto, idProdotto, idCliente) VALUES(?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('siis', $desc, $vote, $product, $_SESSION["user"]['email']);
            $stmt->execute();
            $query = "INSERT INTO NOTIFICA (tipo, testo, letta, idUtente, idProdotto) VALUES (?, ?, ?, ?, ?)";
            $type = 'Nuova recensione';
            $zero = 0;
            $vendor = "venditore@negozio.it";
            $message = "Qualcuno ha lasciato una recensione a ".$this->getProductName($product);
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ssisi', $type, $message, $zero, $vendor, $product);
            $stmt->execute();
        }
    }
    public function editReview($product, $vote, $desc) {
        if($this->isLogged() && $this->getUserType() == "client") {
            $query = "UPDATE RECENSIONE SET descrizione = ?, voto = ? WHERE idProdotto = ? AND idCliente = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('siis', $desc, $vote, $product, $_SESSION["user"]['email']);
            $stmt->execute();
        }
    }

    public function hasReviewedIt($product) {
        if($this->isLogged() && $this->getUserType() == "client") {
            $query = "SELECT idRecensione FROM RECENSIONE WHERE idProdotto = ? AND idCliente = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('is', $product, $_SESSION["user"]['email']);
            $stmt->execute();
            $result = $stmt->get_result();
            return count($result->fetch_all(MYSQLI_ASSOC)) > 0;
        }
    }

    public function getUserReview($product) {
        if($this->isLogged() && $this->getUserType() == "client") {
            $query = "SELECT idRecensione, descrizione, voto FROM RECENSIONE WHERE idProdotto = ? AND idCliente = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('is', $product, $_SESSION["user"]['email']);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function getSoldOutProductsNow($order) {
        $query = "SELECT P.idProdotto FROM DETTAGLIO_ORDINE D, PRODOTTO P WHERE P.idProdotto = D.idProdotto AND D.idOrdine = ? AND P.quantitaDisponibile <= ?";
            $stmt = $this->db->prepare($query);
            $zero = 0;
            $stmt->bind_param('ii', $order, $zero);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function notifySoldoutProduct($product, $vendor) {
            $query = "INSERT INTO NOTIFICA (tipo, testo, letta, idUtente, idProdotto) "
                ."VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $type = 'Prodotto esaurito';
            $zero = 0;
            $message = "Il prodotto ".$this->getProductName($product)." è esaurito";
            $stmt->bind_param('ssisi', $type, $message, $zero, $vendor, $product);
            $stmt->execute();
    }

    public function manageLowQuantity($product, $quantity) {
        $query = "SELECT idCliente FROM CARRELLO WHERE idProdotto = ? AND quantita >= ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $product, $quantity);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        foreach($result as $cliente) {
            if ($quantity == 0) {
                $this->moveToFavourites($product, $cliente['idCliente']);
            } else {
                $stmt = $this->db->prepare("UPDATE CARRELLO SET quantita = ? WHERE idProdotto = ? AND idCliente = ?");
                $stmt->bind_param('iis', $quantity, $product, $cliente['idCliente']);
                $stmt->execute();
            }
            $query = "INSERT INTO NOTIFICA (tipo, testo, letta, idUtente, idProdotto) "
                ."VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $type = 'Modifica in carrello';
            $zero = 0;
            $message = $quantity == 0 ? "Il prodotto ".$this->getProductName($product)." è attualmente non disponibile ed è stato aggiunto ai tuoi preferiti" : "La quantità disponibile del prodotto ".$this->getProductName($product)." non soddisfa le richieste del tuo carrello, la quantità nel carrello è stata diminuita";
            $stmt->bind_param('ssisi', $type, $message, $zero, $cliente['idCliente'], $product);
            $stmt->execute();
        }
    }

    public function updateImage($product, $n, $link) {
        $query = "UPDATE IMMAGINE SET link = ? WHERE idProdotto = ? AND numeroProgressivo = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sii', $link, $product, $n);
        $stmt->execute();
    }

    //public function removeProduct($product) {
    //    $query = "UPDATE PRODOTTO SET quantitaDisponibile = ? WHERE idProdotto = ?";
    //    $zero = 0;
    //    $stmt = $this->db->prepare($query);
    //    $stmt->bind_param('ii', $zero, $product);
    //    $stmt->execute();
    //    $this->manageLowQuantity($product, 0);
    //}

    private function getProductName($product) {
        $query = "SELECT nome FROM PRODOTTO WHERE idProdotto = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $product);
        $stmt->execute();
        $result = $stmt->get_result();
        $result = $result->fetch_all(MYSQLI_ASSOC);
        return $result[0]["nome"];
    }

    private function isEmailAvailable($email) {
        $query = "SELECT email FROM UTENTE WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return count($result->fetch_all(MYSQLI_ASSOC)) == 0;
    }

    private function isClientProfile($email) {
        $query = "SELECT C.email FROM UTENTE U, CLIENTE C WHERE U.email = C.email AND U.email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return count($result->fetch_all(MYSQLI_ASSOC)) == 1;
    }

    private function getClientByOrder($order) {
        $query = "SELECT idCliente FROM ORDINE WHERE idOrdine = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $order);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC)[0]['idCliente'];
    }
}
?>