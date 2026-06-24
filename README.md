# AtendeLab

Sistema de Controle de Atendimentos Acadêmicos desenvolvido na disciplina de Fábrica de Software.

---

## Tecnologias utilizadas

- PHP 8.x
- MySQL
- phpMyAdmin
- HTML
- CSS
- Bootstrap
- Git e GitHub

---

## Funcionalidades previstas

- Página pública
- Login
- Dashboard
- Cadastro de pessoas atendidas
- Cadastro de tipos de atendimento
- Registro de atendimentos
- Relatórios

---

## Como executar localmente

1. Clonar o repositório.
2. Colocar a pasta no `htdocs` do XAMPP.
3. Iniciar Apache e MySQL.
4. Criar o banco `atendelab`.
5. Importar o script `database/atendelab.sql`.
6. Acessar `http://localhost/atendelab/public/`.

---

## Aula 04 — Erros encontrados e correções aplicadas

#### Erro 1 — Coluna duplicada no ALTER TABLE

Ao rodar o script SQL, o MySQL retornou:
```
#1060 - Duplicate column name 'atualizado_em'
```
A coluna já havia sido criada na tabela `usuarios` em uma aula anterior. A linha foi ignorada e a execução continuou normalmente.

---

#### Erro 2 — Rota protegida redirecionando para login

Ao testar a rota `controller=pessoas&action=listar` diretamente no navegador sem estar autenticado, o sistema redirecionou para a tela de login. Comportamento esperado pelo middleware `exigirAutenticacao()`. O teste foi refeito após realizar o login normalmente.
