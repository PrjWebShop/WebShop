<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="./bot.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Bot</title>
</head>

<body class="container h-100">
    <div class="outer">
        <div class="middle">
            <div class="inner p-2" id="inner">
                <h4 class="text-center">Hello there! how can I help?</h4>
                <hr />
                <p class="text-left text-light"><span class="bg-primary rounded p-1 m-1">I am designed by the WebShop team. How can I help?</span></p>
                <p class="text-right text-light"><span class="bg-dark rounded p-1 m-1">Hey what is your name?</span></p>
                <p class="text-left text-light"><span class="bg-primary rounded p-1 m-1">I do not have a name yet.</span></p>

            </div>
            <div class="d-flex justify-content-center mt-1">
                <div class="d-flex justify-content-around" style="width: 35rem;">
                    <input type="text" class="form-control" id="input" placeholder="Type here..." />
                    <button type="button" class="btn btn-outline-primary" id="send" onclick="send()">Send</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/javascript">
        function send() {
            var input = document.getElementById('input').value;
            if (input) {
                var box = document.getElementById("inner");
                var para = document.createElement("p");
                para.className = "text-right text-light";
                var span = document.createElement("span");
                span.className = "bg-dark rounded p-1 m-1";
                span.innerHTML = input;
                para.appendChild(span);
                box.appendChild(para);
                document.getElementById('input').value = "";

                $.ajax({
                    url: './chat.php',
                    type: 'POST',
                    data: {
                        input: input
                    },
                    success: function(response) {
                        var para = document.createElement("p");
                        para.className = "text-left text-light";
                        var span = document.createElement("span");
                        span.className = "bg-primary rounded p-1 m-1";
                        span.innerHTML = response;
                        para.appendChild(span);
                        box.appendChild(para);
                    }
                });
            } else {
                alert("Please type something!");
            }
        }
    </script>
</body>


</html>