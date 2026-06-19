# AI-Support-Bot-
AI-Support-Bot-
# 🤖 WordPress Support Bot Prototype

> A lightweight, decoupled customer-support chatbot that handles natural-language order tracking, semantic intent retrieval, and safe human-handoff fallbacks. Built to demonstrate how WordPress extensibility enables rapid AI prototyping.

[![Python](https://img.shields.io/badge/Python-3.10%2B-blue)](https://www.python.org/)
[![LangChain](https://img.shields.io/badge/LangChain-1.0%2B-orange)](https://www.langchain.com/)
[![Ollama](https://img.shields.io/badge/Ollama-Local-green)](https://ollama.com/)
[![WordPress](https://img.shields.io/badge/WordPress-Plugin-21759B)](https://developer.wordpress.org/)
[![License](https://img.shields.io/badge/License-MIT-yellow.svg)](LICENSE)

## 🎯 Problem & Solution
WooCommerce stores receive hundreds of repetitive order-status queries daily. Traditional chatbots fail on natural phrasing and lack safe escalation paths. This prototype:
- ✅ Understands real customer phrasing via semantic retrieval (FAISS + local embeddings)
- ✅ Resolves order IDs contextually without rigid keyword matching
- ✅ Automatically hands off high-intent queries (refunds, complaints, legal)
- ✅ Runs 100% locally with zero API costs (Ollama `llama3.2` + `nomic-embed-text`)

## 🏗️ Architecture
[Browser/WordPress] → HTTP POST /chat → [Flask Backend]
↓
┌──────────────┴──────────────┐
│ 1. Intent Classifier │
│ 2. Order ID Regex Extractor│
│ 3. FAISS Vector Store │
│ 4. Ollama LLM Fallback │
└──────────────┬──────────────┘
↓
[Mock WooCommerce Order DB] → JSON Response


## 🛠️ Quick Start

### Prerequisites
- Python 3.10+
- [Ollama](https://ollama.com/) installed & running (`ollama serve`)
- Local WordPress + WooCommerce (LocalWP recommended)

### 1. Backend Setup 
```bash
cd backend
python -m venv venv
# Windows:
venv\Scripts\activate
# macOS/Linux:
source venv/bin/activate

pip install -r requirements.txt
python app.py  # Runs on http://localhost:5000
```
### 2. WordPress Plugin
Copy wordpress-plugin/ into wp-content/plugins/
Activate WP Support Bot Prototype in WP Admin
Chat bubble appears on frontend → auto-connects to localhost:5000
📡 API Contract
Endpoint: POST /chat
Request:
{ "message": "Where is order #456?" }
Response: 
{
  "reply": "✅ Order #456 shipped on 2024-06-15. Track via USPS: 9400100000000000000000",
  "handoff": false
}

Hand off response: 
{
  "reply": "I understand this needs personal attention... Reference: #HANDOFF-I_WANT_A_",
  "handoff": true
}
