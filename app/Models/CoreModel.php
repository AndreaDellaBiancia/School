<?php

namespace App\Models;

// Classe mère de tous les Models
// On centralise ici toutes les propriétés et méthodes utiles pour TOUS les Models
abstract class CoreModel
{
    
    protected $teacher_job;
    protected $teacher_name;
    protected $firstname;
    protected $lastname;
    protected $status;
    protected $id;
    protected $updated_at;
    protected $created_at;

    abstract public static function find($id);
    abstract public static function findAll();
    abstract public function insert();
    abstract public function update();
    abstract public function delete();
    
    public function save()
    {

       // si l'instance courante du modèle ($this) a bien une propriété "id"
        if ($this->getId() > 0) {

           // alors le modèle existe déjà
            // et on le met à jour
            return $this->update();
        } else {

           // sinon c'est qu'il n'existe pas
            // et on le créé
            return $this->insert();
        }
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    

    /**
     * Get the value of updated_at
     */ 
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }


    /**
     * Get the value of created_at
     */ 
    public function getCreatedAt()
    {
        return $this->created_at;
    }



    /**
     * Get the value of firstname
     */ 
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @return  self
     */ 
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of lastname
     */ 
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @return  self
     */ 
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }


    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of teacher_job
     */ 
    public function getTeacherJob()
    {
        return $this->teacher_job;
    }

    /**
     * Set the value of teacher_job
     *
     * @return  self
     */ 
    public function setTeacherJob($teacher_job)
    {
        $this->teacher_job = $teacher_job;

        return $this;
    }

    /**
     * Get the value of teacher_name
     */ 
    public function getTeacherName()
    {
        return $this->teacher_name;
    }

    /**
     * Set the value of teacher_name
     *
     * @return  self
     */ 
    public function setTeacherName($teacher_name)
    {
        $this->teacher_name = $teacher_name;

        return $this;
    }


}