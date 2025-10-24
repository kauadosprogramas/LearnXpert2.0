<?php
// Script de teste das APIs
header('Content-Type: text/html; charset=utf-8');

echo "<h2>🧪 Teste das APIs - LearnXpert</h2>";

// Função para fazer requisições
function testAPI($url, $method = 'GET', $data = null) {
    $context = stream_context_create([
        'http' => [
            'method' => $method,
            'header' => 'Content-Type: application/json',
            'content' => $data ? json_encode($data) : null
        ]
    ]);
    
    $result = @file_get_contents($url, false, $context);
    return $result;
}

echo "<h3>🏫 Teste API Escolas (GET):</h3>";

$base_url = "http://localhost:8000";
$escolas_url = $base_url . "/api/escolas.php";

echo "<p><strong>URL:</strong> $escolas_url</p>";

$response = testAPI($escolas_url);

if ($response === false) {
    echo "❌ <strong>Erro:</strong> Não foi possível conectar à API<br>";
} else {
    echo "✅ <strong>Resposta recebida:</strong><br>";
    echo "<pre style='background: #f5f5f5; padding: 10px; border-radius: 5px; color: #333;'>";
    echo htmlspecialchars($response);
    echo "</pre>";
    
    $json = json_decode($response, true);
    if ($json) {
        echo "<h4>📊 Dados decodificados:</h4>";
        if (isset($json['escolas']) && is_array($json['escolas'])) {
            echo "<p><strong>Total de escolas:</strong> " . count($json['escolas']) . "</p>";
            
            if (count($json['escolas']) > 0) {
                echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
                echo "<tr><th>ID</th><th>Nome</th><th>Logo</th><th>Logo Tipo</th><th>Localização</th></tr>";
                foreach ($json['escolas'] as $escola) {
                    echo "<tr>";
                    echo "<td>" . ($escola['id'] ?? 'N/A') . "</td>";
                    echo "<td>" . ($escola['nome'] ?? 'N/A') . "</td>";
                    echo "<td>" . ($escola['logo'] ?? 'N/A') . "</td>";
                    echo "<td>" . ($escola['logo_tipo'] ?? 'N/A') . "</td>";
                    echo "<td>" . ($escola['localizacao'] ?? 'N/A') . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        } else {
            echo "❌ <strong>Formato de resposta inesperado</strong>";
        }
    } else {
        echo "❌ <strong>Resposta não é um JSON válido</strong>";
    }
}

echo "<hr>";

echo "<h3>🔍 Teste Direto do Banco:</h3>";

try {
    require_once 'config/database.php';
    
    $database = new Database();
    $conn = $database->getConnection();
    
    if ($conn) {
        echo "✅ <strong>Conexão com banco: OK</strong><br>";
        
        $stmt = $conn->query("SELECT * FROM escolas ORDER BY id");
        $escolas = $stmt->fetchAll();
        
        echo "<p><strong>Escolas no banco:</strong> " . count($escolas) . "</p>";
        
        if (count($escolas) > 0) {
            echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
            echo "<tr><th>ID</th><th>Nome</th><th>Logo</th><th>Logo Tipo</th><th>Localização</th></tr>";
            foreach ($escolas as $escola) {
                echo "<tr>";
                echo "<td>" . $escola['id'] . "</td>";
                echo "<td>" . $escola['nome'] . "</td>";
                echo "<td>" . $escola['logo'] . "</td>";
                echo "<td>" . $escola['logo_tipo'] . "</td>";
                echo "<td>" . $escola['localizacao'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "❌ <strong>Nenhuma escola encontrada no banco!</strong><br>";
            echo "<p>Execute o install.php para criar dados de exemplo.</p>";
        }
        
    } else {
        echo "❌ <strong>Falha na conexão com o banco</strong><br>";
    }
    
} catch (Exception $e) {
    echo "❌ <strong>Erro:</strong> " . $e->getMessage() . "<br>";
}

echo "<hr>";

echo "<h3>🔧 Diagnóstico:</h3>";

// Verificar se o arquivo da API existe
if (file_exists('api/escolas.php')) {
    echo "✅ Arquivo api/escolas.php existe<br>";
} else {
    echo "❌ Arquivo api/escolas.php não encontrado<br>";
}

// Verificar se o banco existe
try {
    $pdo = new PDO("mysql:host=" . DB_HOST, DB_USER, DB_PASS);
    $stmt = $pdo->query("SHOW DATABASES LIKE '" . DB_NAME . "'");
    if ($stmt->rowCount() > 0) {
        echo "✅ Banco 'learnxpert' existe<br>";
        
        $pdo->exec("USE " . DB_NAME);
        $stmt = $pdo->query("SHOW TABLES LIKE 'escolas'");
        if ($stmt->rowCount() > 0) {
            echo "✅ Tabela 'escolas' existe<br>";
        } else {
            echo "❌ Tabela 'escolas' não existe<br>";
        }
    } else {
        echo "❌ Banco 'learnxpert' não existe<br>";
    }
} catch (Exception $e) {
    echo "❌ Erro ao verificar banco: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<h3>📝 Ações recomendadas:</h3>";
echo "<ol>";
echo "<li><a href='install.php'>🚀 Executar instalação</a></li>";
echo "<li><a href='test_connection.php'>🔍 Testar conexão detalhada</a></li>";
echo "<li><a href='api/escolas.php'>🏫 Testar API diretamente</a></li>";
echo "<li><a href='admin_escolas.html'>⚙️ Testar interface admin</a></li>";
echo "</ol>";
?>