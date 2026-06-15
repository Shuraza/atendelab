<?php

class UsuariosController
{
    private PDO $pdo;

    public function __construct()
    {
        require __DIR__ . '/../../config/database.php';
        $this->pdo = $pdo;
    }

    public function listar(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $sql = 'SELECT id, nome, email, perfil, status, criado_em
        FROM usuarios
        ORDER BY id DESC';

        $stmt = $this->pdo->query($sql);
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($usuarios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function buscarPorId(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        
        if (!$id) {
            http_response_code(400);
            echo json_encode(['erro' => 'ID inválido.']); return;
            return;
    }
    $sql = 'SELECT id,nome,email,perfil,status,criado_em
    FROM usuarios
    WHERE id = id';

    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM-INT);
    $stmt->execute();

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$usuario){
        htpp_response_code(404);
        echo json_encode(['erro' => 'Usuário não encontrado.']);
        return;
    }
    echo json_encode($usuario,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}

public function criar(): void
{
    header('Content-Type: application/json; charset=utf-8');

    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $perfil = $_POST['perfil'] ?? 'atendente';
    $status = $_POST['status'] ?? 'ativo';

    if ($nome === '' || $email === '' || $senha === '') {
        http_response_code(400);
        echo json_encode(['erro' => 'Nome, email e senha são obrigatórios.']);
        return;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(['erro' => 'Email inválido.']);
        return;
    }
    if (!in_array($perfil, ['admin', 'atendente'])) {
        http_response_code(400);
        echo json_encode(['erro' => 'Perfil deve ser "admin" ou "atendente".']);
        return;
    }
    if (!in_array($status, ['ativo', 'inativo'])) {
        http_response_code(400);
        echo json_encode(['erro' => 'Status deve ser "ativo" ou "inativo".']);
        return;
    }
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
}