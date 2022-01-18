<?php

namespace App\Controllers;

use App\Models\Student;
use App\Models\Teacher;

class StudentController extends CoreController
{

    // ==================================================================
    // Méthode s'occupant de la page student/list
    // ==================================================================
    public function list()
    {
        $studentsList = Student::findAll();
        $this->show('student/student_list', ['studentsList' => $studentsList]);
    }


    // ==================================================================
    // Méthode s'occupant de la page student/add
    // ==================================================================

    public function add()
    {
        $teachers = Teacher::findAll();
        $this->show('student/student_add', ['teachers' => $teachers]);
    }



    public function  addSave()
    {

        // On récupère les données
        $firstname = filter_input(INPUT_POST, 'firstname');
        $lastname = filter_input(INPUT_POST, 'lastname');
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);
        $teacher = filter_input(INPUT_POST, 'teacher', FILTER_VALIDATE_INT);

        // on vérifie la validité des données reçues (gestion d'erreur)

        $errorTableau = []; // tableau vide, pour le moment
        if (!$firstname) {
            $errorTableau[] = "Prenom absent ou incorrect";
        }
        if (!$lastname) {
            $errorTableau[] = "Nom absent ou incorrect";
        }
        if (!$teacher) {
            $errorTableau[] = "Nom professeur absent ou incorrect";
        }
        if (!$status) {
            $errorTableau[] = "Statut absente ou incorrecte";
        }


        if (empty($errorTableau)) {


            $student = new Student();

            // on met à jour les propriété de l'objet fraîchement instancié
            $student->setFirstname($firstname);
            $student->setLastname($lastname);
            $student->setStatus($status);
            $student->setTeacherId($teacher);

            // $student->setJob($job);

            // on tente l'insertion dans la BDD
            $student->save();;


            header('Location: /students');
            exit;
            // un exit pour s'assurer que la suite du code ne soit pas exécutée une fois la redirection effectuée

        } else {

            $_SESSION['token'] = bin2hex(random_bytes(32));

            $teachers = Teacher::findAll();
            $this->show(
                '/student/student_add',
                ['errorTableau' => $errorTableau, 'teachers' => $teachers]
            );
        }
    }

    // ==================================================================
    // Méthode s'occupant de la page student/update
    // ==================================================================

    public function update($paramId)
    {

        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $teachers = Teacher::findAll();
        $student = Student::find($paramId);

        $this->show('student/student_update', ['student' => $student, 'teachers' => $teachers]);
    }


    public function updateSave($id)

    {
        // On récupère les données
        $firstname = filter_input(INPUT_POST, 'firstname');
        $lastname = filter_input(INPUT_POST, 'lastname');
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);
        $teacher = filter_input(INPUT_POST, 'teacher', FILTER_VALIDATE_INT);

        // on vérifie la validité des données reçues (gestion d'erreur)

        $errorTableau = []; // tableau vide, pour le moment
        if (!$firstname) {
            $errorTableau[] = "Prenom absent ou incorrect";
        }
        if (!$lastname) {
            $errorTableau[] = "Nom absent ou incorrect";
        }
        if (!$teacher) {
            $errorTableau[] = "Nom professeur absent ou incorrect";
        }
        if (!$status) {
            $errorTableau[] = "Statut absente ou incorrecte";
        }
        // toutes les données requises sont présentes ?

        if (empty($errorTableau)) {

            // toutes les données attendues sont présentes

            // on rapatrie le Model correspondant
            $student = Student::find($id);

            // On met à jour les propriétés de l'objet fraîchement instancié
            $student->setFirstname($firstname);
            $student->setLastname($lastname);
            $student->setStatus($status);
            $student->setTeacherId($teacher);

            // on tente la sauvegarde dans la BDD
            $updated = $student->save(); // méthode qui retourne TRUE ou FALSE

            if ($updated) {
           
                header('Location: /students');
                exit;
                // un exit pour s'assurer que la suite du code ne soit pas exécutée une fois la redirection effectuée
            } else {

                // la BDD n'a pas été affectée
        
                echo "erreur lors de la mise à jour de ce type dans la BDD 😩";
            }
        } else {

            $teachers = Teacher::findAll();
            $student = Student::find($id);
            $this->show('student/student_update', ['errorTableau' => $errorTableau, 'teachers' => $teachers, 'student' => $student]);
        }
    }

    // ==================================================================
    // Méthode s'occupant d'effacer un etudiant de la BDD
    // ==================================================================

    public function delete($id)
    {
        $student = Student::find($id);
        $student->delete();
        header('Location: /students');
    }
}
