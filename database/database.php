<?php
class DatabaseHelper {
    private $db;
    private $is_logged = false;
    private $user = null;
    private $userType = null;

    public function __construct($servername, $username, $password, $dbname, $port){
        $this->db = new mysqli($servername, $username, $password, $dbname, $port);
        if ($this->db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }        
    }

    /**
     * Query mancanti:
     * Creazione di un ordine
     * Creazione di una notifica
     * Inserimento cronologia ricerca
     * controllo se un prodotto è nei preferiti
     * controllo se un prodotto è nel carrello
     */

    public function isLogged() {
        return $this->is_logged;
    }
    
    public function getUserType() {
        return $this->userType;
    }

    public function getProfileImage() {
        return $this->user['fotoProfilo'];
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
            $is_logged = true;
            $user = $data[0];
            if(isClientProfile($email)) {
                $userType = "client";
            } else {
                $userType = "vendor";
            }
        } else {
            $templateParams["errorelogin"] = "Email o Password errati";
        }
    }

    public function signIn($image, $name, $surname, $email, $password) {
        if (isEmailAvailable($email)) {
            $encryptedPassword = hash('sha256', $password);
            $query = "INSERT INTO UTENTE (email, nome, cognome, password, fotoProfilo) VALUE (?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('sssss', $email, $name, $surname, $encryptedPassword, $image);
            $stmt->execute();

            $query = "INSERT INTO CLIENTE (email) VALUE (?);";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s', $email);
            $stmt->execute();
        }
    }

    public function logout() {
        $is_logged = false;
        $user = null;
    }

    public function getNotifications() {
        if (isLogged()) {
            $query = "SELECT idNotifica, tipo, testo, letta FROM NOTIFICA WHERE idUtente = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s', $user['email']);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MSQLI_ASSOC);
        }
    }

    public function readNotification($idNotification) {
        if (isLogged()) {
            $query = "UPDATE NOTIFICA SET letta = true WHERE idNotifica = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $idNotification);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MSQLI_ASSOC);
        }
    }

    public function unreadNotification($idNotification) {
        if (isLogged()) {
            $query = "UPDATE NOTIFICA SET letta = false WHERE idNotifica = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $idNotification);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MSQLI_ASSOC);
        }
    }

    public function deleteNotification($idNotification) {
        if (isLogged()) {
            $query = "DELETE FROM NOTIFICA WHERE idNotifica = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $idNotification);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MSQLI_ASSOC);
        }
    }

    public function modifyPassword($oldPassword, $newPassword) {
        if (isLogged()) {
            $encryptedPassword = hash('sha256', $oldPassword);
            $query = "SELECT email, password FROM UTENTE WHERE email = ? AND password = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ss', $user['email'], $encryptedPassword);
            $stmt->execute();
            $result = $stmt->get_result();
            if(count($result->fetch_all(MYSQLI_ASSOC)) == 1) {
                $encryptedPassword = hash('sha256', $newPassword);
                $query = "UPDATE UTENTE SET password = ? WHERE email = ?";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param('ss', $encryptedPassword, $user['email']);
                $stmt->execute();
                $result = $stmt->get_result();
            }
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function getProduct($id) {
        $query = "SELECT idProdotto, nome, prezzo, quantitaDisponibile, descrizione, proprieta, offerta, tipo, idVenditore FROM PRODOTTO WHERE idProdotto = ?"; //manca media recensioni
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getProductImages($id) {
        $query = "SELECT idImmagine, link FROM IMMAGINE WHERE idProdotto = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addToFavourites($idProdotto) {
        if (isLogged() && getUserType()=="client") {
            $query = "INSERT INTO LISTA_PREFERITI (idCliente, idProdotto) VALUE (?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('si', $user['email'], $idProdotto);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function removeFromFavourites($idProdotto) {
        if (isLogged() && getUserType()=="client") {
            $query = "DELETE FROM LISTA_PREFERITI WHERE idCliente = ? AND idProdotto = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('si', $user['email'], $idProdotto);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function addToCart($idProdotto, $n) {
        if (isLogged() && getUserType()=="client") {
            $query = "SELECT quantita FROM CARRELLO WHERE idProdotto = ? AND idCliente = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('is', $idProdotto, $user['email']);
            $stmt->execute();
            $result = $stmt->get_result();
            if (count($result->fetch_all(MYSQLI_ASSOC)) == 0) {
                $query = "INSERT INTO CARRELLO (idProdotto, idCliente, quantita) VALUE (?, ?, ?)";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param('isi', $idProdotto, $user['email'], $n);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result->fetch_all(MYSQLI_ASSOC);
            } else {
                $quantity = $result->fetch_all(MYSQLI_ASSOC)['quantita'];
                $query = "UPDATE CARRELLO SET quanita = ? WHERE idProdotto = ? AND idCliente = ?";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param('iis', $n + $quantity, $idProdotto, $user['email']);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result->fetch_all(MYSQLI_ASSOC);
            }
        }
    }

    public function removeFromCart($idProdotto) {
        if (isLogged() && getUserType()=="client") {
            $query = "DELETE FROM CARRELLO WHERE idProdotto = ? AND idCliente = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('is', $idProdotto, $user['email']);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);            
        }
    }
     
    public function removeOneFromCart($idProdotto) {
        if (isLogged() && getUserType()=="client") {
            $query = "SELECT quantita FROM CARRELLO WHERE idProdotto = ? AND idCliente = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('is', $idProdotto, $user['email']);
            $stmt->execute();
            $result = $stmt->get_result();
            $quantity = $result->fetch_all(MYSQLI_ASSOC)['quantita'];
            if ($quantity > 2) {
                $query = "UPDATE CARRELLO SET quantita = ? WHERE idProdotto = ? AND idCliente = ?";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param('iis', $quantity - 1, $idProdotto, $user['email']);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result->fetch_all(MYSQLI_ASSOC);
            } else {
                removeFromCart($idProdotto);
            }
        }
    }

    public function moveToCart($idProdotto) {
        if (isLogged() && getUserType()=="client") {
            removeFromFavourites($idProdotto);
            addToCart($idProdotto, 1);
        }
    }

    public function moveToFavourites($idProdotto) {
        if (isLogged() && getUserType()=="client") {
            removeFromCart($idProdotto);
            addToFavourites($idProdotto);
        }
    }

    public function getProductsOnSale($n) {
        $query = "SELECT P.idProdotto, P.nome, prezzo, offerta, link FROM PRODOTTO P, IMMAGINE I WHERE offerta > 0 AND P.idProdotto = I.idProdotto ORDER BY offerta desc LIMIT ?";
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
        $idPiattaforma = $result->fetch_all(MYSQLI_ASSOC)['idPiattaforma'];

        $query = "SELECT P.idProdotto, nome, prezzo, offerta FROM PRODOTTO P, COMPATIBILITA C WHERE P.idProdotto = C.idProdotto AND C.idPiattaforma = ? AND NOT C.idProdotto = ? LIMIT ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('iii', $idPiattaforma, $idProdotto, $n);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getYourInterestProducts($n) {
        if (isLogged() && getUserType()=="client") {
            $query = "SELECT P.idProdotto, nome, prezzo, offerta, link"
                    ."FROM PRODOTTO P, CRONOLOGIA_PRODOTTI C, IMMAGINE I"
                    ."WHERE P.idProdotto = C.idProdotto AND C.idCliente = ? AND P.idProdotto = I.idProdotto AND I.numeroProgressivo = ?"
                    ."LIMIT ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('sii', $user['email'], 1, $n);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function getProductsFromResearch($searched) {
        $query = "SELECT p.idProdotto, nome, prezzo, offerta, link"
            ."FROM PRODOTTO P, IMMAGINE I"
            ."WHERE P.idProdotto = I.idProdotto"
            ."AND nome LIKE %?% AND numeroProgressivo = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('si', $searched, 1);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTrendProducts() {
        $query = "SELECT P.idProdotto, P.nome, prezzo, offerta, link"
                ."FROM PRODOTTO P, IMMAGINE I, ORDINE O, DETTAGLIO_ORDINE D"
                ."WHERE P.idProdotto = I.idProdotto"
                ."AND O.idOrdine = D.idOrdine"
                ."AND D.idProdotto = P.idProdotto"
                ."AND numeroProgressivo = 1"
                ."group by P.idProdotto, nome, prezzo, offerta, link"
                ."order by sum(D.quantita)"
                ."limit ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', 10);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getOrders() {
        if (isLogged() && getUserType()=="client") {
            $query = "SELECT idOrdine, dataOrdine, statoOrdine, dataArrivoPrevista, idVenditore, costoTotale FROM ORDINI WHERE idCliente = ?"; //manca venditore
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s', $user['email']);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function getOrderDetails($idOrdine) {
        if (isLogged()) {
            $query = "SELECT nome, prezzo, offerta, P.descrizione, quantita, avg(voto) as media_recensioni"
                        ."FROM PRODOTTO P, DETTAGLIO_ORDINE D, RECENSIONE R"
                        ."WHERE P.idProdotto = D.idProdotto"
                        ."AND P.idProdotto = R.idprodotto"
                        ."AND D.idOrdine = ?"
                        ."group by P.idProdotto, nome, prezzo, offerta, P.descrizione, quantita";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $idOrdine);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function getCart() {
        if (isLogged() && getUserType()=="client") {
            $query = "SELECT P.idProdotto, nome, prezzo, offerta, quantita, idVenditore FROM PRODOTTO P, CARRELLO C WHERE P.idProdotto = C.idProdotto AND C.idCliente = ?"; //manca media recensioni e data consegna
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s', $user['email']);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function getFavourites() {
        if (isLogged() && getUserType()=="client") {
            $query = "SELECT P.idProdotto, nome, prezzo, offerta, idVenditore FROM PRODOTTO P, LISTA_PREFERITI L WHERE P.idProdotto = L.idProdotto AND L.idCliente = ?"; //manca media recensioni e data consegna
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s', $user['email']);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function getReviews($idProdotto, $n) {
        $query = "SELECT voto, descrizione FROM RECENSIONI WHERE idProdotto = ? LIMIT ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $idProdotto, $n);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getVendorProducts() {
        if (isLogged() && getUserType() == "vendor") {
            $query = "SELECT nome, prezzo, offerta, link FROM PRODOTTO P, IMMAGINE I WHERE P.idProdotto = I.idProdotto AND idVenditore = ? AND numeroProgressivo = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('si', $user['email'], 1);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function updateOrderState($id, $new_state) {
        if (isLogged() && getUserType() == "vendor") {
            $query = "UPDATE ordini SET statoOrdine = ? WHERE idOrdine = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ii', $new_state, $id);
            $stmt->execute();
        }
    }

    public function getProductForUpdate($id) {
        if (isLogged() && getUserType() == "vendor") {
            $query = "SELECT nome, prezzo, quantitaDisponibile, descrizione, proprieta, offerta, tipo FROM PRODOTTO WHERE idProdotto = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function updateProduct($id, $nome, $prezzo, $quantita, $descrizione, $proprieta, $offerta, $tipo) {
        if (isLogged() && getUserType() == "vendor") {
            $query = "UPDATE PRODOTTO SET nome = ?, prezzo = ?, quantitaDisponibile = ?, descrizione = ?, proprieta = ?, tipo = ? WHERE idProdotto = ?";
            $stmt = $this->db->prepare($query);
            $intOfferta = (int)$offerta;
            $stmt->bind_param('sdissiii', $nome, $prezzo, $quantita, $descrizione, $proprieta, $intOfferta, $tipo, $id);
            $stmt->execute();
        }
    }

    public function insertProduct($nome, $prezzo, $quantita, $descrizione, $proprieta, $offerta, $tipo) {
        if (isLogged() && getUserType() == "vendor") {
            $query = "INSERT INTO PRODOTTO VALUE (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $intOfferta = (int)$offerta;
            $stmt->bind_param('sdissiis', $nome, $prezzo, $quantita, $descrizione, $proprieta, $intOfferta, $tipo, $user['email']);
            $stmt->execute();
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