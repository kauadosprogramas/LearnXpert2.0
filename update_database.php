<?php
require_once 'config/database.php';

echo "<!DOCTYPE html>
<html lang='pt-BR'>
<head>
    <meta charset='UTF-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualização do Banco - LearnXpert</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; }
        .success { color: #28a745; background: #d4edda; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .error { color: #dc3545; background: #f8d7da; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .info { color: #0c5460; background: #d1ecf1; padding: 10px; border-radius: 5px; margin: 10px 0; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🔄 Atualização do Banco de Dados - LearnXpert</h1>";

try {
    $database = new Database();
    $pdo = $database->getConnection();
    
    if (!$pdo) {
        throw new Exception("Erro ao conectar com o banco de dados");
    }
    
    echo "<div class='info'>✅ Conexão com banco estabelecida com sucesso!</div>";
    
    // Verificar se a coluna logo_tipo já existe
    $stmt = $pdo->query("SHOW COLUMNS FROM escolas LIKE 'logo_tipo'");
    $column_exists = $stmt->rowCount() > 0;
    
    if (!$column_exists) {
        echo "<div class='info'>🔧 Adicionando nova coluna 'logo_tipo' na tabela escolas...</div>";
        
        // Adicionar coluna logo_tipo
        $sql = "ALTER TABLE escolas ADD COLUMN logo_tipo ENUM('iniciais', 'imagem') DEFAULT 'iniciais' AFTER logo";
        $pdo->exec($sql);
        
        echo "<div class='success'>✅ Coluna 'logo_tipo' adicionada com sucesso!</div>";
        
        // Modificar coluna logo para aceitar URLs maiores
        echo "<div class='info'>🔧 Modificando coluna 'logo' para aceitar URLs de imagem...</div>";
        
        $sql = "ALTER TABLE escolas MODIFY COLUMN logo VARCHAR(500) NULL";
        $pdo->exec($sql);
        
        echo "<div class='success'>✅ Coluna 'logo' modificada com sucesso!</div>";
        
        // Atualizar registros existentes para definir logo_tipo como 'iniciais'
        echo "<div class='info'>🔧 Atualizando registros existentes...</div>";
        
        $sql = "UPDATE escolas SET logo_tipo = 'iniciais' WHERE logo_tipo IS NULL OR logo_tipo = ''";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        
        $affected_rows = $stmt->rowCount();
        echo "<div class='success'>✅ $affected_rows registros atualizados com sucesso!</div>";
        
    } else {
        echo "<div class='info'>ℹ️ Estrutura do banco já está atualizada!</div>";
    }
    
    // Verificar estrutura final
    echo "<div class='info'>📋 Verificando estrutura final da tabela escolas:</div>";
    
    $stmt = $pdo->query("DESCRIBE escolas");
    $columns = $stmt->fetchAll();
    
    echo "<table border='1' style='width: 100%; border-collapse: collapse; margin: 10px 0;'>";
    echo "<tr style='background: #f8f9fa;'><th>Campo</th><th>Tipo</th><th>Nulo</th><th>Padrão</th></tr>";
    
    foreach ($columns as $column) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($column['Field']) . "</td>";
        echo "<td>" . htmlspecialchars($column['Type']) . "</td>";
        echo "<td>" . htmlspecialchars($column['Null']) . "</td>";
        echo "<td>" . htmlspecialchars($column['Default'] ?? 'NULL') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<div class='success'>🎉 Atualização do banco de dados concluída com sucesso!</div>";
    echo "<div class='info'>💡 Agora o sistema suporta tanto logos com iniciais quanto upload de imagens!</div>";
    
} catch (Exception $e) {
    echo "<div class='error'>❌ Erro durante a atualização: " . htmlspecialchars($e->getMessage()) . "</div>";
}

echo "
        <div style='margin-top: 20px; text-align: center;'>
            <a href='admin_escolas.html' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>
                🏫 Ir para Administração de Escolas
            </a>
            <a href='index.html' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-left: 10px;'>
                🏠 Voltar ao Início
            </a>
        </div>
    </div>
</body>
</html>";
?>