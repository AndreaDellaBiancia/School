<?php

namespace App\Models;

use App\Utils\Database;
use PDO;


class AppUser extends CoreModel
{

    private $email;
    private $name;
    private $password;
    private $role;





    // =================================================================================================
    //  Méthode permettant de récupérer un enregistrement de la table app_user en fonction d'un id donné
    // =================================================================================================


    static public function find($id)
    {
        // connexion
        $pdo = Database::getPDO();
        // requêtons
        $sql = '
                SELECT *
                FROM app_user
                WHERE id = :id
                ';

        // préparation
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':id', $id, PDO::PARAM_INT);

        // exécution
        $pdoStatement->execute();

        // récupération
        $result = $pdoStatement->fetchObject('App\Models\AppUser');
        // identique à : $result = $pdoStatement->fetchObject(self::class);

        // répatriation (c'est juste pour la rime)
        return $result;
    }

    //============================================================================ 
    //Méthode permettant de récupérer tous les enregistrements de la table app_user
    //============================================================================

    static public function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `app_user`';
        $pdoStatement = $pdo->prepare($sql); // préparée
        $pdoStatement->execute(); // exécutée
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class); // self::class === "App\Models\AppUser" // rapatriée

        return $results;
    }



    //=================================================================================================== 
    //Méthode permettant de récupérer tous les enregistrements de la table app_user avec un mail donné
    //===================================================================================================
    static public function findByEmail($email)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        $sql = "SELECT * FROM `app_user` WHERE `email` = :email ";

        // exécuter notre requête
        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->execute([
            'email' => $email
        ]);

        $resultat = $pdoStatement->fetchObject('App\Models\AppUser');
        // un seul résultat => fetchObject

        // retourner le résultat
        return $resultat;
    }
    // =============================================================================
    // Inserer un nouveau user dans la BDD
    // =============================================================================

    public function insert()
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();


        $sql = "
            INSERT INTO `app_user` (email, name, password, role, status)
            VALUES (:email, :name, :password, :role, :status)
        ";

        // Préparation de la requête
        // https://www.php.net/manual/fr/pdo.prepare.php
        $preparation = $pdo->prepare($sql);

        // On lance la requête
        // en passant, une fois n'est pas coutume, un tableau associatif à execute()
        // ERRATUM : execute retourne bien TRUE en cas de succès ou FALSE si une erreur survient
        // https://www.php.net/manual/fr/pdostatement.execute.php
        $inserted = $preparation->execute([
            ':email' => $this->email,
            ':name' => $this->name,
            ':password' => $this->password,
            ':role' => $this->role,
            ':status' => $this->status
        ]);

        // est-ce que tout s'est bien passé ?
        if ($inserted) {

            // BDD affectée

            // on récupère l'id généré par MySQL/MariaDB
            $this->id = $pdo->lastInsertId();

            // on retourne un signal positif
            return true;
        } else {

            // BDD non affectée

            // on retourne un signal négatif
            return false;
        }
    }

    // =============================================================================
    // Mettre à jour un user dans la BDD
    // =============================================================================
    public function update()
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // Écriture de la requête préparée (protégée des attaques par injection SQL)

        $sql = "
        UPDATE`app_user` 
        SET 
        email = :email,
        name = :name,
        password = :password,
        role = :role,
        status = :status
        WHERE 
        id = :id
        ";

        // Préparation de la requête
        // https://www.php.net/manual/fr/pdo.prepare.php
        $preparation = $pdo->prepare($sql);

        $preparation->bindValue(':id', $this->id, PDO::PARAM_INT);
        $preparation->bindValue(':email', $this->email, PDO::PARAM_STR);
        $preparation->bindValue(':password', $this->password, PDO::PARAM_STR);
        $preparation->bindValue(':name', $this->name, PDO::PARAM_STR);
        $preparation->bindValue(':role', $this->role, PDO::PARAM_STR);
        $preparation->bindValue(':status', $this->status, PDO::PARAM_INT);


        // pour se plonger dans la diff entre bindValue et bindParam
        // https://qastack.fr/programming/1179874/what-is-the-difference-between-bindparam-and-bindvalue
        // https://stackoverflow.com/questions/1179874/what-is-the-difference-between-bindparam-and-bindvalue#:~:text=With%20bindParam%20%2C%20you%20can%20only,values%2C%20obviously%2C%20and%20variables)

        $preparation->execute();

        $insertedRows = $preparation->rowCount();

        // est-ce qu'une ligne, au moins, a été affectée ?
        if ($insertedRows > 0) {

            // BDD affectée

            // on donne à notre Model l'ID auto-incrémentée générée par SQL
            // https://www.php.net/manual/fr/pdo.lastinsertid.php
            $this->id = $pdo->lastInsertId();

            // on retourne un signal positif
            return true;
        } else {

            // BDD non affectée

            // on retourne un signal négatif
            return false;
        }
    }

    // =============================================================================
    // Effacer un user dans la BDD
    // =============================================================================
    public function delete()
    {

        // se connecter à la BDD
        $pdo = Database::getPDO();

        $sql = "
         DELETE FROM `app_user` 
         WHERE id = :id";

        // Préparation de la requête
        // https://www.php.net/manual/fr/pdo.prepare.php
        $preparation = $pdo->prepare($sql);
        $preparation->bindValue(':id', $this->id, PDO::PARAM_INT);

        $preparation->execute();

        $insertedRows = $preparation->rowCount();

        // est-ce qu'une ligne, au moins, a été affectée ?
        if ($insertedRows > 0) {

            // BDD affectée

            // on donne à notre Model l'ID auto-incrémentée générée par SQL
            // https://www.php.net/manual/fr/pdo.lastinsertid.php
            $this->id = $pdo->lastInsertId();

            // on retourne un signal positif
            return true;
        } else {

            // BDD non affectée

            // on retourne un signal négatif
            return false;
        }
    }


    // =========================================================
    //  Getters & Setters
    // =========================================================


    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }


    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}
