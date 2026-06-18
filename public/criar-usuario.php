<?php


// require_once __DIR__ . '/../config/database.php';

// $nome = 'Samuel de Souza';
// $email = 'samueldesouza200512@gmail.com';
// $senhaPura = '123456'; 

// $senhaHash = password_hash($senhaPura, PASSWORD_DEFAULT);

// try {
//     $pdo->exec("DELETE FROM usuarios WHERE email = '{$email}'");

//     $sql = 'INSERT INTO usuarios (nome, email, senha, perfil, status) 
//             VALUES (:nome, :email, :senha, "admin", "ativo")';

//     $stmt = $pdo->prepare($sql);
//     $stmt->bindValue(':nome', $nome);
//     $stmt->bindValue(':email', $email);
//     $stmt->bindValue(':senha', $senhaHash);
//     $stmt->execute();

//     echo "<h1 style='color: green;'>✅ Usuário criado com sucesso!</h1>";
//     echo "<p><strong>E-mail:</strong> {$email}</p>";
//     echo "<p><strong>Senha:</strong> {$senhaPura}</p>";
//     echo "<br><a href='/atendelab/public/'>Ir para a tela de Login</a>";

// } catch (PDOException $e) {
//     echo "<h1 style='color: red;'>❌ Erro ao criar usuário:</h1> " . $e->getMessage();
// } 