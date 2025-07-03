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
            if (!isset($_SESSION["user"]['fotoProfilo']) || !file_exists($_SESSION["user"]['fotoProfilo'])) {
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

    public function logout() {
        $_SESSION["is_logged"] = false;
        $_SESSION["user"] = null;
    }

    public function getNotifications() { //manca la data e l'ora
        if ($this->isLogged()) {
            $query = "SELECT idNotifica, tipo, testo, letta FROM NOTIFICA WHERE idUtente = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s', $_SESSION["user"]['email']);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function readNotification($idNotification) {
        if ($this->isLogged()) {
            $query = "UPDATE NOTIFICA SET letta = true WHERE idNotifica = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $idNotification);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function unreadNotification($idNotification) {
        if ($this->isLogged()) {
            $query = "UPDATE NOTIFICA SET letta = false WHERE idNotifica = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $idNotification);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
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
        $query = "SELECT P.idProdotto, nome, prezzo, quantitaDisponibile, P.descrizione, proprieta, offerta, tipo, idVenditore, "
                ."ROUND(COALESCE(AVG(voto), 0), 1) as media_recensioni, count(voto) as num_recensioni "
                ."FROM PRODOTTO P LEFT JOIN RECENSIONE R ON P.idProdotto = R.idProdotto WHERE P.idProdotto = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getProductImages($id) {
        $query = "SELECT numeroProgressivo, link FROM IMMAGINE WHERE idProdotto = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addToFavourites($idProdotto) {
        if ($this->isLogged() && $this->getUserType()=="client") {
            $query = "INSERT INTO LISTA_PREFERITI (idCliente, idProdotto) VALUE (?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('si', $_SESSION["user"]['email'], $idProdotto);
            $stmt->execute();
        }
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

    public function removeFromCart($idProdotto) {
        if ($this->isLogged() && $this->getUserType()=="client") {
            $query = "DELETE FROM CARRELLO WHERE idProdotto = ? AND idCliente = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('is', $idProdotto, $_SESSION["user"]['email']);
            $stmt->execute();
        }
    }
     
    public function removeOneFromCart($idProdotto) {
        if ($this->isLogged() && $this->getUserType()=="client") {
            $query = "SELECT quantita FROM CARRELLO WHERE idProdotto = ? AND idCliente = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('is', $idProdotto, $_SESSION["user"]['email']);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->fetch_all(MYSQLI_ASSOC)[0]['quantita'] > 2) {
                $query = "UPDATE CARRELLO SET quantita = quantita - 1 WHERE idProdotto = ? AND idCliente = ?";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param('is', $idProdotto, $_SESSION["user"]['email']);
                $stmt->execute();
            } else {
                $this->removeFromCart($idProdotto);
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

    public function moveToFavourites($idProdotto) {
        if ($this->isLogged() && $this->getUserType()=="client") {
            $this->removeFromCart($idProdotto);
            $this->addToFavourites($idProdotto);
        }
    }

    public function getProductsOnSale($n) {
        $query = "SELECT P.idProdotto, P.nome, prezzo, offerta, link FROM PRODOTTO P, IMMAGINE I "
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
        $idPiattaforma = $result->fetch_all(MYSQLI_ASSOC);

        $query = "SELECT P.idProdotto, P.nome, prezzo, offerta, link FROM PRODOTTO P, COMPATIBILITA C, IMMAGINE I "
                ."WHERE P.idProdotto = C.idProdotto AND C.idPiattaforma = ? AND C.idProdotto != ? AND P.idProdotto = I.idProdotto AND I.numeroProgressivo = 1 "
                ."LIMIT ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('iii', $idPiattaforma, $idProdotto, $n);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getYourInterestProducts($n) {
        $query = "SELECT distinct P.idProdotto, P.nome, prezzo, offerta, link "
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
        $query = "SELECT distinct p.idProdotto, P.nome, prezzo, offerta, link "
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
        $query = "SELECT P.idProdotto, P.nome, prezzo, offerta, link "
                ."FROM PRODOTTO P, IMMAGINE I, ORDINE O, DETTAGLIO_ORDINE D "
                ."WHERE P.idProdotto = I.idProdotto "
                ."AND O.idOrdine = D.idOrdine "
                ."AND D.idProdotto = P.idProdotto "
                ."AND numeroProgressivo = 1 "
                ."group by P.idProdotto, nome, prezzo, offerta, link "
                ."order by sum(D.quantita) "
                ."limit ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $n);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getOrders() {
        if ($this->isLogged() && $this->getUserType()=="client") {
            $query = "SELECT idOrdine, dataOrdine, statoOrdine, dataArrivoPrevista, idVenditore, costoTotale FROM ORDINE WHERE idCliente = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s', $_SESSION["user"]['email']);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function getOrderDetails($idOrdine) {
        if ($this->isLogged()) {
            $query = "SELECT P.idProdotto, P.nome, prezzo, offerta, P.descrizione, quantita, I.link, "
                    ."coalesce(avg(voto), 0) as media_recensioni, count(voto) as num_recensioni "
                    ."FROM DETTAGLIO_ORDINE D, IMMAGINE I, PRODOTTO P "
                    ."LEFT JOIN RECENSIONE R ON P.idProdotto = R.idProdotto "
                    ."WHERE P.idProdotto = D.idProdotto AND P.idProdotto = R.idprodotto AND P.idProdotto = I.idProdotto AND I.numeroProgressivo = 1 AND D.idOrdine = ? "
                    ."GROUP BY P.idProdotto, nome, prezzo, offerta, P.descrizione, quantita";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $idOrdine);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function getCart() {
        if ($this->isLogged() && $this->getUserType()=="client") {
            $query = "SELECT P.idProdotto, P.nome, prezzo, offerta, quantita, idVenditore, I.link, "
                    ."coalesce(avg(voto), 0) as media_recensioni, count(voto) as num_recensioni "
                    ."FROM CARRELLO C, IMMAGINE I, PRODOTTO P "
                    ."LEFT JOIN RECENSIONE R ON P.idProdotto = R.idProdotto "
                    ."WHERE P.idProdotto = C.idProdotto AND P.idProdotto = I.idProdotto AND I.numeroProgressivo = 1 AND C.idCliente = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s', $_SESSION["user"]['email']);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function getFavourites() {
        if ($this->isLogged() && $this->getUserType()=="client") {
            $query = "SELECT P.idProdotto, P.nome, prezzo, offerta, idVenditore, I.link, "
                    ."coalesce(avg(voto), 0) as media_recensioni, count(voto) as num_recensioni "
                    ."FROM LISTA_PREFERITI L, IMMAGINE I, PRODOTTO P "
                    ."LEFT JOIN RECENSIONE R ON P.idProdotto = R.idProdotto "
                    ."WHERE P.idProdotto = L.idProdotto AND P.idProdotto = I.idProdotto AND I.numeroProgressivo = 1 AND L.idCliente = ?";
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
            $query = "SELECT nome, prezzo, offerta, link FROM PRODOTTO P, IMMAGINE I WHERE P.idProdotto = I.idProdotto AND idVenditore = ? AND numeroProgressivo = 1";
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
        }
    }

    public function getProductForUpdate($id) {
        if ($this->isLogged() && $this->getUserType() == "vendor") {
            $query = "SELECT nome, prezzo, quantitaDisponibile, descrizione, proprieta, offerta, tipo FROM PRODOTTO WHERE idProdotto = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function updateProduct($id, $nome, $prezzo, $quantita, $descrizione, $proprieta, $offerta, $tipo) {
        if ($this->isLogged() && $this->getUserType() == "vendor") {
            $query = "UPDATE PRODOTTO SET nome = ?, prezzo = ?, quantitaDisponibile = ?, descrizione = ?, proprieta = ?, tipo = ? WHERE idProdotto = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('sdissiii', $nome, $prezzo, $quantita, $descrizione, $proprieta, $offerta, $tipo, $id);
            $stmt->execute();
        }
    }

    public function insertProduct($nome, $prezzo, $quantita, $descrizione, $proprieta, $offerta, $tipo) {
        if ($this->isLogged() && $this->getUserType() == "vendor") {
            $query = "INSERT INTO PRODOTTO VALUE (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('sdissiis', $nome, $prezzo, $quantita, $descrizione, $proprieta, $offerta, $tipo, $_SESSION["user"]['email']);
            $stmt->execute();
        }
    }
    
    public function createOrder($idVenditore) {
        if ($this->isLogged() && $this->getUserType() == "client") {
            $query = "CALL createOrder(?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ss', $_SESSION["user"]['email'], $idVenditore);
            $stmt->execute();
        }
    }

    public function updateHistory($product) {
        if ($this->isLogged() && $this->getUserType() == "client") {
            $query = "INSERT INTO cronologia_prodotti VALUES (?, NOW(), ?) ON DUPLICATE KEY UPDATE oraRicerca = NOW()";
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

    private function isEmailAvailable() {
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
}
?>