from flask import Flask, request, jsonify
import re

app = Flask(__name__)

@app.after_request
def add_cors(response):
    response.headers['Access-Control-Allow-Origin'] = '*'
    response.headers['Access-Control-Allow-Methods'] = 'POST, OPTIONS'
    response.headers['Access-Control-Allow-Headers'] = 'Content-Type'
    return response

ORDERS = {
    "123": {"status": "Processing", "items": ["Test Mug"], "shipped_date": None},
    "456": {"status": "Shipped", "items": ["Test Mug", "Sticker Pack"], "shipped_date": "2024-06-15"},
}

@app.route("/chat", methods=["POST", "OPTIONS"])
def chat():
    if request.method == "OPTIONS": return "", 200
    data = request.json
    user_msg = data.get("message", "").strip().lower()
    if any(kw in user_msg for kw in ["refund", "cancel", "complaint", "lawyer", "angry", "supervisor"]):
        return jsonify({"reply": "I understand this needs personal attention. A support agent will contact you within 1 hour. Reference: #HANDOFF-" + user_msg[:10].replace(" ", "_").upper(), "handoff": True})
    order_match = re.search(r'#?(\d{3,})', user_msg)
    if order_match:
        order_id = order_match.group(1)
        if order_id in ORDERS:
            order = ORDERS[order_id]
            status = order["status"]
            reply = f"✅ Order #{order_id} shipped on {order['shipped_date']}. Track via USPS: 9400100000000000000000" if status == "Shipped" and order["shipped_date"] else f"📦 Order #{order_id} is currently: {status}. We'll email you when it ships!"
            return jsonify({"reply": reply, "handoff": False})
        return jsonify({"reply": f"❓ I don't see order #{order_id} in our staging system.", "handoff": False})
    return jsonify({"reply": "I can help with order tracking. Try: 'Where is order #123?'", "handoff": False})

if __name__ == "__main__":
    app.run(port=5000, debug=True)
