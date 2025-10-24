<?php
// Script para atualizar a tabela escolas com colunas de estado e cidade
header('Content-Type: application/json; charset=utf-8');

try {
    require_once 'config/database.php';
    
    $database = new Database();
    $conn = $database->getConnection();
    
    if (!$conn) {
        throw new Exception("Erro de conexão com o banco de dados");
    }
    
    echo "Conectado ao banco de dados...\n";
    
    // Verificar se as colunas já existem
    $stmt = $conn->prepare("SHOW COLUMNS FROM escolas LIKE 'estado'");
    $stmt->execute();
    $estadoExists = $stmt->fetch();
    
    $stmt = $conn->prepare("SHOW COLUMNS FROM escolas LIKE 'cidade'");
    $stmt->execute();
    $cidadeExists = $stmt->fetch();
    
    if (!$estadoExists) {
        // Adicionar coluna estado
        $sql = "ALTER TABLE escolas ADD COLUMN estado VARCHAR(2) NULL AFTER localizacao";
        $conn->exec($sql);
        echo "Coluna 'estado' adicionada com sucesso!\n";
    } else {
        echo "Coluna 'estado' já existe.\n";
    }
    
    if (!$cidadeExists) {
        // Adicionar coluna cidade
        $sql = "ALTER TABLE escolas ADD COLUMN cidade VARCHAR(255) NULL AFTER estado";
        $conn->exec($sql);
        echo "Coluna 'cidade' adicionada com sucesso!\n";
    } else {
        echo "Coluna 'cidade' já existe.\n";
    }
    
    // Migrar dados existentes da coluna localizacao para cidade (assumindo que localizacao contém a cidade)
    if (!$estadoExists || !$cidadeExists) {
        $stmt = $conn->prepare("SELECT id, localizacao FROM escolas WHERE (estado IS NULL OR cidade IS NULL) AND localizacao IS NOT NULL");
        $stmt->execute();
        $escolas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($escolas as $escola) {
            // Por padrão, assumir que a localização atual é a cidade e o estado é SC (Santa Catarina)
            $updateStmt = $conn->prepare("UPDATE escolas SET estado = 'SC', cidade = ? WHERE id = ?");
            $updateStmt->execute([$escola['localizacao'], $escola['id']]);
        }
        
        echo "Dados migrados: " . count($escolas) . " escolas atualizadas.\n";
    }
    
    echo "Atualização da tabela concluída com sucesso!\n";
    
    // Verificar estrutura final
    $stmt = $conn->prepare("DESCRIBE escolas");
    $stmt->execute();
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "\nEstrutura atual da tabela escolas:\n";
    foreach ($columns as $column) {
        echo "- " . $column['Field'] . " (" . $column['Type'] . ")\n";
    }
    
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n";
}
?>