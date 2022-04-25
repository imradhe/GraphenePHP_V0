<img src="" id="preview" />
<input type="file" id="image">
<canvas id="myCanvas"></canvas>

<script>
let image = document.querySelector("#image")
let banner = document.querySelector("#tableBanner")
let preview = document.getElementById('preview');

    image.onchange = (event) => {
        imgData = URL.createObjectURL(event.target.files[0])
        var prevSrc = preview.src
        preview.src = imgData
    }
    
    preview.onload = () => {
        preview.src = getBase64Image(preview)
        console.log(preview)
    }

function getBase64Image(img) {
  var canvas = document.createElement("canvas")
  canvas.width = img.width
  canvas.height = img.height
  var ctx = canvas.getContext("2d")
  ctx.drawImage(img, 0, 0)
  var dataURL = canvas.toDataURL("image/png")
  return dataURL
}

    

</script>