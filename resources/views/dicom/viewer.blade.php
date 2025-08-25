<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DICOM Viewer</title>
    <style>
        body {
            background: #0d1117;
            color: #fff;
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        .viewer {
            margin-top: 20px;
        }
        img {
            max-width: 90%;
            max-height: 80vh;
            border: 2px solid #444;
            border-radius: 8px;
            background: #000;
        }
    </style>
</head>
<body>
    <h2>DICOM Viewer | Instance: {{ $instanceID }}</h2>
    <div class="viewer">
        <img src="{{ url('/dicom/rendered/'.$instanceID) }}" alt="DICOM Rendered Preview">
    </div>
</body>
</html>
