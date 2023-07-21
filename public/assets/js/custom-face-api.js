const video = document.getElementById('video')

Promise.all([
  faceapi.nets.tinyFaceDetector.loadFromUri('/models'),
  faceapi.nets.faceLandmark68Net.loadFromUri('/models'),
  faceapi.nets.faceRecognitionNet.loadFromUri('/models'),
  faceapi.nets.faceExpressionNet.loadFromUri('/models')
]).then(startVideo)

function startVideo() {
  navigator.getUserMedia(
    { video: {} },
    stream => video.srcObject = stream,
    err => console.error(err)
  )
}

video.addEventListener('play', () => {
  const canvas = faceapi.createCanvasFromMedia(video)
  document.body.append(canvas)
  const displaySize = { width: video.width, height: video.height }
  faceapi.matchDimensions(canvas, displaySize)
  setInterval(async () => {
    const detections = await faceapi.detectAllFaces(video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceExpressions()
    const resizedDetections = faceapi.resizeResults(detections, displaySize)
    canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height)
    // faceapi.draw.drawDetections(canvas, resizedDetections)
    // faceapi.draw.drawFaceLandmarks(canvas, resizedDetections)
    // faceapi.draw.drawFaceExpressions(canvas, resizedDetections)
    // resizedDetections[0].expressions.happy > 0.5
    if (resizedDetections.length > 0 && resizedDetections[0].detection.score > 0.5 && resizedDetections[0].expressions.happy > 0.5) {
      // let c = document.getElementById("video");
      // let ctx = c.getContext("2d");
      // const img = document.createElement("img");
      // img.src = ctx.toDataURL('image/webp');
      // document.getElementById('screenshot').appendChild(img)
      document.getElementById('status').innerHTML = 'ada orang, sedang senyum'
    }else if (resizedDetections.length > 0 && resizedDetections[0].detection.score > 0.5) {
      document.getElementById('status').innerHTML = 'ada orang'
    } else {
      document.getElementById('status').innerHTML = 'tidak ada orang'
    }
  }, 700)
})