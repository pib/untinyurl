import httplib
import urlparse

def untinyurl(tinyurl):
    url = urlparse.urlsplit(tinyurl)
    req = urlparse.urlunsplit(('', '', url.path, url.query, url.fragment))
    con = httplib.HTTPConnection(url.netloc)
    try:
        con.request('HEAD', req)
    except:
        return tinyurl
    response = con.getresponse()
    return response.getheader('Location', tinyurl)
    
