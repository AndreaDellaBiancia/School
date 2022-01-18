<?php

namespace App\Models;

use App\Utils\Database;
use PDO;


class Student extends CoreModel
{
    private $teacher_id;

    // =================================================================================================
    //  Méthode permettant de récupérer un enregistrement de la table student
    // =================================================================================================

    public static function find($id)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        $sql = "
        SELECT student.*,
        teacher.firstname as teacher_name,
        teacher.job as teacher_job 
        FROM `student`
        INNER JOIN
        `teacher`
        ON teacher.id = student.teacher_id  
        WHERE student.id = $id ";
        // exécuter notre requête
        $pdoStatement = $pdo->query($sql);

        // un seul résultat => fetchObject
        $student = $pdoStatement->fetchObject('App\Models\Student');

        // retourner le résultat
        return $student;
    }

    //============================================================================
    //Méthode permettant de récupérer tous les enregistrements de la table student
    //============================================================================

    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = '
            SELECT student.*,
            teacher.firstname as teacher_name,
            teacher.job as teacher_job 
            FROM `student`
            INNER JOIN
            `teacher`
            ON teacher.id = student.teacher_id  
            ';
            
        $pdoStatement = $pdo->query($sql);
        $students = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Student');

        return $students;
    }

    
    // =============================================================================
    // Inserer un etudiant dans la BDD
    // =============================================================================

    public function insert()
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();


        $sql = "
            INSERT INTO `student` (firstname, lastname, status, teacher_id)
            VALUES (:firstname, :lastname, :status, :teacher_id)
        ";

        
        $preparation = $pdo->prepare($sql);

        $preparation->execute([
            ":firstname" => $this->firstname,
            ":lastname" => $this->lastname,
            ":status" => $this->status,
            ":teacher_id" => $this->teacher_id,
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
    // Mettre à jour un etudiant dans la BDD
    // =============================================================================
    public function update()
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

       
        $sql = "
        UPDATE`student` 
        SET 
        firstname = :firstname,
        lastname = :lastname,
        status = :status,
        teacher_id = :teacher_id
        WHERE 
        id = :id
        ";

        // Préparation de la requête
        // https://www.php.net/manual/fr/pdo.prepare.php
        $preparation = $pdo->prepare($sql);
        
       
        $preparation->bindValue(':id', $this->id, PDO::PARAM_INT);
        $preparation->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
        $preparation->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        $preparation->bindValue(':status', $this->status, PDO::PARAM_INT);
        $preparation->bindValue(':teacher_id', $this->teacher_id, PDO::PARAM_INT);
       

       
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
    // Effacer un etudiant dans la BDD
    // =============================================================================
    public function delete()
    {

        // se connecter à la BDD
        $pdo = Database::getPDO();

        $sql = "
         DELETE FROM `student` 
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
     * Get the value of teacher_id
     */ 
    public function getTeacherId()
    {
        return $this->teacher_id;
    }

    /**
     * Set the value of teacher_id
     *
     * @return  self
     */ 
    public function setTeacherId($teacher_id)
    {
        $this->teacher_id = $teacher_id;

        return $this;
    }
}
