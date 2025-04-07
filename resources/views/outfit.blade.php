<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Outfit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="{{ asset('css/outfit.css') }}">
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar w/ text</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pricing</a>
                    </li>
                </ul>
                <span class="navbar-text">
                    Navbar text with an inline element
                </span>
            </div>
        </div>
    </nav>

    <div class="row">
        <div class="col-6"></div>
        <div class="col-6">
            <h1>Crea tu outfit !</h1>
            <div class="container">
                <label for="estilo">Selecciona tu estilo</label>
                <select class="form-control my-2" name="estilo" id="estilo"></select>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="container">
                    <h1>Outfit</h1>
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="image" name="image" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
            <div class="col-2">
                <div class="container">
                    <h4>Cabeza</h4>
                    <label for="prenda">Prenda :</label>
                    <select class="form-control my-2" name="prenda" id="prenda">
                        <option value="" selected disabled>Prenda</option>
                    </select>
                    <label for="tipoPrenda">Tipo de prenda :</label>
                    <select class="form-control my-2" name="tipoPrenda" id="tipoPrenda">
                        <option value="" selected disabled>Tipo de prenda</option>
                    </select>

                    <select class="form-control my-2" name="" id=""></select>
                </div>
            </div>
            <div class="col-2">
                <div class="container">
                    <h4>Torso</h4>
                    <label for="prenda">Prenda :</label>
                    <select class="form-control my-2" name="prenda" id="prenda">
                        <option value="" selected disabled>Prenda</option>
                    </select>
                    <label for="tipoPrenda">Tipo de prenda :</label>
                    <select class="form-control my-2" name="tipoPrenda" id="tipoPrenda">
                        <option value="" selected disabled>Tipo de prenda</option>
                    </select>

                    <select class="form-control my-2" name="" id=""></select>
                </div>
            </div>
            <div class="col-2">
                <div class="container">
                    <h4>Piernas</h4>
                    <label for="prenda">Prenda :</label>
                    <select class="form-control my-2" name="prenda" id="prenda">
                        <option value="" selected disabled>Prenda</option>
                    </select>
                    <label for="tipoPrenda">Tipo de prenda :</label>
                    <select class="form-control my-2" name="tipoPrenda" id="tipoPrenda">
                        <option value="" selected disabled>Tipo de prenda</option>
                    </select>

                    <select class="form-control my-2" name="" id=""></select>
                </div>
            </div>
            <div class="col-2">
                <div class="container">
                    <h4>Cabeza</h4>
                    <label for=""></label>
                    <select class="form-control my-2" name="" id=""></select>
                    <select class="form-control my-2" name="" id=""></select>
                    <select class="form-control my-2" name="" id=""></select>
                </div>
            </div>
        </div>

</body>

</html>
