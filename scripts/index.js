// this script has not been implemented

const video = document.getElementById('webcam');
const liveView = document.getElementById('liveView');
const demosSection = document.getElementById('demos');
const enableWebcamButton = document.getElementById('webcamButton');
const captureButton = document.getElementById('capture');
const webcam = document.getElementById('webcam');
const canvas = document.getElementById('canvas');
const context = canvas.getContext('2d');


//functions
// Check if webcam access is supported.
function getUserMediaSupported() {
  return !!(navigator.mediaDevices &&
    navigator.mediaDevices.getUserMedia);
}

// Enable the live webcam view and start classification.
function enableCam(event) {
  // Only continue if the COCO-SSD has finished loading.

  // Hide the button once clicked.
  event.target.classList.add('removed');

  // getUsermedia parameters to force video but not audio.
  const constraints = {
    video: true
  };

  // Activate the webcam stream.
navigator.mediaDevices.getUserMedia(constraints).then(function(stream) {
    video.srcObject = stream;
 //   video.addEventListener('loadeddata', predictWebcam);
  });
}

captureButton.addEventListener('click', () => {
  // Draw the video frame to the canvas.
    context.drawImage(webcam, 0, 0, canvas.width, canvas.height);
   // Stop all video streams.
    webcam.srcObject.getVideoTracks().forEach(track => track.stop());
 });

//flow
// If webcam supported, add event listener to button for when user
// wants to activate it to call enableCam function which we will
// define in the next step.
if (getUserMediaSupported()) {
  demosSection.classList.remove('invisible');
  enableWebcamButton.addEventListener('click', enableCam);
} else {
  console.warn('getUserMedia() is not supported by your browser');
}
