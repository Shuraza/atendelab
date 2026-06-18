<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>AtendeLab - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card p-5 shadow">
            <h2>Bem-vindo, <?= htmlspecialchars($usuarioLogado['nome']); ?>!</h2>
            <p class="text-muted">Perfil técnico ativo: <strong class="badge bg-secondary"><?= htmlspecialchars($usuarioLogado['perfil']); ?></strong></p>
            <hr>
            <div class="d-flex gap-3 mt-4">
                <a href="/atendelab/public/?controller=usuarios&action=listar" class="btn btn-info text-white" target="_blank">Testar rota protegida de usuários</a>
                <a href="/atendelab/public/?controller=auth&action=logout" class="btn btn-danger">Sair (Logout)</a>
            </div>
        </div>
    </div>
</body>

</html>