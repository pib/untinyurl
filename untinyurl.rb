require 'net/http'
require 'uri'

def untinyurl(tinyurl)
  Net::HTTP.get_response(URI.parse(tinyurl))['location'] or tinyurl
rescue
  tinyurl
end
