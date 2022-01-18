<?php

namespace App\Models;

use App\Utils\Database;
use PDO;


class Teacher extends CoreModel
{
    private $job;
   
    // =================================================================================================
    //  Méthode permettant de récupérer un enregistrement de la table teacher
    // =================================================================================================

    public static function find($id)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        $sql = '
            SELECT *
            FROM teacher
            WHERE id = ' . $id;
        // exécuter notre requête
        $pdoStatement = $pdo->query($sql);

        // un seul résultat => fetchObject
        $teacher = $pdoStatement->fetchObject('App\Models\Teacher');

        // retourner le résultat
        return $teacher;
    }

    //============================================================================
    //Méthode permettant de récupérer tous les enregistrements de la table teacher
    //============================================================================

    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `teacher`';
        $pdoStatement = $pdo->query($sql);
        $teachers = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Teacher');

        return $teachers;
    }

    
    // =============================================================================
    // Inserer un prof  dans la BDD
    // =============================================================================

    public function insert()
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();


        $sql = "
            INSERT INTO `teacher` (firstname, lastname, job, status)
            VALUES (:firstname, :lastname, :job, :status)
        ";

        
        $preparation = $pdo->prepare($sql);

        $preparation->execute([
            ":firstname" => $this->firstname,
            ":lastname" => $this->lastname,
            ":job" => $this->job,
            ":status" => $this->status
            ]);

        

        $insertedRows = $preparation->rowCount();
        
        // est-ce qu'une ligne, au moins, a été affectée ?
        if ($insertedRows > 0) {
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
    // Mettre à jour un prof dans la BDD
    // =============================================================================
    public function update()
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // Écriture de la requête préparée (protégée des attaques par injection SQL)
       
        $sql = "
        UPDATE`teacher` 
        SET 
        firstname = :firstname,
        lastname = :lastname,
        job = :job,
        status = :status
        WHERE 
        id = :id
        ";

        // Préparation de la requête
        // https://www.php.net/manual/fr/pdo.prepare.php
        $preparation = $pdo->prepare($sql);
        
       
        $preparation->bindValue(':id', $this->id, PDO::PARAM_INT);
        $preparation->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
        $preparation->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        $preparation->bindValue(':job', $this->job, PDO::PARAM_STR);
        $preparation->bindValue(':status', $this->status, PDO::PARAM_INT);
       

       
        $preparation->execute();

        $insertedRows = $preparation->rowCount();

        // est-ce qu'une ligne, au moins, a été affectée ?
        if ($insertedRows > 0) {
            $this->id = $pdo->lastInsertId();

            // on retourne un signal positif
            return true;
        } else {
            return false;
        }
    }

    // =============================================================================
    // Effacer un prof dans la BDD
    // =============================================================================
    public function delete()
    {

        // se connecter à la BDD
        $pdo = Database::getPDO();

        $sql = "
         DELETE FROM `teacher` 
         WHERE id = :id";

        // Préparation de la requête
        // https://www.php.net/manual/fr/pdo.prepare.php
        $preparation = $pdo->prepare($sql);
        $preparation->bindValue(':id', $this->id, PDO::PARAM_INT);

        $preparation->execute();

        $insertedRows = $preparation->rowCount();

        // est-ce qu'une ligne, au moins, a été affectée ?
        if ($insertedRows > 0) {
            $this->id = $pdo->lastInsertId();

            // on retourne un signal positif
            return true;
        } else {
            return false;
        }
    }



    /**
     * Get the value of job
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Set the value of job
     *
     * @return  self
     */
    public function setJob($job)
    {
        $this->job = $job;

        return $this;
    }
} 