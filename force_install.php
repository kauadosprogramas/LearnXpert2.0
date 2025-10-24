<?php
// Script para forçar a instalação do banco
header('Content-Type: text/html; charset=utf-8');

echo "<h2>🚀 Instalação Forçada - LearnXpert</h2>";

try {
    require_once 'config/database.php';
    
    echo "<h3>📋 Iniciando instalação...</h3>";
    
    // Forçar criação do banco
    echo "<p>1. Criando banco de dados...</p>";
    $result = createDatabase();
    
    if ($result) {
        echo "✅ <strong>Banco criado com sucesso!</strong><br>";
        
        // Verificar se foi criado
        $database = new Database();
        $conn = $database->getConnection();
        
        if ($conn) {
            echo "<p>2. Verificando tabelas criadas...</p>";
            
            $stmt = $conn->query("SHOW TABLES");
            $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
            
            echo "<ul>";
            foreach ($tables as $table) {
                echo "<li>✅ Tabela: $table</li>";
            }
            echo "</ul>";
            
            // Verificar dados
            echo "<p>3. Verificando dados de exemplo...</p>";
            
            $stmt = $conn->query("SELECT COUNT(*) as total FROM escolas");
            $count_escolas = $stmt->fetch()['total'];
            
            $stmt = $conn->query("SELECT COUNT(*) as total FROM usuarios");
            $count_usuarios = $stmt->fetch()['total'];
            
            echo "<ul>";
            echo "<li>Escolas: $count_escolas registros</li>";
            echo "<li>Usuários: $count_usuarios registros</li>";
            echo "</ul>";
            
            if ($count_escolas > 0 && $count_usuarios > 0) {
                echo "✅ <strong>Instalação completa!</strong><br>";
                
                echo "<h3>🔑 Credenciais de acesso:</h3>";
                echo "<ul>";
                echo "<li><strong>Email:</strong> admin@learnxpert.com</li>";
                echo "<li><strong>Senha:</strong> admin123</li>";
                echo "</ul>";
                
                echo "<h3>🎯 Próximos passos:</h3>";
                echo "<ol>";
                echo "<li><a href='admin_escolas.html'>🏫 Testar Admin Escolas</a></li>";
                echo "<li><a href='api/escolas.php'>📡 Testar API Escolas</a></li>";
                echo "<li><a href='index.html'>🏠 Ir para página inicial</a></li>";
                echo "</ol>";
                
            } else {
                echo "❌ <strong>Dados de exemplo não foram criados!</strong><br>";
            }
            
        } else {
            echo "❌ <strong>Erro ao conectar com o banco criado</strong><br>";
        }
        
    } else {
        echo "❌ <strong>Erro ao criar banco de dados</strong><br>";
    }
    
} catch (Exception $e) {
    echo "❌ <strong>Erro durante instalação:</strong> " . $e->getMessage() . "<br>";
    
    echo "<h3>🔧 Diagnóstico detalhado:</h3>";
    
    // Verificar MySQL
    try {
        $pdo = new PDO("mysql:host=localhost", "root", "");
        echo "✅ MySQL está funcionando<br>";
        
        // Tentar criar banco manualmente
        echo "<p>Tentando criar banco manualmente...</p>";
        $pdo->exec("CREATE DATABASE IF NOT EXISTS learnxpert CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        echo "✅ Banco 'learnxpert' criado<br>";
        
        $pdo->exec("USE learnxpert");
        
        // Criar tabela escolas
        $sql = "CREATE TABLE IF NOT EXISTS escolas (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(255) NOT NULL,
            logo VARCHAR(500) NULL,
            logo_tipo ENUM('iniciais', 'imagem') DEFAULT 'iniciais',
            localizacao VARCHAR(255) NOT NULL,
            endereco TEXT,
            telefone VARCHAR(20),
            email VARCHAR(255),
            niveis_ensino JSON,
            descricao TEXT,
            ativo BOOLEAN DEFAULT TRUE,
            data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            data_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        $pdo->exec($sql);
        echo "✅ Tabela 'escolas' criada<br>";
        
        // Criar tabela matriculas
        $sql = "CREATE TABLE IF NOT EXISTS matriculas (
            id INT AUTO_INCREMENT PRIMARY KEY,
            escola_id INT,
            nome_aluno VARCHAR(255) NOT NULL,
            data_nascimento DATE NOT NULL,
            cpf VARCHAR(14) NOT NULL,
            rg VARCHAR(20),
            nome_responsavel VARCHAR(255) NOT NULL,
            cpf_responsavel VARCHAR(14) NOT NULL,
            telefone VARCHAR(20) NOT NULL,
            email VARCHAR(255),
            endereco TEXT NOT NULL,
            nivel_ensino VARCHAR(100) NOT NULL,
            turno VARCHAR(50) NOT NULL,
            observacoes TEXT,
            status ENUM('pendente', 'aprovada', 'rejeitada') DEFAULT 'pendente',
            data_matricula TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (escola_id) REFERENCES escolas(id) ON DELETE SET NULL
        )";
        $pdo->exec($sql);
        echo "✅ Tabela 'matriculas' criada<br>";
        
        // Criar tabela usuarios
        $sql = "CREATE TABLE IF NOT EXISTS usuarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(255) NOT NULL,
            email VARCHAR(255) UNIQUE NOT NULL,
            senha VARCHAR(255) NOT NULL,
            tipo ENUM('admin', 'escola') DEFAULT 'admin',
            escola_id INT NULL,
            ativo BOOLEAN DEFAULT TRUE,
            data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (escola_id) REFERENCES escolas(id) ON DELETE SET NULL
        )";
        $pdo->exec($sql);
        echo "✅ Tabela 'usuarios' criada<br>";
        
        // Inserir dados de exemplo
        echo "<p>Inserindo dados de exemplo...</p>";
        
        // Verificar se já existem dados
        $stmt = $pdo->query("SELECT COUNT(*) FROM escolas");
        if ($stmt->fetchColumn() == 0) {
            $sql = "INSERT INTO escolas (nome, logo, logo_tipo, localizacao, endereco, telefone, email, niveis_ensino, descricao) VALUES 
                    ('Escola Exemplo', 'EX', 'iniciais', 'Cidade X', 'Rua das Flores, 123', '(11) 99999-9999', 'contato@escolaexemplo.com', 
                     '[\"Creche\", \"Ensino Fundamental\"]', 'Escola de qualidade com mais de 20 anos de experiência.')";
            $pdo->exec($sql);
            echo "✅ Escola de exemplo inserida<br>";
        }
        
        $stmt = $pdo->query("SELECT COUNT(*) FROM usuarios");
        if ($stmt->fetchColumn() == 0) {
            $senha_hash = password_hash('admin123', PASSWORD_DEFAULT);
            $sql = "INSERT INTO usuarios (nome, email, senha, tipo) VALUES 
                    ('Administrador', 'admin@learnxpert.com', '$senha_hash', 'admin')";
            $pdo->exec($sql);
            echo "✅ Usuário admin inserido<br>";
        }
        
        echo "<h3>🎉 Instalação manual concluída!</h3>";
        echo "<p><a href='admin_escolas.html'>🏫 Testar sistema</a></p>";
        
    } catch (PDOException $mysql_error) {
        echo "❌ Erro no MySQL: " . $mysql_error->getMessage() . "<br>";
    }
}
?>