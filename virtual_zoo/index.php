<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Virtual Zoo - Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="resources/css/index.css">
  </head>
  <body>
    <div class="modal fade" id="soundWarn" tabindex="-1" aria-labelledby="soundWarn" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Some animals can make noise!</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            For a better experience, we recommend you to allow the audio playback in your browser.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <main class="d-flex flex-column justify-content-center align-items-center h-100">
        <img src="resources/images/brand.png" alt="Game Brand" height="300">
        <a href="game.php?pet=0" class="btn btn-sm btn-warning px-5">Iniciar</a>
    </main>
    <script src="https://kit.fontawesome.com/1d52c626c2.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script>
        $(function(){
            if(localStorage.getItem('soundWarned')===null){
                localStorage.setItem('soundWarned',"false")
            }
            if(localStorage.getItem('soundWarned')==="false"){
                $("#soundWarn").modal('toggle')
                localStorage.setItem('soundWarned',"true")
            }
        })
    </script>
  </body>
</html>