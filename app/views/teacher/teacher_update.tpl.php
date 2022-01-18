        <h2>Mettre à jour un prof</h2>
        <a href="<?= $router->generate('teacher-list')  ?>" class="btn btn-success float-right">Retour</a>

        <form action="" method="POST" class="mt-5">
            <div class="form-group">
                <label for="firstname">Prénom</label>
                <input type="text" class="form-control" name="firstname" id="firstname" placeholder="" value="<?= $teacher->getFirstname() ?>">
            </div>
            <div class="form-group">
                <label for="lastname">Nom</label>
                <input type="text" class="form-control" name="lastname" id="lastname" placeholder="" value="<?= $teacher->getLastname() ?>">
            </div>
            <div class="form-group">
                <label for="job">Titre</label>
                <input type="text" class="form-control" name="job" id="job" placeholder="" value="<?= $teacher->getJob() ?>">
            </div>
            <div class="form-group">
                <label for="status">Statut</label>
                <select name="status" id="status" class="form-control">
                    <option value="0">-</option>
                    <option value="1" <?= $teacher->getStatus() == '1' ? 'selected' : '' ?>>actif</option>
                    <option value="2" <?= $teacher->getStatus() == '2' ? 'selected' : '' ?>>désactivé</option>

                </select>
            </div>

            <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
        </form>