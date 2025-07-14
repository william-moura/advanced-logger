# Advanced Logger for PHP | Registro Avançado em PHP

[![PHP Version](https://img.shields.io/badge/PHP-8.1%2B-blue.svg)](https://php.net)
[![PSR-3 Compliant](https://img.shields.io/badge/PSR--3-compliant-blueviolet.svg)](https://www.php-fig.org/psr/psr-3/)
[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

A lightweight, extensible logging library for PHP with multi-handler support.  
Uma biblioteca de registro (logging) leve e extensível para PHP com suporte a múltiplos handlers.

---

## 🌟 Features | Funcionalidades

- **Multiple Handlers**: Log to files, databases, Telegram, Discord, and more.  
  **Múltiplos Handlers**: Registre em arquivos, bancos de dados, Telegram, Discord, etc.
- **PSR-3 Compliance**: Compatible with any PSR-3 logger.  
  **Conformidade PSR-3**: Integrável com qualquer biblioteca PSR-3.
- **Custom Formatters**: JSON, plain text, and colored CLI output.  
  **Formatadores Personalizados**: JSON, texto simples e saída colorida (CLI).
- **Context Support**: Rich metadata (user ID, IP, exceptions).  
  **Suporte a Contexto**: Metadados avançados (ID do usuário, IP, exceções).

---

## 🚀 Installation | Instalação

```bash
composer require seu-nome/advanced-logger
```
## 📖 Basic Usage | Uso Básico
```
use AdvancedLogger\Logger;
use AdvancedLogger\Handlers\FileHandler;
use AdvancedLogger\Handlers\TelegramHandler;

$logger = new Logger([
    new FileHandler('/var/log/app.log'),
    new TelegramHandler('YOUR_TELEGRAM_BOT_TOKEN', 'CHAT_ID'),
]);

$logger->info('User logged in', ['user_id' => 42]);
$logger->error('Failed to connect to API', ['exception' => $e->getMessage()]);
```

## 🔧 Available Handlers | Handlers Disponíveis
### Handler	Description	Descrição
#### FileHandler	Logs to files (supports rotation).
```
| Registra em arquivos (com rotação). |
| TelegramHandler | Sends logs to Telegram.
| Envia logs para o Telegram. |
| DatabaseHandler | Stores logs in MySQL/PostgreSQL.
| Armazena logs em MySQL/PostgreSQL. |
| DiscordHandler | Posts logs to Discord webhooks.
| Envia logs para webhooks do Discord. |
```

## ⚙️ Advanced Configuration | Configuração Avançada
### Custom Formatter Example | Exemplo de Formatador Personalizado
```
use AdvancedLogger\Formatters\JsonFormatter;

$fileHandler = new FileHandler('/var/log/app.json');
$fileHandler->setFormatter(new JsonFormatter());
```
## 🤝 Contributing | Contribuição
1.Fork the project | Faça um fork do projeto

2.Create a branch: git checkout -b feat/awesome-feature
Crie uma branch: git checkout -b feat/nova-funcionalidade

3.Commit changes: git commit -m 'Add awesome feature'
Faça o commit: git commit -m 'Adiciona nova funcionalidade'

4.Push: git push origin feat/awesome-feature
Envie: git push origin feat/nova-funcionalidade

5.Open a Pull Request | Abra um Pull Request

## 📜 License | Licença
GPL-3.0 License - See LICENSE for details.

## 📬 Contact | Contato
Email: williammoura908@gmail.com

GitHub: [@william-moura](https://github.com/william-moura)

Issues: [Report a bug](https://github.com/william-moura/advanced-logger/issues)