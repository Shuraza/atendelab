<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>AtendeLab - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow" style="width: 24rem;">
            <h3 class="card-title text-center mb-4">AtendeLab</h3>

            <?php if (isset($_SESSION['erro'])): ?>
                <div class="alert alert-danger p-2 fs-6"><?= htmlspecialchars($_SESSION['erro']);
                                                            unset($_SESSION['erro']); ?></div>
            <?php endif; ?>

            <?php if (isset($_SESSION['sucesso'])): ?>
                <div class="alert alert-success p-2 fs-6"><?= htmlspecialchars($_SESSION['sucesso']);
                                                            unset($_SESSION['sucesso']); ?></div>
            <?php endif; ?>

            <form action="/atendelab/public/?controller=auth&action=entrar" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" name="senha" id="senha" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Entrar</button>
            </form>
        </div>
    </div>
</body>

</html>