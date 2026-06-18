<?php
require_once __DIR__ . '/app/Middleware/auth.php';
require_once __DIR__ . '/app/Controllers/UsuariosController.php';
require_once __DIR__ . '/app/Controllers/AuthController.php';

$controller = $_GET['controller'] ?? 'auth';
$action = $_GET['action'] ?? 'login';

if ($controller === 'auth') {
    $authController = new AuthController();

    switch ($action) {
        case 'login':
            $authController->exibirLogin();
            break;
        case 'entrar':
            $authController->entrar();
            break;
        case 'dashboard':
            $authController->dashboard();
            break;
        case 'logout':
            $authController->logout();
            break;
        default:
            echo 'Ação de autenticação não encontrada.';
            break;
    }
} elseif ($controller === 'usuarios') {
    // Proteção da rota de usuários (Aula 03)
    exigirAutenticacao();

    $usuariosController = new UsuariosController();

    switch ($action) {
        case 'listar':
            $usuariosController->listar();
            break;
        case 'buscar':
            $usuariosController->buscarPorId();
            break;
        case 'criar':
            $usuariosController->criar();
            break;
        case 'atualizar':
            $usuariosController->atualizar();
            break;
        case 'excluir':
            $usuariosController->excluir();
            break;
        default:
            echo 'Ação de usuários não encontrada.';
            break;
    }
} else {
    header('Location: /atendelab/public/?controller=auth&action=login');
    exit;
}