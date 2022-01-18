<?php

namespace App\Controllers;

use App\Models\AppUser;



class SecurityController extends CoreController
{


  // ============================================================================
  // METHODES QUI GERENT LA PAGE DE CONNEXION
  // ============================================================================
  public function connection()
  {
    $this->show('login/login');
  }


  public function connectionSend()
  {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    $result = AppUser::findByEmail($email);


    // si cette adresse email correspond à un utilisateur
    // on vérifie que le mot de passe soit valide
    if ($result !== false) {

      // oui, cette adresse email correspond à un utilisateur

      // pour comparer un mot de passe en clair ($password) avec un hash existant (BDD)
      // on passe par la fonction password_verify()
      
      $goodPassword = password_verify($password, $result->getPassword()); // retourne TRUE ou FALSE

    } else {

      // non, cette adresse email ne correspond pas à un utilisateur existant
      $goodPassword = false;
    }

    // est-ce la bonne adresse email ET le bon mot de passe ?
    if ($result !== false and $goodPassword === true) {

      // c'est bon
      // on a la bonne adresse mail ET le bon mot de passe !
      $_SESSION['userId'] = $result->getId();
      $_SESSION['userObject'] = $result;

      // on redirige vers la page d'accueil
      global $router;
      header('Location: ' . $router->generate('main-home'));
      exit; // on oublie pas de stopper l'exécution du code après une redirection

      echo " utilisateur reconnu";
    } else {

      // c'est pas bon
      // mauvaise adresse email ET/OU mauvais mot de passe
      echo "adresse email ou mot de passe incorrect";
      global $router;
      header('Location: ' . $router->generate('login'));
      exit; // on oublie pas de stopper l'exécution du code après une redirection
    }
  }

  /**
   * Déconnecte l'utilisateur en enlevant ses informations dans $_SESSION
   * Puis redirige vers la page de login
   */
  public function logout()
  {
    // on vide le tableau de session
    $_SESSION = [];

    // on ferme la session
    // https://www.php.net/manual/fr/function.session-destroy.php
    session_destroy();

    // Comme l'utilisateur n'est plus identifiable et qu'on est sur un Back Office
    // on le redirige vers le formulaire d'identification
    global $router;
    header('Location: ' . $router->generate('login'));
    exit;
  }


}
