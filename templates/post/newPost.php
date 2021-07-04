<div class="card">
  <div class="card-body">
    <h5 class="card-title">¡Cuenta algo nuevo!</h5>
    <select class="custom-select custom-select-sm w-25">
        <option value="public" selected>Publico</option>
        <option value="private">Privado</option>
    </select>
    <textarea  style="resize: none;" class="form-control mt-1" id="way_thinking" placeholder="¿Qué estas pensando, (?)?" rows="3"></textarea>
<!-- CAROUSEL -->
      <div id="photosCarousel" class="carousel slide mt-1 d-none" data-ride="carousel" data-interval="false">
        <div class="carousel-inner" id="photosContainer">

          <div class="d-none" id="photoModel">
            <div class="photo-container embender-responsive embed-responsive-1by1" style="height:300px;background-image:url('https://concepto.de/wp-content/uploads/2015/03/paisaje-e1549600034372.jpg'); background-repeat:no-repeat; background-size:cover; background-position:center;"></div>
            <div class="button-bubble text-center mx-auto pt-1" style="cursor:pointer; position:relative; top:-2.5em"> <i class="fas fa-trash text-danger mt-1"></i> </div>
          </div>
          
        </div>
        <a class="carousel-control-prev" href="#photosCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#photosCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
<!-- END CAROUSEL -->
    <a href="#" class="btn btn-primary mt-1">Publicar</a>
    <label for="upload-photo" class="btn btn-secondary mt-2"> <i class="fas fa-camera"></i> </label>
    <input type="file" name="photo" class="d-none" id="upload-photo" onchange="uploadImages(event)" multiple/>
  </div>
</div>

<script>

  var postData = new FormData();
  var fileList = {}
  var fileId = 0

function deleteImage(imgId){

    let imgNode = document.getElementById(imgId)
    delete fileList[imgId]
    imgNode.remove()

    if(Object.keys(fileList).length > 0){
        let firstImgNode = document.getElementById(Object.keys(fileList)[0])
        firstImgNode.classList.add('active') 
    } else {
        document.getElementById('photosCarousel').classList.add('d-none')
    }

    
}

function uploadImages(e) {
      var photosContainer = document.getElementById('photosContainer')
      var firstImg = true
      // check if there's images uploaded
      if(Object.keys(fileList).length >= 1){
        firstImg = false
      }

      Array.from(e.target.files).forEach(function(file){
          
          

          let reader = new FileReader();
          reader.readAsDataURL(file);

          reader.onload = function(){
              fileId = fileId + 1
              fileList['file-'+fileId] = file
              let modelNode = document.getElementById('photoModel').cloneNode(true)
              modelNode.getElementsByClassName('photo-container')[0].style.backgroundImage = 'url("'+ reader.result +'")'
              modelNode.id = 'file-'+fileId
              modelNode.classList.add('carousel-item')
              modelNode.classList.remove('d-none')
              modelNode.getElementsByClassName('button-bubble')[0].setAttribute('onclick', 'deleteImage("file-'+ fileId +'")')

              if(firstImg){
                document.getElementById('photosCarousel').classList.remove('d-none')
                modelNode.classList.add('active')

                firstImg = false
              }

              photosContainer.appendChild(modelNode)

          };

      })
      document.getElementById('upload-photo').value = ''    
     
}
</script>