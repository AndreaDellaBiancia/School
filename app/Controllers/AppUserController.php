<?php

namespace App\Controllers;

use App\Models\AppUser;


// Si j'ai besoin du Model Category
// use App\Models\Category;

class AppUserController extends CoreController
{


    // ============================================================================
    // METHODE QUI AFFICHE LA PAGE AVEC LA LISTE DES USERS
    // ============================================================================
    public function list()
    {
        $allUsers = AppUser::findAll();
        $this->show('appuser/appuser_list', ['allUsers' => $allUsers]);
    }

    // ============================================================================
    // METHODES QUI S'OCCUPE DE LA PAGE USER/ADD
    // ============================================================================

    public function add()
    {

        $users = AppUser::findAll();
        $this->show('appuser/appuser_add');
    }


    public function addSave()
    {


        // on récupère les données
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
        $status = (int) filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);



        // on vérifie la validité
        $errorTableau = [];
        if (!$email)                 $errorTableau[] = "Email absent ou incorrect";
        if (!$name)                   $errorTableau[] =   "Nom absent ou incorrect";
        if (strlen($password) == 0)  $errorTableau[] =  "Password absente ou incorrect";
        if (!$role)                  $errorTableau[] =      "Role absent ou incorrect";
        if (!$status)                $errorTableau[] =   "Status absent ou incorrecte";

        $user = new AppUser();
        // on définit une longueur de mot de passe minimale
        if (strlen($password) < 8)   $errorTableau[] = "Le mot de passe doit contenir au moins 8 caractères";

        // s'il fait plus d'un caractère, on hash le mot de passe
        // https://www.php.net/manual/fr/function.password-hash.php
        if (strlen($password) != 0) $password = password_hash($password, PASSWORD_DEFAULT);

        // toutes les données requises sont présentes ?
        if (empty($errorTableau)) {

            // toutes les données attendues sont présentes

            // On met à jour les propriétés de l'objet fraîchement instancié
            $user->setEmail($email);
            $user->setName($name);
            $user->setPassword($password);
            $user->setRole($role);
            $user->setStatus($status);

            // on tente la sauvegarde dans la BDD
            $user->save(); // méthode qui retourne TRUE ou FALSE


            header('Location: /appusers');
            exit;
        } else {

            $_SESSION['token'] = bin2hex(random_bytes(32));

            $this->show(
                'appuser/appuser_add',
                ['errorTableau' => $errorTableau]
            );
        }
    }


    // ============================================================================
    // METHODES QUI S'OCCUPE DE LA PAGE USER/UPDATE
    // ============================================================================
    public function update($id)
    {


        $user = AppUser::find($id);

        $this->show('appuser/appuser_update', ['user' => $user]);
    }

    public function  updateSave($id)
    {


        // on récupère les données
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
        $status = (int) filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);



        // on vérifie la validité
        $errorTableau = [];
        if (!$email)                 $errorTableau[] = "Email absent ou incorrect";
        if (!$name)                   $errorTableau[] =   "Nom absent ou incorrect";
        if (strlen($password) == 0)  $errorTableau[] =  "Password absente ou incorrect";
        if (!$role)                  $errorTableau[] =      "Role absent ou incorrect";
        if (!$status)                $errorTableau[] =   "Status absent ou incorrecte";

        // toutes les données requises sont présentes ?
        if (empty($errorTableau)) {

            // toutes les données attendues sont présentes

            // on rapatrie le Model correspondant
            $user = AppUser::find($id);

            // On met à jour les propriétés de l'objet fraîchement instancié
            $user->setEmail($email);
            $user->setName($name);
            $user->setPassword($password);
            $user->setRole($role);
            $user->setStatus($status);

            // on tente la sauvegarde dans la BDD
            $updated =  $user->save(); // méthode qui retourne TRUE ou FALSE
            if ($updated) {


                header('Location: /appusers');
                exit;
                // un exit pour s'assurer que la suite du code ne soit pas exécutée une fois la redirection effectuée
            } else {

                // la BDD n'a pas été affectée

                echo "erreur lors de la mise à jour de ce type dans la BDD ";
            }
        } else {

            $user = AppUser::find($id);

            $this->show('appuser/appuser_update', ['user' => $user, 'errorTableau' => $errorTableau]);
        }
    }



    // ============================================================================
    // METHODES QUI S'OCCUPE D'EFFACER UN UTILISATEUR
    // ============================================================================

    public function delete($id)
    {
        $userDelete = AppUser::find($id);
        $userDelete->delete();
        header('Location: /appusers');
    }
}
