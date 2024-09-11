client_id='1a6fd3a7fd774b1e9b09937d0ac27211'
client_secret='31a6ac6866f24c63af9e0caa4d20a003'

# Client Credential Flow
json=$(curl -X POST "https://accounts.spotify.com/api/token" \
     -H "Content-Type: application/x-www-form-urlencoded" \
     -d "grant_type=client_credentials&client_id=$client_id&client_secret=$client_secret")

token=$(echo $json | jq -r ".access_token")

# Now use bearer token to query information
curl --request GET \
  --url "https://api.spotify.com/v1/search?q=$1&type=artist" \
  --header "Authorization: Bearer $token"