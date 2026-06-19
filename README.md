#  WordPress Support Bot Prototype
> Lightweight, decoupled customer-support chatbot handling natural-language order tracking, semantic intent retrieval, and safe human-handoff fallbacks.

##  Features
- Semantic retrieval via FAISS + local embeddings
- Regex order extraction + deterministic WooCommerce lookup
- Automatic human handoff for high-intent queries
- 100% local AI (Ollama llama3.2 + 
omic-embed-text)

##  Quick Start
\\\Bash
ollama serve
cd backend && python -m venv venv && source venv/bin/activate
pip install -r requirements.txt && python app.py
\\\
Drop \wordpress-plugin/\ into \wp-content/plugins/\ and activate.

## API
\POST /chat\ → \{"message":"Where is order #456?"}\
Returns: \{"reply":"...","handoff":false}\

## Learning Outcome
Demonstrated how **WordPress extensibility enables rapid prototyping of customer-facing AI tools** without heavy plugin development. Decoupled AI logic via REST API for safe staging-to-production migration.
