# Using SendGrid SMTP (Port 2525) with iSUMBONG

Your server blocks outbound 587/465, but port 2525 is open. SendGrid supports SMTP on 2525, so you can send emails without changing any PHP code—just update `.env`.

## Steps

1. Create a SendGrid account: https://sendgrid.com/
2. Verify a sender:
   - Fast: Single Sender Verification (Settings → Sender Authentication → Single Sender) — use the same email as `FROM_EMAIL`.
   - Best: Domain Authentication — add the provided CNAME DNS records at your DNS host. This improves deliverability and DMARC alignment.
3. Create an API Key:
   - Settings → API Keys → Create API Key (Mail Send or Full Access).
   - Copy the key (starts with `SG.`).
4. Configure `.env` (see `.env.sendgrid.example`):

```
SMTP_HOST=smtp.sendgrid.net
SMTP_PORT=2525
SMTP_ENCRYPTION=tls
SMTP_USERNAME=apikey
SMTP_PASSWORD=SG.your-api-key
FROM_EMAIL=no-reply@yourdomain.com
FROM_NAME=iSUMBONG System
SMTP_FORCE_IPV4=1
SMTP_DEBUG_LOG=1
```

5. Reload PHP-FPM:

```
sudo systemctl restart php8.1-fpm
```

6. Test:
- Open: `/test_gmail_smtp.php?debug=1&check=1` and send a test email
- Tail logs:

```
tail -f logs/mail.log
```

7. Turn off verbose logging:
- Set `SMTP_DEBUG_LOG=0` in `.env` and restart PHP-FPM.

## Notes
- Use a verified `FROM_EMAIL` (Single Sender or Domain Auth) or SendGrid may block/modify your messages.
- If you domain-authenticate, add the three CNAMEs SendGrid provides and wait for DNS to propagate.
- DMARC alignment is best when your from-domain is authenticated in SendGrid.
