from http.server import HTTPServer, BaseHTTPRequestHandler
from urllib.parse import urlparse

class SimpleRouter(BaseHTTPRequestHandler):
    def do_GET(self):
        # 1 & 2. Get the path from the request
        parsed_url = urlparse(self.path)
        path = parsed_url.path
        
        # Define route actions
        def home():
            self.send_response(200)
            self.end_headers()
            self.wfile.write(b"<h1>Home</h1>")

        def about():
            self.send_response(200)
            self.end_headers()
            self.wfile.write(b"<h1>About</h1>")

        routes = {
            "/": home,
            "/about": about,
        }

        # 3. Route matching
        if path in routes:
            routes[path]()
        else:
            self.send_response(404)
            self.end_headers()
            self.wfile.write(b"404 Not Found")

if __name__ == "__main__":
    server = HTTPServer(('localhost', 8000), SimpleRouter)
    print("Server started at http://localhost:8000")
    server.serve_forever()