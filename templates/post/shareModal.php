 <!-- POST CONTENT MODAL -->

 <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" id="postContent">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Publicar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="sharePostContentBody">
                
                <select class="custom-select custom-select-sm w-25">
                    <option value="public" selected>Publico</option>
                    <option value="private">Privado</option>
                </select>
                <textarea  style="resize: none;" class="form-control mt-1" id="sharedPostContent" placeholder="Escribe algo..." rows="3"></textarea>
                <hr>
                <div class="m-0 p-0" id="sharedPostBody">

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="sharePostContent" class="btn btn-primary">Publicar</button>
            </div>
            </div>
        </div>
    </div>

    <!-- END POST MODAL-->