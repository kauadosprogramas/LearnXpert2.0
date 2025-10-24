<?php
// Debug da API de escolas
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Habilitar exibição de erros para debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    echo "Iniciando debug da API...\n";
    
    // Testar conexão com o banco
    require_once 'config/database.php';
    echo "Arquivo database.php carregado...\n";
    
    $database = new Database();
    echo "Objeto Database criado...\n";
    
    $conn = $database->getConnection();
    echo "Conexão obtida...\n";
    
    if (!$conn) {
        throw new Exception("Falha na conexão com o banco");
    }
    
    echo "Conexão estabelecida com sucesso!\n";
    
    // Testar consulta simples
    $sql = "SELECT COUNT(*) as total FROM escolas";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "Total de escolas no banco: " . $result['total'] . "\n";
    
    // Testar consulta completa
    $sql = "SELECT id, nome, localizacao, ativo FROM escolas WHERE ativo = 1 ORDER BY nome ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $escolas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Escolas encontradas: " . count($escolas) . "\n";
    
    // Retornar resultado em formato JSON
    $response = [
        'success' => true,
        'message' => 'API funcionando corretamente',
        'debug_info' => [
            'total_escolas' => $result['total'],
            'escolas_ativas' => count($escolas)
        ],
        'data' => $escolas
    ];
    
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    $error_response = [
        'success' => false,
        'error' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'trace' => $e->getTraceAsString()
    ];
    
    echo json_encode($error_response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
?>