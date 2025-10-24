<?php
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificação do Banco - LearnXpert</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            color: #ffffff;
            line-height: 1.6;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(0, 255, 136, 0.3);
            border-radius: 15px;
            padding: 2rem;
        }

        .logo {
            text-align: center;
            font-size: 2.5rem;
            font-weight: bold;
            color: #00ff88;
            margin-bottom: 1rem;
        }

        .subtitle {
            text-align: center;
            font-size: 1.2rem;
            color: #cccccc;
            margin-bottom: 2rem;
        }

        .section {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid #00ff88;
        }

        .section h3 {
            color: #00ff88;
            margin-bottom: 1rem;
            font-size: 1.3rem;
        }

        .success {
            background: rgba(40, 167, 69, 0.1);
            border: 1px solid rgba(40, 167, 69, 0.3);
            border-radius: 8px;
            padding: 1rem;
            margin: 1rem 0;
            color: #28a745;
        }

        .error {
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid rgba(220, 53, 69, 0.3);
            border-radius: 8px;
            padding: 1rem;
            margin: 1rem 0;
            color: #dc3545;
        }

        .warning {
            background: rgba(255, 193, 7, 0.1);
            border: 1px solid rgba(255, 193, 7, 0.3);
            border-radius: 8px;
            padding: 1rem;
            margin: 1rem 0;
            color: #ffc107;
        }

        .code-block {
            background: #2d2d2d;
            border: 1px solid #444;
            border-radius: 8px;
            padding: 1rem;
            margin: 1rem 0;
            overflow-x: auto;
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
        }

        .btn {
            display: inline-block;
            background: linear-gradient(45deg, #00ff88, #00cc6a);
            color: #000;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            margin: 10px 5px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 255, 136, 0.3);
        }

        .btn-danger {
            background: linear-gradient(45deg, #dc3545, #c82333);
            color: #fff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
        }

        th, td {
            border: 1px solid #444;
            padding: 8px 12px;
            text-align: left;
        }

        th {
            background: rgba(0, 255, 136, 0.2);
            color: #00ff88;
        }

        tr:nth-child(even) {
            background: rgba(255, 255, 255, 0.05);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">LearnXpert</div>
        <div class="subtitle">🔍 Verificação do Estado do Banco de Dados</div>

        <?php
        // Incluir configuração do banco
        require_once 'config/database.php';

        try {
            $database = new Database();
            $pdo = $database->getConnection();
            
            if (!$pdo) {
                throw new Exception("Falha na conexão com o banco de dados");
            }

            echo '<div class="success">✅ Conexão com o banco estabelecida com sucesso!</div>';

            // Verificar se o banco learnxpert existe
            $stmt = $pdo->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = 'learnxpert'");
            $banco_existe = $stmt->fetch();

            if ($banco_existe) {
                echo '<div class="success">✅ Banco de dados "learnxpert" encontrado!</div>';
            } else {
                echo '<div class="error">❌ Banco de dados "learnxpert" não encontrado!</div>';
            }

            // Verificar tabelas
            echo '<div class="section">';
            echo '<h3>📊 Verificação das Tabelas</h3>';
            
            $tabelas = ['escolas', 'matriculas', 'usuarios'];
            $tabelas_existentes = [];
            
            foreach ($tabelas as $tabela) {
                try {
                    $stmt = $pdo->query("SELECT COUNT(*) as total FROM $tabela");
                    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
                    $total = $resultado['total'];
                    
                    echo "<div class='success'>✅ Tabela '$tabela': $total registros</div>";
                    $tabelas_existentes[] = $tabela;
                } catch (Exception $e) {
                    echo "<div class='error'>❌ Tabela '$tabela': Não encontrada ou erro - " . $e->getMessage() . "</div>";
                }
            }
            echo '</div>';

            // Verificar dados das escolas especificamente
            if (in_array('escolas', $tabelas_existentes)) {
                echo '<div class="section">';
                echo '<h3>🏫 Dados das Escolas</h3>';
                
                try {
                    $stmt = $pdo->query("SELECT id, nome, localizacao, ativo FROM escolas ORDER BY id");
                    $escolas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    if (count($escolas) > 0) {
                        echo "<div class='success'>✅ Encontradas " . count($escolas) . " escolas no banco:</div>";
                        echo '<table>';
                        echo '<tr><th>ID</th><th>Nome</th><th>Localização</th><th>Ativo</th></tr>';
                        
                        foreach ($escolas as $escola) {
                            $ativo = $escola['ativo'] ? 'Sim' : 'Não';
                            echo "<tr>";
                            echo "<td>{$escola['id']}</td>";
                            echo "<td>{$escola['nome']}</td>";
                            echo "<td>{$escola['localizacao']}</td>";
                            echo "<td>$ativo</td>";
                            echo "</tr>";
                        }
                        echo '</table>';
                    } else {
                        echo '<div class="warning">⚠️ Nenhuma escola encontrada no banco!</div>';
                        echo '<div class="error">❌ Problema: O banco está vazio. É necessário executar o script SQL completo.</div>';
                    }
                } catch (Exception $e) {
                    echo '<div class="error">❌ Erro ao consultar escolas: ' . $e->getMessage() . '</div>';
                }
                echo '</div>';
            }

            // Testar API de escolas
            echo '<div class="section">';
            echo '<h3>🔌 Teste da API de Escolas</h3>';
            
            try {
                $context = stream_context_create([
                    'http' => [
                        'timeout' => 10,
                        'ignore_errors' => true
                    ]
                ]);
                
                $api_response = file_get_contents('http://localhost:8000/api/escolas.php', false, $context);
                
                if ($api_response === false) {
                    echo "<div class='error'>❌ Falha ao conectar com a API</div>";
                } else {
                    $api_data = json_decode($api_response, true);
                    
                    if ($api_data && isset($api_data['success']) && $api_data['success']) {
                        $escolas = $api_data['data'] ?? [];
                        echo "<div class='success'>✅ API funcionando! Retornou " . count($escolas) . " escolas</div>";
                        echo "<p>Total no banco: " . ($api_data['total'] ?? 0) . "</p>";
                        
                        if (count($escolas) > 0) {
                            echo "<ul>";
                            foreach ($escolas as $escola) {
                                echo "<li><strong>" . htmlspecialchars($escola['nome']) . "</strong> - " . htmlspecialchars($escola['localizacao']) . "</li>";
                            }
                            echo "</ul>";
                        } else {
                            echo "<div class='warning'>⚠️ API retornou 0 escolas</div>";
                        }
                    } else {
                        echo "<div class='error'>❌ API retornou erro:</div>";
                        echo "<pre>" . htmlspecialchars($api_response) . "</pre>";
                    }
                }
            } catch (Exception $e) {
                echo "<div class='error'>❌ Erro ao testar API: " . $e->getMessage() . "</div>";
            }
            echo '</div>';

            // Verificar se precisa executar o script SQL
            if (count($escolas) <= 1) {
                echo '<div class="section">';
                echo '<h3>🔧 Ação Necessária</h3>';
                echo '<div class="warning">⚠️ Detectado que o banco não tem dados suficientes!</div>';
                echo '<p>É necessário executar o script SQL completo para popular o banco com dados de exemplo.</p>';
                echo '<div style="text-align: center; margin: 2rem 0;">';
                echo '<button class="btn" onclick="executarSQL()">🚀 Executar Script SQL Completo</button>';
                echo '<a href="http://localhost/phpmyadmin" target="_blank" class="btn">🗄️ Abrir phpMyAdmin</a>';
                echo '</div>';
                echo '</div>';
            }

        } catch (Exception $e) {
            echo '<div class="error">❌ Erro geral: ' . $e->getMessage() . '</div>';
        }
        ?>

        <div class="section">
            <h3>🔗 Links Úteis</h3>
            <div style="text-align: center;">
                <a href="admin_escolas.html" class="btn">🏫 Admin Escolas</a>
                <a href="debug_api.php" class="btn">🐛 Debug API</a>
                <a href="guia_phpmyadmin.html" class="btn">📖 Guia phpMyAdmin</a>
                <a href="index.html" class="btn">🏠 Página Inicial</a>
            </div>
        </div>
    </div>

    <script>
        function executarSQL() {
            if (confirm('Isso irá recriar o banco com dados de exemplo. Continuar?')) {
                fetch('executar_sql.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('✅ Script SQL executado com sucesso!');
                        location.reload();
                    } else {
                        alert('❌ Erro: ' + data.message);
                    }
                })
                .catch(error => {
                    alert('❌ Erro ao executar script: ' + error);
                });
            }
        }
    </script>
</body>
</html>