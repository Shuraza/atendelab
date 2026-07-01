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

---

## Aula 06 — Frontend integrado ao backend oficial

Etapa de integração visual definitiva: as telas passam a consumir os controllers já existentes (`PessoasController`, `TiposAtendimentosController`, `AtendimentosController`) em vez de dados fictícios.

#### O que foi criado

- `app/Controllers/FrontendController.php` — só entrega as views (`pessoas`, `tipos`, `atendimentos`); quem busca e grava dados continua sendo o controller específico de cada módulo, chamado pelo JavaScript.
- `app/Controllers/DashboardController.php` — endpoint `resumo()` (`?controller=dashboard&action=resumo`), com os totais por categoria e os 5 últimos atendimentos.
- `app/Views/layouts/{config-view,header,footer}.php` — layout único com navbar, usado por todas as telas internas (login continua sem navbar, por não haver sessão ainda).
- `app/Views/pessoas/index.php`, `app/Views/tipos-atendimentos/index.php`, `app/Views/atendimentos/index.php` — CRUD visual completo de cada módulo.
- `public/assets/js/api.js` e `public/assets/css/style.css` — a ponte entre view e backend (monta a URL, envia `x-www-form-urlencoded`, interpreta o JSON de retorno).

#### O que foi corrigido

- `routes.php` — adicionados os cases `dashboard` e `frontend` ao switch existente, sem alterar a lógica de despacho já usada pelos demais controllers.
- `AtendimentosController::criar()` — o responsável pelo atendimento passou a vir de `$_SESSION['usuario']['id']` (usuário já autenticado), e não de um campo `usuario_id` solto no formulário — evita que alguém registre um atendimento em nome de outro usuário.
- Nomes dos campos usados no JavaScript foram conferidos contra os `SELECT` reais dos controllers (`pessoa_id`, `tipo_atendimento_id`, `documento`, `curso`, `periodo`, `observacoes`, `data_atendimento`, `horario_atendimento`, `observacao_final`, `responsavel_nome`) para não haver divergência entre o que a tela espera e o que o banco retorna.
- Perfil de usuário mantido como `admin` / `atendente`, conforme o ENUM da tabela `usuarios` (não `administrador`).

#### Explicação curta — como o frontend conversa com o backend

O fluxo começa em `public/index.php`, que delega para `routes.php`. As páginas visuais (`?controller=frontend&action=pessoas|tipos|atendimentos`) são apenas HTML renderizado pelo PHP a partir das views; elas não tocam no banco. Assim que a página carrega, o `api.js` (carregado pelo `header.php`) faz `fetch` para os controllers de dados (`pessoas`, `tipos`, `atendimentos`, `dashboard`) usando `GET` para listagens/buscas e `POST` com corpo `x-www-form-urlencoded` para criar, atualizar, inativar ou alterar status. Cada controller valida os dados recebidos, executa a consulta via PDO no banco `atendelab` e responde em JSON. O `api.js` interpreta essa resposta, e o JavaScript da própria tela usa o resultado para montar a tabela, preencher o formulário de edição ou exibir mensagens de sucesso/erro — sem nunca recarregar a página inteira. A sessão do PHP garante que só um usuário autenticado alcance essas rotas, e que o `usuario_id` de cada atendimento venha da sessão, não de um campo digitável.
