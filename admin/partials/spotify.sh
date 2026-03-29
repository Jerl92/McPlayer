curl --request GET \
  --url 'https://tivomusicapi-staging-elb.digitalsmiths.net/sd/tivomusicapi/taps/v3/search/artist?name='$1'&includeAllFields=false' \
  --header 'Accept: '