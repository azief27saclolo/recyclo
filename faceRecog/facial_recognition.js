document.addEventListener('DOMContentLoaded', function() {
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const faceDetectionMessage = document.getElementById('faceDetectionMessage');
    const verificationButton = document.getElementById('verificationButton');
    let streaming = false;
    let faceCaptured = false;
    let stream = null;

    // Load OpenCV.js
    function onOpenCvReady() {
        console.log('OpenCV.js is ready.');
    }

    // Start video stream
    navigator.mediaDevices.getUserMedia({ video: true })
        .then(function(mediaStream) {
            console.log('Video stream started.'); // Debugging line
            stream = mediaStream;
            video.srcObject = stream;
            video.play();
            video.addEventListener('canplay', function() {
                if (!streaming) {
                    video.setAttribute('width', video.videoWidth);
                    video.setAttribute('height', video.videoHeight);
                    canvas.setAttribute('width', video.videoWidth);
                    canvas.setAttribute('height', video.videoHeight);
                    streaming = true;

                    // Start facial recognition once the video stream is ready
                    startFacialRecognition();
                }
            }, false);
        })
        .catch(function(err) {
            console.error("An error occurred while accessing the webcam: " + err);
        });

    function startFacialRecognition() {
        if (!streaming) {
            console.log('Video not streaming.');
            return;
        }

        const src = new cv.Mat(video.videoHeight, video.videoWidth, cv.CV_8UC4);
        const gray = new cv.Mat();
        const cap = new cv.VideoCapture(video);
        const faceCascade = new cv.CascadeClassifier();
        const utils = new Utils('errorMessage');

        // Load the face detection model
        utils.createFileFromUrl('haarcascade_frontalface_default.xml', 'haarcascade_frontalface_default.xml', () => {
            faceCascade.load('haarcascade_frontalface_default.xml');
            console.log('Face detection model loaded.');

            // Start processing video frames
            const FPS = 30;
            function processVideo() {
                try {
                    if (!streaming || faceCaptured) {
                        src.delete();
                        gray.delete();
                        faceCascade.delete();
                        return;
                    }

                    cap.read(src);
                    cv.cvtColor(src, gray, cv.COLOR_RGBA2GRAY, 0);
                    let faces = new cv.RectVector();
                    faceCascade.detectMultiScale(gray, faces);

                    if (faces.size() > 0) {
                        faceDetectionMessage.textContent = 'Face detected. Verifying...';
                        faceDetectionMessage.style.color = 'orange';

                        // Wait for 3 seconds before verifying the face
                        setTimeout(() => {
                            verifyFace(faces);
                        }, 3000);
                    } else {
                        faceDetectionMessage.textContent = 'No face detected.';
                        faceDetectionMessage.style.color = 'red';
                    }

                    for (let i = 0; i < faces.size(); ++i) {
                        let face = faces.get(i);
                        let point1 = new cv.Point(face.x, face.y);
                        let point2 = new cv.Point(face.x + face.width, face.y + face.height);
                        cv.rectangle(src, point1, point2, [255, 0, 0, 255], 2); // Draw rectangle with thickness 2
                    }

                    cv.imshow('canvas', src);
                    setTimeout(processVideo, 1000 / FPS);
                } catch (err) {
                    console.error('Error during face detection:', err);
                }
            }

            // Start processing video
            processVideo();
        });
    }

    function verifyFace(faces) {
        if (faces.size() > 0) {
            faceDetectionMessage.textContent = 'Face verified!';
            faceDetectionMessage.style.color = 'green';
            video.style.borderColor = 'green'; // Change border color to green

            // Capture the frame and send it to the server
            captureFrame();
            faceCaptured = true; // Stop further processing

            // Freeze the video feed
            video.pause();

            // Turn off the webcam
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }

            // Show the verification button
            verificationButton.style.display = 'block';
        } else {
            faceDetectionMessage.textContent = 'No face detected.';
            faceDetectionMessage.style.color = 'red';
        }
    }

    function captureFrame() {
        const context = canvas.getContext('2d');
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        const dataUrl = canvas.toDataURL('image/png');
        sendFrameToServer(dataUrl);
    }

    function sendFrameToServer(dataUrl) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'save_frame.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log('Frame saved successfully.');
            } else {
                console.error('Failed to save frame.');
            }
        };
        xhr.send('image=' + encodeURIComponent(dataUrl));
    }

    // Redirect to index.php when the verification button is clicked
    verificationButton.addEventListener('click', function() {
        window.location.href = '../USER/index.php';
    });
});

class Utils {
    constructor(errorOutputId) {
        this.errorOutput = document.getElementById(errorOutputId);
    }

    createFileFromUrl(path, url, callback) {
        console.log('Loading file from URL:', url); // Debugging line
        let request = new XMLHttpRequest();
        request.open('GET', url, true);
        request.responseType = 'arraybuffer';

        request.onload = () => {
            if (request.status === 200) {
                console.log('File loaded successfully:', url); // Debugging line
                let data = new Uint8Array(request.response);
                cv.FS_createDataFile('/', path, data, true, false, false);
                callback();
            } else {
                this.printError('Failed to load ' + url + ' status: ' + request.status);
            }
        };

        request.onerror = () => {
            this.printError('Network error while loading ' + url);
        };

        request.send();
    }

    printError(err) {
        if (this.errorOutput) {
            this.errorOutput.innerHTML = err;
        } else {
            console.error(err);
        }
    }
}