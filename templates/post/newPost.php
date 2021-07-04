<!-- WAITING MODAL -->

<div class="modal" id="waitingModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Publicando...</h5>
      </div>
      <div class="modal-body text-center">

                    <div class="loadingio-spinner-pulse-73hpm1me5ss"><div class="ldio-eocps6p8ny">
                    <div></div><div></div><div></div>
                    </div></div>

      </div>
    </div>
  </div>
</div>

<!-- END WAITING MODAL -->

<!-- POSTED MODAL -->

<div class="modal" id="postedModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Publicado</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <i class="fas fa-check text-success" style="font-size:3em"></i>
      </div>
    </div>
  </div>
</div>

<!-- END POSTED MODAL -->


<div class="card">
  <div class="card-body">
    <h5 class="card-title">¡Cuenta algo nuevo!</h5>
    <select id="privacy" class="custom-select custom-select-sm w-25">
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
    <a href="#" class="btn btn-primary mt-1" onclick="publishPost()">Publicar</a>
    <label for="upload-photo" class="btn btn-secondary mt-2"> <i class="fas fa-camera"></i> </label>
    <input type="file" name="photo" class="d-none"  accept="image/png, image/gif, image/jpeg" id="upload-photo" onchange="uploadImages(event)" multiple/>
  </div>
</div>

<script>


  var fileList = {}
  var fileId = 0

function publishPost(profile = false){
    $('#waitingModal').modal({backdrop: 'static', keyboard: false})
    var postData = new FormData();
    postData.append('content', document.getElementById('way_thinking').value)
    postData.append('privacy', document.getElementById('privacy').value)
    postData.append('type', 'normal')
    for (let fileId in fileList) {
      postData.append('mmedias[]', fileList[fileId]);
    }
    $.ajax({
            method: 'POST',
            enctype: 'multipart/form-data',
            url: "http://localhost:8000/posts",
            beforeSend: function(xhr){
                xhr.setRequestHeader('api_token', api_token)
                xhr.setRequestHeader('user_id', user_id)
            },
            data: postData,
            processData: false,
            contentType: false,
            cache: false,
        }).done(function(post){
          //alert("Publicacion realizada con exito!")
          
          console.log(post)
          $('#waitingModal').modal('hide')
          $('#postedModal').modal('show')
          $('#postedModal').on('hidden.bs.modal', function(e){
            window.location.href= "./home.php"
          })

        }).fail(function(error){
          alert("Error al intentar crear el post!")
          console.log(error)
          $('#waitingModal').modal('hide')
        })

}

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