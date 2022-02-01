<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $file->filename }}</title>
</head>
<body>
    <div style="height: 100%">
        <iframe
            allowfullscreen
            src="{{$file->filepath}}"
            frameBorder="0"
            scrolling="auto"
            width="100%"
            height="100vh"
            style="position:fixed; top:0; left:0; bottom:0; right:0; width:100%; height:100%; border:none; margin:0; padding:0; overflow:hidden; z-index:999999;"
        ></iframe>
    </div>
</body>
</html>