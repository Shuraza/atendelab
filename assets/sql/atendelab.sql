-- 1. usuarios — adiciona atualizado_em (se ainda não existir)
ALTER TABLE `usuarios`
    ADD COLUMN `atualizado_em` TIMESTAMP NOT NULL
        DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP;

-- 2. pessoas — adiciona colunas exigidas pelo fronted
ALTER TABLE `pessoas`
    MODIFY COLUMN `nome`      VARCHAR(150) NOT NULL,
    MODIFY COLUMN `documento` VARCHAR(30)  NOT NULL,
    ADD COLUMN `email`        VARCHAR(150) NOT NULL   AFTER `telefone`,
    ADD COLUMN `curso`        VARCHAR(120)            AFTER `email`,
    ADD COLUMN `periodo`      VARCHAR(20)             AFTER `curso`,
    ADD COLUMN `observacoes`  TEXT                    AFTER `periodo`,
    ADD COLUMN `status`       ENUM('ativo','inativo') NOT NULL DEFAULT 'ativo' AFTER `observacoes`,
    ADD COLUMN `atualizado_em` TIMESTAMP NOT NULL
        DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP;

-- 3. tipos_atendimentos — adicioa status e atualizado_em
ALTER TABLE `tipos_atendimentos`
    ADD COLUMN `status` ENUM('ativo','inativo') NOT NULL DEFAULT 'ativo' AFTER `descricao`,
    ADD COLUMN `atualizado_em` TIMESTAMP NOT NULL
        DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP;

-- 4. atendimetos — recria com estrutura completa
--    (só execute DROP + CREATE se a tabela estiver vazia ou não existir)
DROP TABLE IF EXISTS `atendimentos`;

CREATE TABLE `atendimentos` (
    `id`                  INT           NOT NULL AUTO_INCREMENT,
    `pessoa_id`           INT           NOT NULL,
    `tipo_atendimento_id` INT           NOT NULL,
    `usuario_id`          INT           NOT NULL,
    `descricao`           TEXT          NOT NULL,
    `status`              ENUM('aberto','em_andamento','concluido')
                                        NOT NULL DEFAULT 'aberto',
    `data_atendimento`    DATE          NOT NULL,
    `horario_atendimento` TIME          NOT NULL,
    `observacao_final`    TEXT,
    `criado_em`           TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `atualizado_em`       TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP
                                        ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_atendimentos_pessoa`
        FOREIGN KEY (`pessoa_id`)           REFERENCES `pessoas`(`id`)           ON UPDATE CASCADE,
    CONSTRAINT `fk_atendimentos_tipo`
        FOREIGN KEY (`tipo_atendimento_id`) REFERENCES `tipos_atendimentos`(`id`) ON UPDATE CASCADE,
    CONSTRAINT `fk_atendimentos_usuario`
        FOREIGN KEY (`usuario_id`)          REFERENCES `usuarios`(`id`)          ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 5. Dados iniciais — tipos de atendimento
INSERT INTO `tipos_atendimentos` (`nome`, `descricao`, `status`) VALUES
    ('Dúvida acadêmica',       'Dúvidas sobre disciplinas, conteúdos e atividades.', 'ativo'),
    ('Orientação de atividade','Orientações sobre trabalhos, TCC e projetos.',        'ativo'),
    ('Suporte técnico',        'Problemas com sistemas, equipamentos e acessos.',     'ativo'),
    ('Matrícula e documentação','Solicitações de matrícula, declarações e históricos.','ativo'),
    ('Acesso ao laboratório',  'Liberação de uso e agendamento de laboratórios.',    'ativo');

-- 6. Dados iniciais — pessoas fictícias para testes
INSERT INTO `pessoas`
    (`nome`, `documento`, `telefone`, `email`, `curso`, `periodo`, `status`)
VALUES
    ('João da Silva',    '123.456.789-00', '(47) 99999-0001',
     'joao.silva@exemplo.com',    'Engenharia de Software', '5º', 'ativo'),
    ('Ana Carolina',     '987.654.321-00', '(47) 99999-0002',
     'ana.carolina@exemplo.com',  'Sistemas de Informação', '7º', 'ativo');