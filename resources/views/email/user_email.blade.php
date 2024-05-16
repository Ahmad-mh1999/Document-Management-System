<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
</head>
<body>
    <h1>Welcome, {{ $userName }}</h1>
    <h4>Your Documents is</h4>
    <ul>
        @foreach ($documents as $document)
        <li>{{$document}}</li>
        @endforeach
    </ul>
</body>
</html>