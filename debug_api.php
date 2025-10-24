<?php
// Debug simples da API
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>🐛 Debug API Escolas</h2>";

echo "<h3>1. Testando conexão com banco:</h3>";

try {
    require_once 'config/database.php';
    
    $database = new Database();
    $conn = $database->getConnection();
    
    if ($conn) {
        echo "✅ Conexão OK<br>";
        
        // Testar query simples
        $stmt = $conn->query("SELECT COUNT(*) as total FROM escolas");
        $total = $stmt->fetch()['total'];
        echo "✅ Total de escolas no banco: $total<br>";
        
        // Buscar escolas
        $stmt = $conn->query("SELECT * FROM escolas LIMIT 5");
        $escolas = $stmt->fetchAll();
        
        echo "<h3>2. Dados das escolas:</h3>";
        echo "<pre>";
        print_r($escolas);
        echo "</pre>";
        
    } else {
        echo "❌ Erro na conexão<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Erro: " . $e->getMessage() . "<br>";
}

echo "<h3>3. Testando API diretamente:</h3>";

try {
    // Simular requisição GET
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = '/api/escolas.php';
    
    // Capturar output da API
    ob_start();
    
    // Incluir API
    include 'api/escolas.php';
    
    $output = ob_get_clean();
    
    echo "<h4>Resposta da API:</h4>";
    echo "<pre style='background: #f5f5f5; padding: 10px; border-radius: 5px; color: #333;'>";
    echo htmlspecialchars($output);
    echo "</pre>";
    
    // Tentar decodificar JSON
    $json = json_decode($output, true);
    if ($json) {
        echo "<h4>JSON decodificado:</h4>";
        echo "<pre>";
        print_r($json);
        echo "</pre>";
    } else {
        echo "❌ Resposta não é JSON válido<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Erro ao testar API: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<h3>4. Links para teste:</h3>";
echo "<ul>";
echo "<li><a href='api/escolas.php' target='_blank'>🔗 API Escolas (nova aba)</a></li>";
echo "<li><a href='admin_escolas.html'>🏫 Admin Escolas</a></li>";
echo "<li><a href='index.html'>🏠 Página inicial</a></li>";
echo "</ul>";
?>