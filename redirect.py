#coding=utf-8

import urllib2
import urllib
import json
import sys, os.path
import webbrowser
import re

url = sys.argv[1].replace('====', '&')

def getRedirect():
    webbrowser.open(url)

if __name__ == "__main__":
    getRedirect()
