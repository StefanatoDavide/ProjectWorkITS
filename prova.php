<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
    function getPublicIP() {
        // create & initialize a curl session
        $curl = curl_init();
      
        // set our url with curl_setopt()
        curl_setopt($curl, CURLOPT_URL, "http://httpbin.org/ip");
      
        // return the transfer as a string, also with setopt()
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
      
        // curl_exec() executes the started curl session
        // $output contains the output string
        $output = curl_exec($curl);
      
        // close curl resource to free up system resources
        // (deletes the variable made by curl_init)
        curl_close($curl);
      
        $ip = json_decode($output, true);
      
        return $ip['origin'];
      }
      echo(getPublicIP());
    ?>







</body>
</html>