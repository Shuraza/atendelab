<?php

class AuthController
{
    private PDO $pdo;

    public function __construct()
    {
        require __DIR__ . '/../../config/database.php';
        $this->pdo = $pdo;

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function exibirLogin(): void
    {
        if (isset($_SESSION['usuario'])) {
            header('Location: /atendelab/public/?controller=auth&action=dashboard');
            exit;
        }
        require __DIR__ . '/../Views/auth/login.php';
    }

    public function entrar(): void
    {
        $email = trim($_POST['email'] ?? '');
        $senha = $_POST['senha'] ?? '';

        if ($email === '' || $senha === '') {
            $_SESSION['erro'] = 'Preencha todos os campos.';
            header('Location: /atendelab/public/?controller=auth&action=login');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['erro'] = 'E-mail ou senha inválidos.';
            header('Location: /atendelab/public/?controller=auth&action=login');
            exit;
        }

        $sql = 'SELECT id, nome, email, senha, perfil, status FROM usuarios WHERE email = :email';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario || !password_verify($senha, $usuario['senha']) || $usuario['status'] !== 'ativo') {
            $_SESSION['erro'] = 'E-mail ou senha inválidos.';
            header('Location: /atendelab/public/?controller=auth&action=login');
            exit;
        }

        session_regenerate_id(true);

        $_SESSION['usuario'] = [
            'id' => $usuario['id'],
            'nome' => $usuario['nome'],
            'email' => $usuario['email'],
            'perfil' => $usuario['perfil']
        ];

        header('Location: /atendelab/public/?controller=auth&action=dashboard');
        exit;
    }

    public function dashboard(): void
    {
        require_once __DIR__ . '/../Middleware/auth.php';
        exigirAutenticacao();

        $usuarioLogado = usuarioAtual();
        require __DIR__ . '/../Views/dashboard/index.php';
    }

    public function logout(): void
    {
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['sucesso'] = 'Sessão encerrada com sucesso.';
        header('Location: /atendelab/public/?controller=auth&action=login');
        exit;
    }
}
