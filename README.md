
# 🤖 WordPress Support Bot Prototype

> Lightweight, decoupled customer-support chatbot handling natural-language order tracking, semantic intent retrieval, and safe human-handoff fallbacks.

[![Python](https://img.shields.io/badge/Python-3.10%2B-blue)](https://www.python.org/)
[![LangChain](https://img.shields.io/badge/LangChain-1.0%2B-orange)](https://www.langchain.com/)
[![Ollama](https://img.shields.io/badge/Ollama-Local-green)](https://ollama.com/)

## 🚀 Features
- ✅ Semantic retrieval via FAISS + local embeddings
- ✅ Regex order extraction + deterministic WooCommerce lookup
- ✅ Automatic human handoff for high-intent queries (refunds, complaints)
- ✅ 100% local AI (Ollama `llama3.2` + `nomic-embed-text`) — zero API costs, PII stays on machine

## 🛠️ Quick Start

```bash
# 1. Start local AI
ollama serve

# 2. Run Flask backend
cd backend
python -m venv venv
venv\Scripts\activate  # Windows
pip install -r requirements.txt
python app.py  # Runs on http://localhost:5000

# 3. Activate WordPress plugin
Drop wordpress-plugin/ into wp-content/plugins/ and activate in WP Admin
```

## 📡 API Contract
```json
POST /chat
Request:  { "message": "Where is order #456?" }
Response: { "reply": "✅ Order #456 shipped...", "handoff": false }
```

## 🎓 Learning Outcome
Demonstrated how **WordPress extensibility enables rapid prototyping of customer-facing AI tools** without heavy plugin development. Decoupled AI logic via REST API for safe staging-to-production migration.

## 🔗 Repo Structure
```
wp-support-bot-repo/
├── backend/
│   ├── app.py           # Flask + routing + handoff logic
│   ├── .env             # Model config (gitignored in prod)
│   └── requirements.txt # Python deps
├── wordpress-plugin/
│   └── wp-support-bot.php # Lightweight WP plugin (injects chat UI)
├── README.md
├── LICENSE
└── .gitignore
```
