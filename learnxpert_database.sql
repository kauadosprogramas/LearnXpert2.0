-- =====================================================
-- LearnXpert Database - Script Completo
-- =====================================================
-- Este script cria o banco de dados completo para o sistema LearnXpert
-- Execute este script no phpMyAdmin para configurar tudo automaticamente

-- Criar banco de dados
DROP DATABASE IF EXISTS `learnxpert`;
CREATE DATABASE `learnxpert` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `learnxpert`;

-- =====================================================
-- TABELA: escolas
-- =====================================================
CREATE TABLE `escolas` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nome` VARCHAR(255) NOT NULL,
    `logo` VARCHAR(500) NULL COMMENT 'URL da imagem ou iniciais para logo',
    `logo_tipo` ENUM('iniciais', 'imagem') DEFAULT 'iniciais' COMMENT 'Tipo do logo: iniciais ou imagem',
    `localizacao` VARCHAR(255) NOT NULL,
    `endereco` TEXT,
    `telefone` VARCHAR(20),
    `email` VARCHAR(255),
    `niveis_ensino` JSON COMMENT 'Array JSON com os níveis de ensino oferecidos',
    `descricao` TEXT,
    `ativo` BOOLEAN DEFAULT TRUE,
    `data_criacao` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `data_atualizacao` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX `idx_localizacao` (`localizacao`),
    INDEX `idx_ativo` (`ativo`),
    INDEX `idx_data_criacao` (`data_criacao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tabela de escolas cadastradas no sistema';

-- =====================================================
-- TABELA: matriculas
-- =====================================================
CREATE TABLE `matriculas` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `escola_id` INT,
    `nome_aluno` VARCHAR(255) NOT NULL,
    `data_nascimento` DATE NOT NULL,
    `cpf` VARCHAR(14) NOT NULL,
    `rg` VARCHAR(20),
    `nome_responsavel` VARCHAR(255) NOT NULL,
    `cpf_responsavel` VARCHAR(14) NOT NULL,
    `telefone` VARCHAR(20) NOT NULL,
    `email` VARCHAR(255),
    `endereco` TEXT NOT NULL,
    `nivel_ensino` VARCHAR(100) NOT NULL,
    `turno` VARCHAR(50) NOT NULL,
    `observacoes` TEXT,
    `status` ENUM('pendente', 'aprovada', 'rejeitada') DEFAULT 'pendente',
    `data_matricula` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (`escola_id`) REFERENCES `escolas`(`id`) ON DELETE SET NULL,
    INDEX `idx_escola_id` (`escola_id`),
    INDEX `idx_status` (`status`),
    INDEX `idx_data_matricula` (`data_matricula`),
    INDEX `idx_cpf` (`cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tabela de matrículas realizadas';

-- =====================================================
-- TABELA: usuarios
-- =====================================================
CREATE TABLE `usuarios` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nome` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) UNIQUE NOT NULL,
    `senha` VARCHAR(255) NOT NULL COMMENT 'Senha criptografada com password_hash()',
    `tipo` ENUM('admin', 'escola') DEFAULT 'admin',
    `escola_id` INT NULL COMMENT 'ID da escola se o usuário for do tipo escola',
    `ativo` BOOLEAN DEFAULT TRUE,
    `data_criacao` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (`escola_id`) REFERENCES `escolas`(`id`) ON DELETE SET NULL,
    INDEX `idx_email` (`email`),
    INDEX `idx_tipo` (`tipo`),
    INDEX `idx_ativo` (`ativo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tabela de usuários do sistema';

-- =====================================================
-- DADOS DE EXEMPLO
-- =====================================================

-- Inserir escolas de exemplo
INSERT INTO `escolas` (`nome`, `logo`, `logo_tipo`, `localizacao`, `endereco`, `telefone`, `email`, `niveis_ensino`, `descricao`) VALUES 
('Colégio São Francisco', 'CSF', 'iniciais', 'São Paulo - SP', 'Rua das Flores, 123 - Centro', '(11) 3333-4444', 'contato@saofrancsico.edu.br', '["Ensino Fundamental I", "Ensino Fundamental II", "Ensino Médio"]', 'Tradição em educação há mais de 50 anos. Formamos cidadãos conscientes e preparados para o futuro.'),

('Escola Criança Feliz', 'ECF', 'iniciais', 'Rio de Janeiro - RJ', 'Av. Atlântica, 456 - Copacabana', '(21) 2222-3333', 'secretaria@criancafeliz.com.br', '["Creche", "Pré-escola", "Ensino Fundamental I"]', 'Educação infantil com carinho e dedicação. Ambiente acolhedor para o desenvolvimento integral da criança.'),

('Instituto Tecnológico Futuro', 'ITF', 'iniciais', 'Belo Horizonte - MG', 'Rua da Tecnologia, 789 - Savassi', '(31) 4444-5555', 'info@tecfuturo.edu.br', '["Ensino Médio", "Ensino Técnico"]', 'Preparando jovens para as profissões do futuro com tecnologia de ponta e metodologia inovadora.'),

('Colégio Verde Vida', 'CVV', 'iniciais', 'Curitiba - PR', 'Rua Ecológica, 321 - Batel', '(41) 5555-6666', 'contato@verdevida.edu.br', '["Ensino Fundamental I", "Ensino Fundamental II", "Ensino Médio"]', 'Educação sustentável e consciente. Formamos cidadãos responsáveis com o meio ambiente.'),

('Escola Arte & Saber', 'EAS', 'iniciais', 'Salvador - BA', 'Rua das Artes, 654 - Pelourinho', '(71) 6666-7777', 'arte@artesaber.edu.br', '["Pré-escola", "Ensino Fundamental I", "Ensino Fundamental II"]', 'Desenvolvendo talentos através da arte e do conhecimento. Educação criativa e transformadora.');

-- Inserir usuários de exemplo
INSERT INTO `usuarios` (`nome`, `email`, `senha`, `tipo`) VALUES 
('Administrador Geral', 'admin@learnxpert.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('João Silva', 'joao@learnxpert.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('Maria Santos', 'maria@saofrancsico.edu.br', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'escola');

-- Atualizar usuário da escola com o ID correto
UPDATE `usuarios` SET `escola_id` = 1 WHERE `email` = 'maria@saofrancsico.edu.br';

-- Inserir algumas matrículas de exemplo
INSERT INTO `matriculas` (`escola_id`, `nome_aluno`, `data_nascimento`, `cpf`, `rg`, `nome_responsavel`, `cpf_responsavel`, `telefone`, `email`, `endereco`, `nivel_ensino`, `turno`, `observacoes`, `status`) VALUES 
(1, 'Pedro Oliveira', '2010-05-15', '123.456.789-01', '12.345.678-9', 'Ana Oliveira', '987.654.321-00', '(11) 99999-1111', 'ana@email.com', 'Rua A, 100 - Bairro X', 'Ensino Fundamental II', 'Manhã', 'Aluno dedicado e participativo', 'aprovada'),

(2, 'Sofia Costa', '2018-08-22', '234.567.890-12', '23.456.789-0', 'Carlos Costa', '876.543.210-99', '(21) 88888-2222', 'carlos@email.com', 'Av. B, 200 - Bairro Y', 'Pré-escola', 'Tarde', 'Primeira experiência escolar', 'pendente'),

(3, 'Lucas Ferreira', '2005-12-03', '345.678.901-23', '34.567.890-1', 'Mariana Ferreira', '765.432.109-88', '(31) 77777-3333', 'mariana@email.com', 'Rua C, 300 - Bairro Z', 'Ensino Médio', 'Integral', 'Interesse em tecnologia', 'aprovada'),

(4, 'Isabella Santos', '2012-03-18', '456.789.012-34', '45.678.901-2', 'Roberto Santos', '654.321.098-77', '(41) 66666-4444', 'roberto@email.com', 'Av. D, 400 - Bairro W', 'Ensino Fundamental I', 'Manhã', 'Muito criativa e curiosa', 'aprovada'),

(5, 'Gabriel Lima', '2015-09-07', '567.890.123-45', '56.789.012-3', 'Fernanda Lima', '543.210.987-66', '(71) 55555-5555', 'fernanda@email.com', 'Rua E, 500 - Bairro V', 'Pré-escola', 'Tarde', 'Gosta muito de desenhar', 'pendente');

-- =====================================================
-- CONFIGURAÇÕES FINAIS
-- =====================================================

-- Definir charset padrão para a sessão
SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

-- Mostrar informações do banco criado
SELECT 
    'Banco de dados LearnXpert criado com sucesso!' as status,
    (SELECT COUNT(*) FROM escolas) as total_escolas,
    (SELECT COUNT(*) FROM matriculas) as total_matriculas,
    (SELECT COUNT(*) FROM usuarios) as total_usuarios;