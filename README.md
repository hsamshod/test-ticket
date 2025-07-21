## Configure .env
1/ configure slack webhook:
- create an app
- add it to channel in incoming webhooks section
- copy webhook url

example:
```
SLACK_BOT_WEBHOOK_TOKEN=https://hooks.slack.com/services/.../.../...
```

2/ configure telegram bot:
- bot token
- webhook secret
example:
```
TELEGRAM_BOT_TOKEN=1904724757:AAHe_L2jFe_ffQpGWX1mxOu7-PR5XIideAE
TELEGRAM_BOT_WEBHOOK_SECRET=123123
```

3/ Setup telegram webhook.
i'm using ngrok to expose my localhost.
change https://8ddf7b0f6bb1.ngrok-free.app to your ngrok exposed url,
123123 to desired secret.
or use any other tool
```
curl -X POST "https://api.telegram.org/bot[BOT TOKEN]/setWebhook" -d "url=https://8ddf7b0f6bb1.ngrok-free.app/webhook/telegram/123123"
```
# check webhook status
```
curl https://api.telegram.org/bot[BOT TOKEN]/getWebhookInfo
```
and check if it was set successfully
```
{"ok":true,"result":{"url":"https://8ddf7b0f6bb1.ngrok-free.app/webhook/telegram/123123","has_custom_certificate":false,"pending_update_count":0,"max_connections":40,"ip_address":"3.125.102.39"}}%   (base) shamshod@Shamshods-MacBook-Pro test-app % curl https://api.telegram.org/bot1904724757:AAHe_L2jFe_ffQpGWX1mxOu7-PR5XIideAE/getWebhookInfo
```

## Run migrations, seeders
```php artisan migrate```
```php artisan db:seed```

## Up and running application
```composer run dev```
