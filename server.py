import SocketServer
import json
import re

class MyTCPServer(SocketServer.ThreadingTCPServer):
    allow_reuse_address = True

class MyTCPServerHandler(SocketServer.BaseRequestHandler):
    def handle(self):
        try:
            inp = self.request.recv(1024).strip()
            print 'inp : |',inp,'|'
            # extract json
            p = re.compile('{.*}')
            data = json.loads(p.findall(inp)[0])
            print 'json : ', data
            print ''
            self.request.sendall(json.dumps({'return':'ok'}))
            
        except Exception, e:
            print "Exception while receiving message: ", e

server = MyTCPServer(('10.109.53.12', 12345), MyTCPServerHandler)
server.serve_forever()
