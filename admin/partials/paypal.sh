curl -v -X POST https://api-m.sandbox.paypal.com/v1/payments/payouts \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer $1" \
  -d '{
  "sender_batch_header": {
    "sender_batch_id": "Payouts_'$4'",
    "recipient_type": "EMAIL",
    "email_subject": "You have money!",
    "email_message": "You received a payment. Thanks for using our service!"
  },
  "items": [
    {
      "amount": {
        "value": "'$3'",
        "currency": "CAD"
      },
      "note":"Thanks You!",
      "sender_item_id":"'$4'",
      "receiver": "'$2'"
    }
  ]
}'

echo $1

echo $2

echo $3

echo $4