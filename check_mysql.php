<?php
// Verificação básica do MySQL
header('Content-Type: text/html; charset=utf-8');

echo "<h2>🔍 Verificação MySQL - XAMPP</h2>";

echo "<h3>📋 Informações do PHP:</h3>";
echo "<p><strong>Versão PHP:</strong> " . phpversion() . "</p>";
echo "<p><strong>Extensões carregadas:</strong></p>";
echo "<ul>";
if (extension_loaded('pdo')) {
    echo "<li>✅ PDO</li>";
} else {
    echo "<li>❌ PDO (NECESSÁRIO)</li>";
}

if (extension_loaded('pdo_mysql')) {
    echo "<li>✅ PDO MySQL</li>";
} else {
    echo "<li>❌ PDO MySQL (NECESSÁRIO)</li>";
}

if (extension_loaded('mysqli')) {
    echo "<li>✅ MySQLi</li>";
} else {
    echo "<li>❌ MySQLi</li>";
}
echo "</ul>";

echo "<h3>🔌 Teste de Conexão Básica:</h3>";

// Configurações
$host = 'localhost';
$user = 'root';
$pass = '';

try {
    echo "<p>Tentando conectar ao MySQL...</p>";
    
    // Teste com PDO
    $dsn = "mysql:host=$host";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ <strong>Conexão PDO: SUCESSO</strong><br>";
    
    // Verificar versão do MySQL
    $stmt = $pdo->query("SELECT VERSION() as version");
    $version = $stmt->fetch()['version'];
    echo "<p><strong>Versão MySQL:</strong> $version</p>";
    
    // Listar bancos de dados
    $stmt = $pdo->query("SHOW DATABASES");
    $databases = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "<h4>📊 Bancos de dados disponíveis:</h4>";
    echo "<ul>";
    foreach ($databases as $db) {
        if ($db === 'learnxpert') {
            echo "<li>✅ <strong>$db</strong> (NOSSO BANCO)</li>";
        } else {
            echo "<li>$db</li>";
        }
    }
    echo "</ul>";
    
    // Verificar se nosso banco existe
    if (in_array('learnxpert', $databases)) {
        echo "<h4>🏫 Verificando banco 'learnxpert':</h4>";
        $pdo->exec("USE learnxpert");
        
        $stmt = $pdo->query("SHOW TABLES");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        if (empty($tables)) {
            echo "<p>❌ <strong>Banco existe mas não tem tabelas!</strong></p>";
            echo "<p>🔧 <strong>Solução:</strong> Execute o install.php ou o script SQL</p>";
        } else {
            echo "<p>✅ <strong>Tabelas encontradas:</strong></p>";
            echo "<ul>";
            foreach ($tables as $table) {
                echo "<li>$table</li>";
            }
            echo "</ul>";
            
            // Verificar dados na tabela escolas
            if (in_array('escolas', $tables)) {
                $stmt = $pdo->query("SELECT COUNT(*) as total FROM escolas");
                $count = $stmt->fetch()['total'];
                echo "<p><strong>Registros na tabela 'escolas':</strong> $count</p>";
            }
        }
    } else {
        echo "<p>❌ <strong>Banco 'learnxpert' não existe!</strong></p>";
        echo "<p>🔧 <strong>Solução:</strong> Execute o script SQL no phpMyAdmin ou o install.php</p>";
    }
    
} catch (PDOException $e) {
    echo "❌ <strong>Erro de conexão:</strong> " . $e->getMessage() . "<br>";
    
    echo "<h4>🔧 Possíveis problemas:</h4>";
    echo "<ul>";
    echo "<li>XAMPP não está rodando</li>";
    echo "<li>MySQL não foi iniciado no XAMPP Control Panel</li>";
    echo "<li>Porta 3306 está ocupada por outro serviço</li>";
    echo "<li>Configurações de firewall bloqueando a conexão</li>";
    echo "</ul>";
    
    echo "<h4>📝 Como resolver:</h4>";
    echo "<ol>";
    echo "<li>Abra o XAMPP Control Panel</li>";
    echo "<li>Clique em 'Start' ao lado do MySQL</li>";
    echo "<li>Verifique se aparece 'Running' em verde</li>";
    echo "<li>Se der erro, verifique os logs do MySQL</li>";
    echo "</ol>";
}

echo "<hr>";
echo "<p><a href='install.php'>🚀 Ir para Instalação</a> | <a href='test_connection.php'>🔍 Teste Detalhado</a></p>";
?>