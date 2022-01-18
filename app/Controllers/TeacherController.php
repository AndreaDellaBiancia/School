<?php

namespace App\Controllers;

use App\Models\Teacher;

class TeacherController extends CoreController
{

    // ==================================================================
    // Méthode s'occupant de la page teachers/list
    // ==================================================================

    public function list()
    {
        $teachersList = Teacher::findAll();
        $this->show('teacher/teacher_list', ['teachersList' => $teachersList]);
    }


    // ==================================================================
    // Méthode s'occupant de la page teacher/add
    // ==================================================================
    public function add()
    {
        $this->show('teacher/teacher_add');
    }


    public function  addSave()
    {
        // On récupère les données
        $firstname = filter_input(INPUT_POST, 'firstname');
        $lastname = filter_input(INPUT_POST, 'lastname');
        $job = filter_input(INPUT_POST, 'job');
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);
        // on vérifie la validité des données reçues (gestion d'erreur)

        $errorTableau = []; // tableau vide, pour le moment
        if (!$firstname) {
            $errorTableau[] = "Prenom absent ou incorrect";
        }
        if (!$lastname) {
            $errorTableau[] = "Nom absent ou incorrect";
        }
        if (!$job) {
            $errorTableau[] = "Titre absent ou incorrect";
        }
        if (!$status) {
            $errorTableau[] = "Statut absente ou incorrecte";
        }


        if (empty($errorTableau)) {
            $teacher = new Teacher();

            // on met à jour les propriété de l'objet instancié
            $teacher->setFirstname($firstname);
            $teacher->setLastname($lastname);
            $teacher->setJob($job);
            $teacher->setStatus($status);

            // on tente l'insertion dans la BDD
            $teacher->save();;


            header('Location: /teachers');
            exit;
            // un exit pour s'assurer que la suite du code ne soit pas exécutée une fois la redirection effectuée
        } else {
            $_SESSION['token'] = bin2hex(random_bytes(32));
            $this->show(
                '/teacher/teacher_add',
                ['errorTableau' => $errorTableau,]
            );
        }
    }



    // ==================================================================
    // Méthode s'occupant de la page teacher/update
    // ==================================================================
    public function update($paramId)
    {

        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller

        $teacher = Teacher::find($paramId);

        $this->show('teacher/teacher_update', ['teacher' => $teacher]);
    }


    public function updateSave($id)
    {

        // on récupère les données
        $firstname = filter_input(INPUT_POST, 'firstname');
        $lastname = filter_input(INPUT_POST, 'lastname');
        $job = filter_input(INPUT_POST, 'job');
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);

        // on vérifie la validité
        $errorTableau = []; // tableau vide, pour le moment
        if (!$firstname) {
            $errorTableau[] = "Prenom absent ou incorrect";
        }
        if (!$lastname) {
            $errorTableau[] = "Nom absent ou incorrect";
        }
        if (!$job) {
            $errorTableau[] = "Titre absent ou incorrect";
        }
        if (!$status) {
            $errorTableau[] = "Statut absente ou incorrecte";
        }

        // toutes les données requises sont présentes ?
        if (empty($errorTableau)) {

            // toutes les données attendues sont présentes

            // on rapatrie le Model correspondant
            $teacher = teacher::find($id);

            // On met à jour les propriétés de l'objet fraîchement instancié
            $teacher->setFirstname($firstname);
            $teacher->setLastname($lastname);
            $teacher->setJob($job);
            $teacher->setStatus($status);

            // on tente la sauvegarde dans la BDD
            $updated = $teacher->save(); // méthode qui retourne TRUE ou FALSE

            if ($updated) {

                header('Location: /teachers');
                exit;
                // un exit pour s'assurer que la suite du code ne soit pas exécutée une fois la redirection effectuée
            } else {

                // la BDD n'a pas été affectée

                echo "erreur lors de la mise à jour de ce type dans la BDD 😩";
            }
        } else {

            $teacher = Teacher::find($id);
            $this->show('teacher/teacher_update', ['errorTableau' => $errorTableau, 'teacher' => $teacher]);
        }
    }

    // ==================================================================
    // Méthode s'occupant d'effacer un professeur de la BDD
    // ==================================================================

    public function delete($id)
    {
        $teacher = Teacher::find($id);
        $teacher->delete();
        header('Location: /teachers');
    }
}
