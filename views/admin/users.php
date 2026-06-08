<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Utilisateurs - Admin MK Fashion</title>
    <link rel="stylesheet" href="/mkFashion/public/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <?php include ROOT_PATH . '/views/admin/sidebar.php'; ?>
        
        <main class="admin-main">
            <h1>👥 Gestion des utilisateurs</h1>
            
            <?php if (isset($_SESSION['admin_success'])): ?>
                <div class="alert success"><?= $_SESSION['admin_success'] ?></div>
                <?php unset($_SESSION['admin_success']); ?>
            <?php endif; ?>
            
            <table class="data-table">
                <thead>
                    <tr><th>ID</th><th>Nom</th><th>Email</th><th>Rôle</th><th>Inscrit le</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td>
                            <form method="POST" action="/mkFashion/public/admin/updateUserRole" style="display: inline;">
                                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                <select name="role" onchange="this.form.submit()">
                                    <option value="client" <?= $user['role'] == 'client' ? 'selected' : '' ?>>Client</option>
                                    <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                </select>
                            </form>
                        </td>
                        <td><?= date('d/m/Y', strtotime($user['created_at'])) ?></td>
                        <td>
                            <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                <a href="/mkFashion/public/admin/deleteUser/<?= $user['id'] ?>" class="btn btn-danger" onclick="return confirm('Supprimer cet utilisateur ?')">🗑️</a>
                            <?php else: ?>
                                <span style="color: gray;">Vous</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>