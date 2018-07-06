<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Secure your communication</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" media="screen" href="secure.css" />
    </head>
    <body>
        Your Message:<br /> <textarea id="message" placeholder="Enter your message here..." rows="5" cols="50"></textarea><br />
        Cryption Key: <input type="text" id="key" placeholder="Enter your Key"><br />
        <button id="Encrypt">Encrypt</button><button id="Decrypt">Decrypt</button>
        <p id="result"></p>
        <script>
            var msg = document.getElementById("message");
            var key = document.getElementById("key");
            var resLocation = document.getElementById("result");
            
            var encBtn = document.getElementById("Encrypt");
            encBtn.addEventListener("click", encryptPlainText);

            var decBtn = document.getElementById("Decrypt");
            decBtn.addEventListener("click", decryptCryptoText);

            function encryptPlainText() {
                var xhr = new XMLHttpRequest();
                xhr.open('POST','cryptoEngine.php',true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.onreadystatechange = function(){
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        resLocation.innerHTML = "Encrypted Message: " + xhr.responseText;
                    }
                }
                xhr.send("message="+encodeURIComponent(msg.value)+"&key="+encodeURIComponent(key.value)+"&enc="+"1");
            }

            function decryptCryptoText() {
                var xhr = new XMLHttpRequest();
                xhr.open('POST','cryptoEngine.php',true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.onreadystatechange = function(){
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        resLocation.innerHTML = "Decrypted Message: " + xhr.responseText;
                    }
                }
                xhr.send("message="+encodeURIComponent(msg.value)+"&key="+encodeURIComponent(key.value)+"&enc="+"0");
            }
        </script>
    </body>
</html>