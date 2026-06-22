CLIENT_ID="1a6fd3a7fd774b1e9b09937d0ac27211"
CLIENT_SECRET="31a6ac6866f24c63af9e0caa4d20a003"

# 2. Request the Bearer token from Spotify's accounts API
RESPONSE=$(curl -s -X POST "https://accounts.spotify.com/api/token" \
     -H "Authorization: Basic $CLIENT_ID:$CLIENT_SECRET"\
     -d "grant_type=client_credentials")

# 3. Extract the token value from the JSON response
BEARER_TOKEN=$(echo "$RESPONSE" | jq -r 'access_token')

# 4. Check if the token was successfully generated
if [ $BEARER_TOKEN = "null" ]; then
    echo "Error: Failed to fetch token. Verify your Client ID and Secret."
    echo "Server response: $RESPONSE"
    exit 1
fi

# 5. Output the token
echo "Your Bearer Token:"
echo $BEARER_TOKEN

6. Optional: Test the token immediately by fetching an artist profile
curl --request GET \
  --url "https://api.spotify.com/v1/search?q=$1&type=artist" \
  --header "Authorization: Bearer $BEARER_TOKEN"