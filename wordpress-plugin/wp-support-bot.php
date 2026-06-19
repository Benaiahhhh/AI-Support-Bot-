<?php
/**
 * Plugin Name: WP Support Bot Prototype
 * Description: Chat widget connecting to local Flask backend for order tracking (LangChain prototype)
 * Version: 1.0
 * Author: Your Name
 */
if (!defined('ABSPATH')) exit;

function wp_support_bot_widget() {
?>
<div id="wp-support-bot" style="position:fixed;bottom:20px;right:20px;z-index:9999;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;">
    <button id="wp-support-bot-toggle" style="background:#0073aa;color:#fff;border:none;border-radius:50%;width:60px;height:60px;font-size:24px;cursor:pointer;box-shadow:0 4px 12px rgba(0,0,0,0.15);">💬</button>
    <div id="wp-support-bot-window" style="display:none;position:absolute;bottom:70px;right:0;width:320px;max-height:400px;background:#fff;border:1px solid #ddd;border-radius:8px;box-shadow:0 4px 20px rgba(0,0,0,0.2);flex-direction:column;overflow:hidden;">
        <div style="background:#0073aa;color:#fff;padding:12px;font-weight:600;">Support Bot</div>
        <div id="wp-support-bot-messages" style="flex:1;padding:12px;overflow-y:auto;max-height:250px;font-size:14px;"></div>
        <div style="padding:8px;border-top:1px solid #eee;display:flex;gap:8px;">
            <input id="wp-support-bot-input" type="text" placeholder="Ask about your order..." style="flex:1;padding:8px;border:1px solid #ddd;border-radius:4px;font-size:14px;">
            <button id="wp-support-bot-send" style="background:#0073aa;color:#fff;border:none;padding:8px 12px;border-radius:4px;cursor:pointer;">Send</button>
        </div>
    </div>
</div>
<script>
(function() {
    var toggle = document.getElementById('wp-support-bot-toggle');
    var chatWin = document.getElementById('wp-support-bot-window');
    var messages = document.getElementById('wp-support-bot-messages');
    var input = document.getElementById('wp-support-bot-input');
    var send = document.getElementById('wp-support-bot-send');

    toggle.onclick = function() {
        chatWin.style.display = (chatWin.style.display === 'none') ? 'flex' : 'none';
        if (chatWin.style.display === 'flex') input.focus();
    };

    async function sendMessage() {
        var msg = input.value.trim();
        if (!msg) return;
        messages.innerHTML += '<div style="margin:4px 0;text-align:right;"><strong>You:</strong> ' + msg + '</div>';
        input.value = '';
        messages.scrollTop = messages.scrollHeight;

        var typing = document.createElement('div');
        typing.id = 'bot-typing';
        typing.innerHTML = '<em>Bot is typing...</em>';
        messages.appendChild(typing);
        messages.scrollTop = messages.scrollHeight;

        try {
            var res = await fetch('http://localhost:5000/chat', {
                method: 'POST', headers: {'Content-Type': 'application/json'}, body: JSON.stringify({message: msg})
            });
            var data = await res.json();
            document.getElementById('bot-typing').remove();
            var div = document.createElement('div');
            div.innerHTML = '<strong>Bot:</strong> ' + data.reply;
            if (data.handoff) { div.style.background='#fff3cd'; div.style.padding='8px'; div.style.borderRadius='4px'; }
            messages.appendChild(div);
            messages.scrollTop = messages.scrollHeight;
        } catch(e) {
            document.getElementById('bot-typing').remove();
            messages.innerHTML += '<div style="margin:4px 0;color:#dc3232;"><strong>Bot:</strong> ⚠️ Connection error. Is backend running?</div>';
        }
    }
    send.onclick = sendMessage;
    input.onkeypress = function(e) { if (e.key === 'Enter') sendMessage(); };
})();
</script>
<?php } add_action('wp_footer', 'wp_support_bot_widget');
