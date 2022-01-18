<a href="<?= $router->generate('user-list') ?>" class="btn btn-success float-right">Retour</a>
   <h2>Mettre à jour un utilisateur</h2>
    
    <form action="" method="POST" class="mt-5">
        <div class="form-group">
            <label for="email">Adresse email</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="" value="<?= $user->getEmail() ?>">
        </div>
        <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="" value="<?= $user->getName() ?> ">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="<?= $user->getPassword() ?> ">

        </div>
        <div class="form-group">
            <label for="role">Role</label>
            <select name="role" id="role" class="form-control">
                <option value="admin" <?php if ($user->getRole() == 'admin') : ?> selected<?php endif ?>>Admin</option>
                <option value="user" <?php if ($user->getRole() == 'user') : ?> selected<?php endif ?>>Utilisateur</option>
            </select>
        </div>
        <div class="form-group">
            <label for="status">Statut</label>
            <select name="status" id="status" class="form-control">
                <option value="0">-</option>
                <option value="1" <?= $user->getStatus() == '1' ? 'selected' : '' ?>>actif</option>
                <option value="2" <?= $user->getStatus() == '2' ? 'selected' : '' ?>>désactivé</option>
            </select>
        </div>
        <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
        <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
    </form>