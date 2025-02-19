
<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

require 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo Capture</title>
    <link rel="stylesheet" href="style.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        @media (max-width: 768px) {
    .logo-container img {
        width: 100px; /* Smaller size for mobile */
    }
}

        body { 
            font-family: Arial, sans-serif;
            background: #000; 
            display: flex;
            flex-direction: column;
            align-items: center; 
            justify-content: center;
            height: 100vh;
            width: 100vw;
            overflow: hidden;
        }
        .camera-container {
            position: absolute;
            top: 50%;
             left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            height: 100%;
    max-width: 100%;
    max-height: 100%;
    overflow: hidden;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #222;
        }
        .top-line, .bottom-line {
            position: absolute; 
            width: 100%;
            height: 150px;
            background: black;
            z-index: 20; 
        }
        .top-line {
            position: absolute; 
            width: 100%;
            height: 150px;
            background-color: #0F0E0A;
             
        }
        .top-line { top: 0; }
        .bottom-line { 
            bottom: 0;
            height: 150px;
            display: flex; 
            justify-content: center;
            align-items: center;
            z-index: 10;
        }
        .gridlines { 
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            grid-template-rows: 1fr 1fr 1fr;
        }
        .gridlines div { border: 2px solid rgba(255, 255, 255, 0.5); }
        video, img { 
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scaleX(-1);
        }
        video { position: relative; z-index: 10; }
        canvas { display: none; }
        .Overtime-btn, .retake-btn, .confirm-btn { 
            position: absolute;
            bottom: 35px;
            transform: translateX(-50%);
            width: 90px;
            height: 90px;
            background: white; 
            border-radius: 50%;
            border: 8px solid grey;
            cursor: pointer; 
            transition: 0.3s; 
            z-index: 20;
            font-size: 16px;
            font-weight: bold;
            color: black;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .Overtime-btn { left: 50%; }
        .retake-btn { left: 32%; display: none; }
        .confirm-btn { right: 20%; display: none; }
        .Overtime-btn:active, .retake-btn:active, .confirm-btn:active { background: lightgray; }
        .Overtime-btn::before { 
            content: "Overtime";
            position: absolute;
            top: -30px;
            left: 50%;
            transform: translateX(-50%);
            color: gold;
            font-size: 18px;
            font-weight: bold;
        }
        .retake-btn::before { 
            content: "Retake";
            position: absolute;
            top: -30px;
            left: 50%;
            transform: translateX(-50%);
            color: gold;
            font-size: 18px;
            font-weight: bold;
        }
        .confirm-btn::before {
            content: "Confirm";
            position: absolute;
            top: -30px;
            left: 50%;
            transform: translateX(-50%);
            color: gold;
            font-size: 18px;
            font-weight: bold;
        }
        .warning {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%); /* This will center it both horizontally and vertically */
    color: cyan;
    font-size: 20px;
    font-weight: bold;
    text-align: center;
    display: none;
    z-index: 30;
}

        .logo-container {
    position: fixed;
    top: -45px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 10;
}
            .logo-container img {
    max-width: 100%; /* Makes sure the image scales properly */
    height: auto;
    width: 343px;/* Adjust for mobile devices */
    transform: scaleX(1); /* This will reset the flip for the logo */
}

.switch-camera-btn {
    position: absolute;
    top: 90px; /* Adjust as necessary to position the button */
    left: 50%;
    transform: translateX(-50%);
    width: 120px;
    height: 40px;
    background: white;
    border: 2px solid grey;
    border-radius: 20px;
    cursor: pointer;
    transition: 0.3s;
    z-index: 30;
    font-size: 16px;
    font-weight: bold;
    color: black;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
}

.switch-camera-btn:active {
    background: lightgray;
}
    </style>

</head>
<body>
    <div class="logo-container">
        <img src="company logo1.jpg" alt="HTML5 Icon">
    </div>
    <a href="cam_undertime.php" id="myLink">Undertime</a>
    <a href="cam_capture.php" id="myLink2">Capture</a>
    
    <div class="camera-container">
        <div class="top-line"></div>
        <p id="warning" class="warning">Warning: Too dark! Please improve lighting.</p>
        <video id="video" autoplay></video>
        <div class="gridlines">
            <div></div><div></div><div></div>
            <div></div><div></div><div></div>
            <div></div><div></div><div></div>
        </div>
        <canvas id="canvas"></canvas>
        <img id="photo" style="display:none;">
        <button id="Overtime" class="Overtime-btn"></button>
        
        <button id="retake" class="retake-btn"></button>
        <button id="confirm" class="confirm-btn"></button>
      <button id="switchCamera" class="Overtime-btn" style="left: 20%;"></button>
        <div class="bottom-line"></div>
    </div>

    <script>
        
        const video = document.getElementById("video");
        const canvas = document.getElementById("canvas");
        const ctx = canvas.getContext("2d");
        const photo = document.getElementById("photo");  
        const OvertimeBtn = document.getElementById("Overtime");
        const retakeBtn = document.getElementById("retake");
        const confirmBtn = document.getElementById("confirm");
        const warning = document.getElementById("warning");
        
        let lastPhotoData = null;
        let locationData = "Fetching location...";
        const logo = new Image();
         // Add logo as watermark
    const logoWidth = 150; // Adjust size as needed
    const logoHeight = 150; // Adjust size as needed
    const margin = 20; // Margin from the bottom-right corner
    ctx.drawImage(logo, canvas.width - logoWidth - margin, canvas.height - logoHeight - margin, logoWidth, logoHeight);

logo.src = 'company logo.PNG';  // Path to your logo image
logo.onload = function() {
    // Logo is ready to be drawn on the canvas
};

             const switchCameraButton = document.getElementById("switchCamera"); // Get the button element
            let currentFacingMode = "environment"; // Start with back camera
            let stream = null; // Store stream reference
            let cameras = [];
let currentCameraIndex = 0;
            
            function startCamera(facingMode) {
                const stream = video.srcObject;
    if (stream) {
        const tracks = stream.getTracks();
        tracks.forEach(track => track.stop());
    }
    navigator.mediaDevices.enumerateDevices()
    .then(devices => {
        devices.forEach(device => {
            if (device.kind === "videoinput") {
                console.log("Camera found:", device.label, device.deviceId);
            }
        });
    })
    .catch(err => console.error("Error listing devices:", err));
                navigator.mediaDevices.getUserMedia({
        video: { facingMode: facingMode }
    })
    .then(stream => {
        video.srcObject = stream;
    })
    .catch(err => console.error("Camera access denied:", err));
    alert("Camera access failed. Please check your permissions.");
}
startCamera(currentFacingMode); // Initialize camera

switchCameraButton.addEventListener("click", () => {
    currentFacingMode = currentFacingMode === "environment" ? "user" : "environment";
    const newFacingMode = currentFacingMode === "environment" ? "user" : "environment";
    startCamera(newFacingMode);
});

            if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(async (position) => {
        const { latitude, longitude } = position.coords;
        try {
            const response = await fetch('https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}');
            const data = await response.json();
            const locationParts = data.display_name.split(","); // Split the address by commas
            
            // Get only the first three parts of the address (e.g., city, state, country)
            locationData = locationParts.slice(0, 3).join(", "); // Join the first three parts back into a string
            console.log(locationData); // Log the location data for debugging
        } catch (error) {
            locationData = "Location fetch failed";
            console.error(error);
        }
    }, () => {
        locationData = "Location access denied";
    });
}
        


        function checkBrightness() {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            let imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            let data = imageData.data;
            let totalBrightness = 0;

            for (let i = 0; i < data.length; i += 4) {
                let r = data[i], g = data[i + 1], b = data[i + 2];
                totalBrightness += (r + g + b) / 3;
            }

            return totalBrightness / (data.length / 4);
        }

        function updateBrightnessCheck() {
            let brightness = checkBrightness();
            if (brightness < 50) { 
                warning.style.display = "block";
                OvertimeBtn.disabled = true;
                OvertimeBtn.style.opacity = "0.5";
            } else {
                warning.style.display = "none";
                OvertimeBtn.disabled = false;
                OvertimeBtn.style.opacity = "1";
            }
        }

        setInterval(updateBrightnessCheck, 1000);
        
        OvertimeBtn.addEventListener("click", () => {
            if (OvertimeBtn.disabled) return;
             document.getElementById("myLink").style.display = "none";
    document.getElementById("myLink2").style.display = "none";


            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

            ctx.fillStyle = "white";
            ctx.font = "30px Arial";
            const dateTime = new Date().toLocaleString();
            ctx.fillText(dateTime, 20, canvas.height - 90);
            ctx.fillText(locationData, 10, canvas.height - 50);

            lastPhotoData = canvas.toDataURL("image/jpeg");
            photo.src = lastPhotoData;
            photo.style.display = "block";
            video.style.display = "none";
            OvertimeBtn.style.display = "none";
            retakeBtn.style.display = "block";
            confirmBtn.style.display = "block";
        });

        retakeBtn.addEventListener("click", () => {
            photo.style.display = "none";
            video.style.display = "block";
            OvertimeBtn.style.display = "block";
            retakeBtn.style.display = "none";
            confirmBtn.style.display = "none";
            document.getElementById("myLink").style.display = "block";
            document.getElementById("myLink2").style.display = "block";
        });

        confirmBtn.addEventListener("click", () => {
            const link = document.createElement("a");
            link.href = lastPhotoData;
            link.download = "photo.jpg";
            link.click();
        });
        window.addEventListener('load', () => {
    document.getElementById("myLink").style.display = "block";
    document.getElementById("myLink2").style.display = "block";
    startCamera(currentFacingMode); // Start the rear camera initially
});
    </script>
</body>
</html>