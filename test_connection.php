<?php
// Script de teste de conexão com o banco de dados
header('Content-Type: text/html; charset=utf-8');

echo "<h2>🔍 Teste de Conexão - LearnXpert</h2>";

// Incluir configurações
require_once 'config/database.php';

echo "<h3>📋 Configurações:</h3>";
echo "<ul>";
echo "<li><strong>Host:</strong> " . DB_HOST . "</li>";
echo "<li><strong>Banco:</strong> " . DB_NAME . "</li>";
echo "<li><strong>Usuário:</strong> " . DB_USER . "</li>";
echo "<li><strong>Senha:</strong> " . (empty(DB_PASS) ? 'Vazia' : 'Configurada') . "</li>";
echo "</ul>";

echo "<h3>🔌 Teste de Conexão MySQL:</h3>";

try {
    // Testar conexão sem especificar banco
    $pdo = new PDO("mysql:host=" . DB_HOST, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ <strong>Conexão com MySQL: SUCESSO</strong><br>";
    
    // Verificar se o banco existe
    $stmt = $pdo->query("SHOW DATABASES LIKE '" . DB_NAME . "'");
    $database_exists = $stmt->rowCount() > 0;
    
    if ($database_exists) {
        echo "✅ <strong>Banco '" . DB_NAME . "': EXISTE</strong><br>";
        
        // Conectar ao banco específico
        $pdo->exec("USE " . DB_NAME);
        
        // Verificar tabelas
        $stmt = $pdo->query("SHOW TABLES");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        echo "<h4>📊 Tabelas encontradas:</h4>";
        if (empty($tables)) {
            echo "❌ <strong>Nenhuma tabela encontrada!</strong><br>";
        } else {
            echo "<ul>";
            foreach ($tables as $table) {
                echo "<li>✅ " . $table . "</li>";
            }
            echo "</ul>";
        }
        
        // Verificar dados na tabela escolas
        if (in_array('escolas', $tables)) {
            $stmt = $pdo->query("SELECT COUNT(*) as total FROM escolas");
            $count = $stmt->fetch()['total'];
            echo "<h4>🏫 Dados na tabela 'escolas':</h4>";
            echo "<p><strong>Total de registros:</strong> " . $count . "</p>";
            
            if ($count > 0) {
                $stmt = $pdo->query("SELECT id, nome, logo_tipo FROM escolas LIMIT 5");
                $escolas = $stmt->fetchAll();
                echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
                echo "<tr><th>ID</th><th>Nome</th><th>Logo Tipo</th></tr>";
                foreach ($escolas as $escola) {
                    echo "<tr>";
                    echo "<td>" . $escola['id'] . "</td>";
                    echo "<td>" . $escola['nome'] . "</td>";
                    echo "<td>" . $escola['logo_tipo'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        }
        
    } else {
        echo "❌ <strong>Banco '" . DB_NAME . "': NÃO EXISTE</strong><br>";
        echo "<p>🔧 <strong>Solução:</strong> Execute o script SQL no phpMyAdmin ou rode o install.php</p>";
    }
    
} catch (PDOException $e) {
    echo "❌ <strong>Erro de conexão:</strong> " . $e->getMessage() . "<br>";
    echo "<h4>🔧 Possíveis soluções:</h4>";
    echo "<ul>";
    echo "<li>Verificar se o XAMPP está rodando</li>";
    echo "<li>Verificar se o MySQL está ativo no XAMPP</li>";
    echo "<li>Verificar as credenciais de acesso</li>";
    echo "</ul>";
}

echo "<h3>🧪 Teste da Classe Database:</h3>";

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    if ($conn) {
        echo "✅ <strong>Classe Database: FUNCIONANDO</strong><br>";
        
        // Testar uma query simples
        $stmt = $conn->query("SELECT 1 as test");
        $result = $stmt->fetch();
        if ($result['test'] == 1) {
            echo "✅ <strong>Query de teste: SUCESSO</strong><br>";
        }
    } else {
        echo "❌ <strong>Classe Database: FALHOU</strong><br>";
    }
    
} catch (Exception $e) {
    echo "❌ <strong>Erro na classe Database:</strong> " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<h3>📝 Próximos passos:</h3>";
echo "<ol>";
echo "<li>Se o banco não existe, execute o arquivo <code>learnxpert_database.sql</code> no phpMyAdmin</li>";
echo "<li>Se as tabelas não existem, execute o <code>install.php</code></li>";
echo "<li>Se tudo estiver OK, verifique as APIs em <code>api/escolas.php</code></li>";
echo "</ol>";

echo "<p><a href='install.php'>🚀 Executar Install.php</a> | <a href='admin_escolas.html'>🏫 Testar Admin Escolas</a></p>";
?>