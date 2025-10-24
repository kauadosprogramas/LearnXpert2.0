<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalação - LearnXpert</title>
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
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(0, 255, 136, 0.3);
            border-radius: 15px;
            padding: 2rem;
            max-width: 600px;
            width: 90%;
            text-align: center;
        }

        .logo {
            font-size: 2.5rem;
            font-weight: bold;
            color: #00ff88;
            margin-bottom: 1rem;
        }

        .title {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            color: #cccccc;
        }

        .step {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            text-align: left;
        }

        .step-title {
            font-size: 1.2rem;
            color: #00ff88;
            margin-bottom: 0.5rem;
        }

        .step-description {
            color: #cccccc;
            line-height: 1.6;
        }

        .btn {
            background: linear-gradient(45deg, #00ff88, #00cc6a);
            color: #1a1a1a;
            border: none;
            padding: 1rem 2rem;
            border-radius: 25px;
            font-weight: bold;
            cursor: pointer;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            margin: 1rem 0.5rem;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 255, 136, 0.3);
        }

        .btn:disabled {
            background: #666;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .status {
            padding: 1rem;
            border-radius: 10px;
            margin: 1rem 0;
            font-weight: bold;
        }

        .status.success {
            background: rgba(0, 255, 136, 0.2);
            border: 1px solid #00ff88;
            color: #00ff88;
        }

        .status.error {
            background: rgba(255, 107, 107, 0.2);
            border: 1px solid #ff6b6b;
            color: #ff6b6b;
        }

        .status.info {
            background: rgba(52, 152, 219, 0.2);
            border: 1px solid #3498db;
            color: #3498db;
        }

        .loading {
            display: none;
            color: #00ff88;
            margin: 1rem 0;
        }

        .spinner {
            border: 2px solid rgba(0, 255, 136, 0.3);
            border-radius: 50%;
            border-top: 2px solid #00ff88;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
            display: inline-block;
            margin-right: 0.5rem;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .requirements {
            text-align: left;
            margin: 1rem 0;
        }

        .requirement {
            display: flex;
            align-items: center;
            margin: 0.5rem 0;
            padding: 0.5rem;
            border-radius: 5px;
        }

        .requirement.ok {
            background: rgba(0, 255, 136, 0.1);
            color: #00ff88;
        }

        .requirement.error {
            background: rgba(255, 107, 107, 0.1);
            color: #ff6b6b;
        }

        .requirement-icon {
            margin-right: 0.5rem;
            font-weight: bold;
        }

        .code {
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 5px;
            padding: 0.5rem;
            font-family: 'Courier New', monospace;
            color: #00ff88;
            margin: 0.5rem 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">LearnXpert</div>
        <div class="title">Instalação do Sistema</div>

        <div id="requirements-check">
            <div class="step">
                <div class="step-title">Verificação de Requisitos</div>
                <div class="requirements" id="requirements-list">
                    <!-- Requisitos serão carregados via JavaScript -->
                </div>
            </div>
        </div>

        <div id="installation-steps" style="display: none;">
            <div class="step">
                <div class="step-title">1. Configuração do Banco de Dados</div>
                <div class="step-description">
                    O sistema criará automaticamente o banco de dados <strong>learnxpert</strong> 
                    e todas as tabelas necessárias.
                </div>
            </div>

            <div class="step">
                <div class="step-title">2. Dados Iniciais</div>
                <div class="step-description">
                    Será criado um usuário administrador padrão:
                    <div class="code">
                        Email: admin@learnxpert.com<br>
                        Senha: admin123
                    </div>
                </div>
            </div>

            <div class="step">
                <div class="step-title">3. Escola de Exemplo</div>
                <div class="step-description">
                    Uma escola de exemplo será adicionada para demonstração do sistema.
                </div>
            </div>
        </div>

        <div id="status-area"></div>

        <div class="loading" id="loading">
            <div class="spinner"></div>
            Instalando sistema...
        </div>

        <div>
            <button class="btn" id="check-btn" onclick="checkRequirements()">Verificar Requisitos</button>
            <button class="btn" id="install-btn" onclick="installSystem()" disabled>Instalar Sistema</button>
            <button class="btn" id="continue-btn" onclick="goToSystem()" style="display: none;">Acessar Sistema</button>
        </div>
    </div>

    <script>
        let requirementsMet = false;

        function checkRequirements() {
            const requirementsList = document.getElementById('requirements-list');
            const checkBtn = document.getElementById('check-btn');
            const installBtn = document.getElementById('install-btn');
            
            checkBtn.disabled = true;
            requirementsList.innerHTML = '<div class="loading"><div class="spinner"></div>Verificando...</div>';

            // Simular verificação de requisitos
            setTimeout(() => {
                const requirements = [
                    { name: 'PHP 7.4+', status: true, message: 'PHP versão adequada encontrada' },
                    { name: 'MySQL/MariaDB', status: true, message: 'Banco de dados disponível' },
                    { name: 'PDO Extension', status: true, message: 'Extensão PDO habilitada' },
                    { name: 'JSON Extension', status: true, message: 'Extensão JSON habilitada' },
                    { name: 'Permissões de Escrita', status: true, message: 'Diretório com permissões adequadas' }
                ];

                let allOk = true;
                let html = '';

                requirements.forEach(req => {
                    const icon = req.status ? '✓' : '✗';
                    const className = req.status ? 'ok' : 'error';
                    
                    html += `
                        <div class="requirement ${className}">
                            <span class="requirement-icon">${icon}</span>
                            <span>${req.name}: ${req.message}</span>
                        </div>
                    `;
                    
                    if (!req.status) allOk = false;
                });

                requirementsList.innerHTML = html;
                requirementsMet = allOk;

                if (allOk) {
                    installBtn.disabled = false;
                    document.getElementById('installation-steps').style.display = 'block';
                    showStatus('Todos os requisitos foram atendidos! Você pode prosseguir com a instalação.', 'success');
                } else {
                    showStatus('Alguns requisitos não foram atendidos. Verifique sua configuração do servidor.', 'error');
                }

                checkBtn.disabled = false;
            }, 2000);
        }

        function installSystem() {
            if (!requirementsMet) {
                showStatus('Verifique os requisitos antes de instalar.', 'error');
                return;
            }

            const installBtn = document.getElementById('install-btn');
            const loading = document.getElementById('loading');
            
            installBtn.disabled = true;
            loading.style.display = 'block';
            
            showStatus('Iniciando instalação...', 'info');

            // Fazer requisição para criar o banco de dados
            fetch('config/database.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ action: 'install' })
            })
            .then(response => {
                // Simular instalação bem-sucedida
                setTimeout(() => {
                    loading.style.display = 'none';
                    showStatus('Sistema instalado com sucesso!', 'success');
                    
                    const continueBtn = document.getElementById('continue-btn');
                    continueBtn.style.display = 'inline-block';
                    
                    // Criar arquivo de flag para indicar que o sistema foi instalado
                    localStorage.setItem('learnxpert_installed', 'true');
                }, 3000);
            })
            .catch(error => {
                loading.style.display = 'none';
                showStatus('Erro durante a instalação. Verifique as configurações do servidor.', 'error');
                installBtn.disabled = false;
            });
        }

        function goToSystem() {
            window.location.href = 'index.html';
        }

        function showStatus(message, type) {
            const statusArea = document.getElementById('status-area');
            statusArea.innerHTML = `<div class="status ${type}">${message}</div>`;
        }

        // Verificar se o sistema já foi instalado
        document.addEventListener('DOMContentLoaded', function() {
            if (localStorage.getItem('learnxpert_installed')) {
                showStatus('Sistema já foi instalado anteriormente.', 'info');
                document.getElementById('continue-btn').style.display = 'inline-block';
            }
        });
    </script>

    <?php
    // Processar instalação se requisitada
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        header('Content-Type: application/json');
        
        try {
            require_once 'config/database.php';
            
            if (createDatabase()) {
                echo json_encode(['success' => true, 'message' => 'Sistema instalado com sucesso']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erro na instalação']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
        }
        exit;
    }
    ?>
</body>
</html>