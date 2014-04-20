#coding=utf-8

import urllib2
import urllib
import json
import sys, os.path
import webbrowser
import re

arg = sys.argv[1].replace('====', '&')

query = urllib.unquote(arg)
url = "http://m.baidu.com"+query

def getRedirect():
    req = urllib2.Request(url)
    response = urllib2.urlopen(req)
    result = response.read()

    pattern = re.compile(r".*?url=http://pan.baidu.com(.*?)\">", re.S)

    match = pattern.match(result)

    if match:
        redirect_url =  match.group(1)
        redirect_url = redirect_url.replace('&amp;','&')
        webbrowser.open('http://pan.baidu.com'+redirect_url)
    
    pass

if __name__ == "__main__":
    getRedirect()