<?php
header('Content-Type: application/json; charset=utf-8');

try {
    // Incluir configuração do banco
    require_once 'config/database.php';

    $database = new Database();
    $pdo = $database->getConnection();
    
    if (!$pdo) {
        throw new Exception("Falha na conexão com o banco de dados");
    }

    // Ler o arquivo SQL
    $sqlFile = 'learnxpert_database.sql';
    if (!file_exists($sqlFile)) {
        throw new Exception("Arquivo SQL não encontrado: $sqlFile");
    }

    $sql = file_get_contents($sqlFile);
    if ($sql === false) {
        throw new Exception("Erro ao ler o arquivo SQL");
    }

    // Dividir o SQL em comandos individuais
    $commands = explode(';', $sql);
    $executedCommands = 0;
    $errors = [];

    // Executar cada comando
    foreach ($commands as $command) {
        $command = trim($command);
        
        // Pular comandos vazios e comentários
        if (empty($command) || strpos($command, '--') === 0) {
            continue;
        }

        try {
            $pdo->exec($command);
            $executedCommands++;
        } catch (PDOException $e) {
            // Ignorar alguns erros esperados
            $errorMsg = $e->getMessage();
            if (strpos($errorMsg, 'already exists') === false && 
                strpos($errorMsg, 'Duplicate entry') === false) {
                $errors[] = "Comando: " . substr($command, 0, 50) . "... - Erro: " . $errorMsg;
            }
        }
    }

    // Verificar se as escolas foram criadas
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM escolas");
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    $totalEscolas = $resultado['total'];

    // Verificar se as matrículas foram criadas
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM matriculas");
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    $totalMatriculas = $resultado['total'];

    // Verificar se os usuários foram criados
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM usuarios");
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    $totalUsuarios = $resultado['total'];

    $response = [
        'success' => true,
        'message' => 'Script SQL executado com sucesso!',
        'details' => [
            'comandos_executados' => $executedCommands,
            'total_escolas' => $totalEscolas,
            'total_matriculas' => $totalMatriculas,
            'total_usuarios' => $totalUsuarios,
            'erros' => $errors
        ]
    ];

    // Se não temos escolas suficientes, algo deu errado
    if ($totalEscolas < 3) {
        $response['success'] = false;
        $response['message'] = 'Script executado, mas poucas escolas foram criadas. Verifique o banco manualmente.';
    }

    echo json_encode($response, JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Erro ao executar script SQL: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
?>