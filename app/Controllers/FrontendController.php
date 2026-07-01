<?php

/**
 * Controller responsável apenas por entregar as páginas visuais (views).
 * Não acessa o banco: quem busca e grava dados é sempre o controller
 * específico (pessoas, tipos, atendimentos), chamado pelo JavaScript
 * através de public/assets/js/api.js.
 */
class FrontendController
{
    public function pessoas(): void
    {
        require __DIR__ . '/../Views/pessoas/index.php';
    }

    public function tipos(): void
    {
        require __DIR__ . '/../Views/tipos-atendimentos/index.php';
    }

    public function atendimentos(): void
    {
        require __DIR__ . '/../Views/atendimentos/index.php';
    }
}
