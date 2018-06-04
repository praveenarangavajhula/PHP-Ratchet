<H2>Ratchet - PHP Websocket</H2>

<p>
This simple project aims to develop a simple chat application using PHP programming language that implement Ratchet Web socket. The chat will accept all incoming messages and deliver that message to all other connections.
</p>

<p>

## Preparing application
You only need to do these once for all.
1. Make a folder for your application using command prompt:

   ```
   >> cd E:\xampp\htdocs
   >> E:\xampp\htdocs>mkdir PHP-Ratchet
   >> E:\xampp\htdocs>cd PHP-Ratchet
   >> E:\xampp\htdocs\PHP-Ratchet>
   ```

2. Install Ratchet using `composer` :

   ```
   >> E:\xampp\htdocs\PHP-Ratchet>composer require cboden/ratchet
   ```

3. We'll start off by creating a class, `Chat` class. This class will be our chat "application". This basic application will listen for 4 events:

   ```
   <ul>
   <li>onOpen - Called when a new client has Connected</li>
   <li>onMessage - Called when a message is received by a Connection</li>
   <li>onClose - Called when a Connection is closed</li>
   <li>onError - Called when an error occurs on a Connection</li>
   </ul>
   ```

Save this class as `src/Chat.php`. We're going to hold everything in the `MyApp` namespace. Our Chat class will be our application logic.

4. Add or Modify `composer.json` like this:

   ```
   {
        "autoload": {
            "psr-4": {
                "MyApp\\": "src"
            }
        },
        "require": {
            "cboden/ratchet": "^0.4"
        }
    }
   ```

5. Next, we're going to create script/file will call from the command line to launch our application:

   ```
   <?php
    use Ratchet\Server\IoServer;
    use Ratchet\Http\HttpServer;
    use Ratchet\WebSocket\WsServer;
    use MyApp\Chat;

    require dirname(__DIR__) . '/vendor/autoload.php';
    define("PORT", 8182);

    $server = IoServer::factory(
        new HttpServer(
            new WsServer(
                new Chat()
            )
        ),
        PORT
    );

    $server->run();
   ```

Above, you'll see we create an I/O (Input/Output) server class that listening for any incoming requests on port 8182. Save this script as `src/chat-server.php`.

6. Now, we're going to create chat interface and save this as `src/index.php`. You can use bootstrap for the page template (You can copy from my `src/index.php`):

   ```
   >> E:\xampp\htdocs\PHP-Ratchet>composer require twbs/bootstrap:4.0.0
   ```

7. Run composer update using this statement:

   ```
   >> E:\xampp\htdocs\PHP-Ratchet>composer update
   ```

8. Now, we can run the server with the following command in your terminal:

   ```
   >> E:\xampp\htdocs\_Project\PHP-Ratchet>cd src
   >> E:\xampp\htdocs\_Project\PHP-Ratchet\src>php chat-server.php
   ```

9. And run `http://localhost/_Project/PHP-Ratchet/src/index.php` on your browser to access chat interface.
