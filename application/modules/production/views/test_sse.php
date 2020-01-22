<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Fuck</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
  
    
</head>
<body>
<h2>test ss3</h2>
    <div id="result"></div>
    <script>
        if (typeof(EventSource) !== "undefined") {
            //var source = new EventSource("<?php echo base_url('production/fuckingshit') ?>");
            var source = new EventSource("<?php echo site_url('production/fuckingshit')?>");
            source.onmessage = function(event)
            {
                console.log(event.data);
            //document.getElementById("result").innerHTML += event.data + "<br>";
            source.close();

            };
        } else {
            document.getElementById("result").innerHTML += "Mbeeeeeeeeek";

        }
        //document.getElementById("result").innerHTML += "Mbeeeeeeeeek";
    
    </script>
</body>
</html>