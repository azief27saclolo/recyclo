<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facial Recognition</title>
    <script src="opencv.js" type="text/javascript"></script> <!-- Include the downloaded OpenCV.js file -->
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f0f0f0;
            margin: 0;
        }
        h1 {
            color: #333;
        }
        #video {
            width: 320px; /* Reduced size by 50% */
            height: 240px; /* Reduced size by 50% */
            border-radius: 60%;
            border: 5px solid #333;
            margin-bottom: 20px;
        }
        #canvas {
            display: none;
        }
        #faceDetectionMessage {
            margin-top: 20px;
            font-size: 18px;
            color: #333;
        }
        #verificationButton {
            display: none;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Facial Recognition</h1>
    <video id="video" autoplay></video>
    <canvas id="canvas"></canvas>
    <div id="faceDetectionMessage">Face detection status will appear here.</div>
    <button id="verificationButton" class="btn btn-success">Face Verification Successful</button>
    <script src="facial_recognition.js"></script>
</body>
</html>