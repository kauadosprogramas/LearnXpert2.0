# 🎓 LearnXpert

**Sistema de gestão educacional moderno para facilitar matrículas e administração de escolas**

> *Transformando a educação através da tecnologia - Um projeto desenvolvido com paixão por melhorar o acesso ao ensino*

## 🚀 Sobre o Projeto

O LearnXpert é uma plataforma web completa que digitaliza e simplifica o processo de matrícula escolar, eliminando burocracias e tornando a educação mais acessível para todos.

### ✨ Principais Funcionalidades

- **🏫 Gestão de Escolas**: Cadastro completo com upload de logos
- **📝 Sistema de Matrículas**: Processo online simplificado
- **🔐 Área Administrativa**: Painel seguro para gestão
- **📊 Dashboard Intuitivo**: Visualização clara de dados
- **🎨 Interface Moderna**: Design responsivo e acessível

## 🛠️ Tecnologias Utilizadas

- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Backend**: PHP 8.0+
- **Banco de Dados**: MySQL 8.0+
- **Servidor**: Apache/Nginx
- **Autenticação**: Sistema próprio com proteção avançada

## 📋 Pré-requisitos

- PHP 8.0 ou superior
- MySQL 8.0 ou superior
- Servidor web (Apache/Nginx) ou XAMPP
- Navegador moderno com suporte a ES6+

## 🔧 Instalação

### 1. Clone o repositório
```bash
git clone https://github.com/seu-usuario/learnxpert.git
cd learnxpert
```

### 2. Configure o banco de dados
```bash
# Acesse: http://localhost/learnxpert/install.php
# Ou execute o script de instalação
```

### 3. Configure as credenciais
Edite o arquivo `config/database.php` com suas configurações:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'learnxpert');
define('DB_USER', 'seu_usuario');
define('DB_PASS', 'sua_senha');
```

### 4. Execute a instalação
Acesse `http://localhost/learnxpert/install.php` no navegador

## 📖 Como Usar

### Para Administradores
1. Acesse `/conectar-se.html`
2. Use as credenciais padrão: `admin@learnxpert.com` / `admin123`
3. Gerencie escolas em `/admin_escolas.html`

### Para Usuários
1. Acesse a página inicial
2. Escolha uma escola
3. Preencha o formulário de matrícula
4. Acompanhe o status da solicitação

## 🗂️ Estrutura do Projeto

```
learnxpert/
├── 📁 api/                 # APIs REST
│   ├── escolas.php        # CRUD de escolas
│   └── matriculas.php     # CRUD de matrículas
├── 📁 config/             # Configurações
│   └── database.php       # Conexão com BD
├── 📁 js/                 # Scripts JavaScript
│   └── admin-auth.js      # Autenticação admin
├── 🏠 index.html          # Página inicial
├── 🏫 escola.html         # Página da escola
├── 📝 matricula.html      # Formulário de matrícula
├── 🔐 conectar-se.html    # Login administrativo
├── ⚙️ admin.html          # Dashboard admin
├── 🏫 admin_escolas.html  # Gestão de escolas
├── 🔧 install.php         # Instalação do sistema
└── 📚 README.md           # Este arquivo
```

## 🔒 Segurança

- **Autenticação robusta** com validação tripla
- **Proteção contra acesso direto** a páginas administrativas
- **Sanitização de dados** em todas as entradas
- **Prepared statements** para prevenir SQL injection
- **Monitoramento de sessão** em tempo real

## 🎨 Recursos Visuais

- **Design responsivo** para todos os dispositivos
- **Upload de logos** com preview instantâneo
- **Interface intuitiva** com feedback visual
- **Tema moderno** com gradientes e animações
- **Acessibilidade** seguindo padrões WCAG

## 🤝 Contribuindo

1. Faça um fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo `LICENSE` para mais detalhes.

## 👨‍💻 Desenvolvedor

**Kauã** - *Desenvolvedor Full Stack*
- Estudante universitário apaixonado por tecnologia educacional
- Missão: Melhorar o ensino através da inovação tecnológica

## 🙏 Agradecimentos

- À comunidade open source por inspirar este projeto
- Aos educadores que dedicam suas vidas ao ensino
- A todos que acreditam no poder transformador da educação

---

*"A educação é a arma mais poderosa que você pode usar para mudar o mundo." - Nelson Mandela*

**⭐ Se este projeto te ajudou, considere dar uma estrela!**

## 🚀 Funcionalidades

### Para Usuários
- **Página Principal**: Visualização de escolas parceiras com design moderno
- **Detalhes da Escola**: Informações completas sobre cada instituição
- **Sistema de Matrícula**: Formulário completo com validação em tempo real
- **Interface Responsiva**: Compatível com dispositivos móveis e desktop

### Para Administradores
- **Dashboard Administrativo**: Visão geral do sistema com estatísticas
- **Gerenciamento de Escolas**: CRUD completo para escolas parceiras
- **Controle de Matrículas**: Visualização e aprovação de matrículas
- **Sistema de Busca**: Filtros avançados para localizar informações

## 🛠️ Tecnologias Utilizadas

- **Frontend**: HTML5, CSS3, JavaScript (Vanilla)
- **Backend**: PHP 7.4+
- **Banco de Dados**: MySQL/MariaDB
- **Servidor**: Apache (XAMPP)
- **Design**: CSS Grid, Flexbox, Gradientes, Animações

## 📦 Estrutura do Projeto

```
learnxpert/
├── index.html              # Página principal
├── escola.html             # Página de detalhes da escola
├── matricula.html          # Formulário de matrícula
├── admin.html              # Dashboard administrativo
├── admin_escolas.html      # Gerenciamento de escolas
├── install.php             # Script de instalação
├── config/
│   └── database.php        # Configuração do banco de dados
├── api/
│   ├── escolas.php         # API para gerenciamento de escolas
│   └── matriculas.php      # API para gerenciamento de matrículas
└── README.md               # Documentação
```

## 🔧 Instalação

### Pré-requisitos
- XAMPP (Apache + MySQL + PHP 7.4+)
- Navegador web moderno
- 50MB de espaço em disco

### Passo a Passo

1. **Baixar e Instalar XAMPP**
   ```
   https://www.apachefriends.org/download.html
   ```

2. **Extrair o Projeto**
   - Extrair todos os arquivos para: `d:\Xampp\htdocs\learnxpert\`

3. **Iniciar Serviços**
   - Abrir XAMPP Control Panel
   - Iniciar Apache e MySQL

4. **Executar Instalação**
   - Acessar: `http://localhost/learnxpert/install.php`
   - Seguir as instruções na tela
   - Aguardar a criação automática do banco de dados

5. **Acessar o Sistema**
   - Site Principal: `http://localhost/learnxpert/`
   - Área Administrativa: `http://localhost/learnxpert/admin.html`

## 🗄️ Banco de Dados

### Tabelas Criadas Automaticamente

#### `escolas`
- `id` - Identificador único
- `nome` - Nome da escola
- `logo` - Iniciais para logo
- `localizacao` - Cidade/região
- `endereco` - Endereço completo
- `telefone` - Telefone de contato
- `email` - Email de contato
- `niveis_ensino` - Níveis oferecidos (JSON)
- `descricao` - Descrição da escola
- `ativo` - Status ativo/inativo
- `data_criacao` - Data de criação
- `data_atualizacao` - Data da última atualização

#### `matriculas`
- `id` - Identificador único
- `escola_id` - Referência à escola
- `nome_aluno` - Nome do aluno
- `data_nascimento` - Data de nascimento
- `cpf` - CPF do aluno
- `rg` - RG do aluno
- `nome_responsavel` - Nome do responsável
- `cpf_responsavel` - CPF do responsável
- `telefone` - Telefone de contato
- `email` - Email de contato
- `endereco` - Endereço completo
- `nivel_ensino` - Nível de ensino desejado
- `turno` - Turno preferido
- `observacoes` - Observações adicionais
- `status` - Status da matrícula (pendente/aprovada/rejeitada)
- `data_matricula` - Data da matrícula

#### `usuarios`
- `id` - Identificador único
- `nome` - Nome do usuário
- `email` - Email de login
- `senha` - Senha criptografada
- `tipo` - Tipo de usuário (admin/escola)
- `escola_id` - Referência à escola (se aplicável)
- `ativo` - Status ativo/inativo
- `data_criacao` - Data de criação

## 🔐 Credenciais Padrão

### Administrador
- **Email**: admin@learnxpert.com
- **Senha**: admin123

## 📡 API Endpoints

### Escolas (`/api/escolas.php`)
- `GET /api/escolas.php` - Listar escolas
- `GET /api/escolas.php/{id}` - Buscar escola específica
- `POST /api/escolas.php` - Criar nova escola
- `PUT /api/escolas.php/{id}` - Atualizar escola
- `DELETE /api/escolas.php/{id}` - Excluir escola

### Matrículas (`/api/matriculas.php`)
- `GET /api/matriculas.php` - Listar matrículas
- `GET /api/matriculas.php/{id}` - Buscar matrícula específica
- `POST /api/matriculas.php` - Criar nova matrícula
- `PUT /api/matriculas.php/{id}` - Atualizar matrícula
- `DELETE /api/matriculas.php/{id}` - Excluir matrícula

### Parâmetros de Busca
- `search` - Termo de busca
- `limit` - Limite de resultados (padrão: 50)
- `offset` - Offset para paginação
- `status` - Filtrar por status (apenas matrículas)
- `escola_id` - Filtrar por escola

## 🎨 Características do Design

### Paleta de Cores
- **Primária**: #00ff88 (Verde neon)
- **Secundária**: #1a1a1a (Preto)
- **Fundo**: Gradiente escuro (#1a1a1a → #2d2d2d)
- **Texto**: #ffffff (Branco) / #cccccc (Cinza claro)

### Elementos Visuais
- **Gradientes**: Fundos com transições suaves
- **Bordas**: Bordas arredondadas (border-radius)
- **Sombras**: Box-shadow para profundidade
- **Animações**: Transições suaves em hover
- **Responsividade**: Design adaptável para mobile

### Componentes
- **Cards**: Elementos com fundo translúcido
- **Botões**: Estilo moderno com efeitos hover
- **Formulários**: Campos com validação visual
- **Modais**: Sobreposições com backdrop blur
- **Tabelas**: Design limpo com hover effects

## 🔧 Configuração Avançada

### Personalizar Banco de Dados
Editar `config/database.php`:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'learnxpert');
define('DB_USER', 'root');
define('DB_PASS', '');
```

### Configurar Email (Futuro)
Para implementar envio real de emails, integrar com:
- PHPMailer
- SwiftMailer
- SendGrid API

### Backup do Banco
```sql
mysqldump -u root -p learnxpert > backup_learnxpert.sql
```

### Restaurar Backup
```sql
mysql -u root -p learnxpert < backup_learnxpert.sql
```

## 🐛 Solução de Problemas

### Erro de Conexão com Banco
1. Verificar se MySQL está rodando no XAMPP
2. Confirmar credenciais em `config/database.php`
3. Verificar se o banco `learnxpert` foi criado

### Página em Branco
1. Verificar se Apache está rodando
2. Confirmar se os arquivos estão em `htdocs/learnxpert/`
3. Verificar logs de erro do Apache

### Formulário Não Funciona
1. Verificar se as APIs estão acessíveis
2. Confirmar se o JavaScript está habilitado
3. Verificar console do navegador para erros

## 📱 Compatibilidade

### Navegadores Suportados
- Chrome 80+
- Firefox 75+
- Safari 13+
- Edge 80+

### Dispositivos
- Desktop (1920x1080+)
- Tablet (768x1024)
- Mobile (375x667+)

## 🚀 Melhorias Futuras

### Funcionalidades Planejadas
- [ ] Sistema de autenticação completo
- [ ] Dashboard com gráficos e relatórios
- [ ] Notificações por email
- [ ] Upload de documentos
- [ ] Sistema de mensagens
- [ ] Integração com APIs de pagamento
- [ ] Aplicativo mobile
- [ ] Sistema de notas e frequência

### Otimizações Técnicas
- [ ] Cache de dados
- [ ] Compressão de assets
- [ ] CDN para recursos estáticos
- [ ] Otimização de consultas SQL
- [ ] Implementação de testes automatizados

## 📄 Licença

Este projeto é desenvolvido para fins educacionais e demonstrativos. Todos os direitos reservados.

## 👥 Suporte

Para suporte técnico ou dúvidas sobre o sistema:
- Email: suporte@learnxpert.com
- Documentação: Consulte este README
- Issues: Reporte problemas através do sistema de controle de versão

---

**LearnXpert** - Transformando a gestão educacional com tecnologia moderna! 🎓✨