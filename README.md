### configure .env
set slack webhook
```
SLACK_TICKET_NOTIFICATION_WEBHOOK=https://hooks.slack.com/services/.../.../...
```

### run migrations, seeders
```php artisan migrate```
```php artisan db:seed```

### up and running application
```composer run dev```

# setup telegram webhook
im using ngrok to export my localhost.
change https://8ddf7b0f6bb1.ngrok-free.app to your ngrok exposed url, 
or use any other tool
```
curl -X POST "https://api.telegram.org/bot1904724757:AAHe_L2jFe_ffQpGWX1mxOu7-PR5XIideAE/setWebhook" -d "url=https://8ddf7b0f6bb1.ngrok-free.app/webhook/telegram/123123"
```
# check webhook status
```
curl https://api.telegram.org/bot1904724757:AAHe_L2jFe_ffQpGWX1mxOu7-PR5XIideAE/getWebhookInfo
```

{"ok":true,"result":{"url":"https://8ddf7b0f6bb1.ngrok-free.app/webhook/telegram/123123","has_custom_certificate":false,"pending_update_count":0,"max_connections":40,"ip_address":"3.125.102.39"}}%   (base) shamshod@Shamshods-MacBook-Pro test-app % curl https://api.telegram.org/bot1904724757:AAHe_L2jFe_ffQpGWX1mxOu7-PR5XIideAE/getWebhookInfo
