<!DOCTYPE html>
<html lang="<?php echo SITE_LANG; ?>">

<head>
  <!-- Add basepath to define from where the links should be generated and the file loading -->
  <base href="<?php echo BASEPATH; ?>">

  <meta charset="UTF-8">

  <title><?php echo isset($d->title) ? $d->title . ' - ' . get_sitename() : 'Welcome - ' . get_sitename(); ?></title>

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">

  <!-- Custom styles for this template -->
  <link href="<?php echo CSS . 'form-validation.css'; ?>" rel="stylesheet">

  <!-- Toastr css -->
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

  <!-- Waitme css -->
  <link rel="stylesheet" href="<?php echo PLUGINS . 'waitme/waitMe.min.css'; ?>">

  <style>
    .btn {
      border-radius: 5px;
    }

    .bg-light {
      background-color: #f8f9fa !important;
    }

    .d-flex {
      display: flex !important;
    }

    .align-items-center {
      align-items: center !important;
    }

    .border-bottom {
      border-bottom: 1px solid #dee2e6 !important;
    }

    .box-shadow {
      box-shadow: 0 .25rem .75rem rgba(0, 0, 0, .05);
    }

    .lh-100 {
      line-height: 1;
    }

    .lh-125 {
      line-height: 1.25;
    }

    .lh-150 {
      line-height: 1.5;
    }
  </style>
</head>

<body class="bg-light">

  <!-- Navbar -->
  <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
    <h5 class="my-0 mr-md-auto font-weight-normal"><a href="<?php echo URL; ?>"><img
          src="<?php echo IMAGES . 'yumi_150.png'; ?>" alt="Yumi" class="img-fluid" style="width: 70px;"></a></h5>
    <nav class="my-2 my-md-0 mr-md-3">
      <a class="p-2 text-dark" href="consultas/agendar">Schedule appointment</a>
      <a class="p-2 text-dark" href="pacientes">Patients</a>
      <a class="btn btn-success" href="login">Login</a>
      <a class="btn btn-outline-danger" href="logout">Logout</a>
    </nav>
  </div>

  <!-- Schedule appointment -->
  <div class="container">
    <div class="row">
      <div class="offset-xl-2 col-xl-8 py-5">
        <h2 class="mb-4">Schedule your appointment</h2>

        <div class="card">
          <div class="card-header">Complete the form</div>
          <div class="card-body">
            <form method="post" action="process.php" enctype="multipart/form-data">
              <div class="mb-3 row">
                <div class="col-xl-6 col-12">
                  <label for="nombres">First name</label>
                  <input type="text" class="form-control" name="nombres" required>
                </div>
                <div class="col-xl-6 col-12">
                  <label for="apellidos">Last name</label>
                  <input type="text" class="form-control" name="apellidos" required>
                </div>
              </div>
              <div class="mb-3 row">
                <div class="col-xl-6 col-12">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" name="email" required>
                </div>
                <div class="col-xl-6 col-12">
                  <label for="telefono">Phone</label>
                  <input type="text" class="form-control" name="telefono" required>
                </div>
              </div>
              <div class="mb-3 row">
                <div class="col-xl-6 col-12">
                  <label for="sexo">Sex</label>
                  <select name="sexo" id="sexo" class="form-control" required>
                    <option value="">Select an option...</option>
                    <option value="femenino">Female</option>
                    <option value="masculino">Male</option>
                    <option value="otro">Other</option>
                  </select>
                </div>
                <div class="col-xl-6 col-12">
                  <label for="edad">Age</label>
                  <input type="number" class="form-control" name="edad" min="1" max="120" required>
                </div>
              </div>
              <div class="mb-3">
                <label for="notas">Describe the symptoms</label>
                <textarea name="notas" id="notas" cols="10" rows="5" class="form-control" required></textarea>
              </div>
              <div class="mb-3">
                <label for="fecha">Schedule appointment</label>
                <input type="date" class="form-control" name="fecha" required>
              </div>

              <button class="btn btn-success" type="submit">Schedule now</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Patients -->
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h2 class="mb-4">All patients</h2>

        <div class="card">
          <div class="card-header">Patient list</div>
          <div class="card-body table-responsive">
            <table class="table table-hover table-striped table-borderless">
              <thead>
                <tr>
                  <th>Number</th>
                  <th>Full name</th>
                  <th>Sex</th>
                  <th>Date</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>012032</td>
                  <td>Pancho Doe</td>
                  <td>Male</td>
                  <td>August 12, 2020</td>
                  <td>Reviewed</td>
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-light" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="#"><i class="fas fa-eye"></i> View</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-laptop-medical"></i> Review</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-check"></i> Finished</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-trash"></i> Delete</a>
                      </div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>856322</td>
                  <td>Maria Doe</td>
                  <td>Female</td>
                  <td>August 12, 2020</td>
                  <td>Pending</td>
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-light" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="#"><i class="fas fa-eye"></i> View</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-laptop-medical"></i> Review</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-check"></i> Finished</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-trash"></i> Delete</a>
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- View patient -->
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h2 class="mb-4">View patient</h2>
      </div>

      <div class="col-xl-4">
        <img src="https://picsum.photos/500" alt="Patient" class="img-fluid img-thumbnail img-circle">
      </div>
      <div class="col-xl-8">
        <div class="card">
          <div class="card-header">Patient information</div>
          <div class="card-body">
            <p><strong>Name:</strong> Pancho Doe</p>

            <p><strong>Email:</strong> micorreo@doe.com</p>

            <p><strong>Phone:</strong> 11223344</p>

            <p><strong>Scheduled date:</strong> August 12, 2020</p>

            <p><strong>Added notes or symptoms:</strong> Lorem ipsum dolor sit amet, consectetur adipisicing elit.
              Quas suscipit et quod possimus laudantium rerum fugiat, deleniti facilis dignissimos perspiciatis.</p>

            <div class="button-group">
              <a href="" class="btn btn-warning"><i class="fas fa-laptop-medical"></i> Review</a>
              <a href="" class="btn btn-success"><i class="fas fa-check"></i> Finished</a>
              <a href="" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Review patient -->
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h2 class="mb-4">Review patient</h2>
      </div>

      <div class="col-xl-4">
        <img src="https://picsum.photos/500" alt="Patient" class="img-fluid img-thumbnail img-circle">
      </div>
      <div class="col-xl-8">
        <div class="card">
          <div class="card-header">Patient information</div>
          <div class="card-body">
            <p><strong>Name:</strong> Pancho Doe</p>

            <p><strong>Email:</strong> micorreo@doe.com</p>

            <p><strong>Phone:</strong> 11223344</p>

            <p><strong>Scheduled date:</strong> August 12, 2020</p>

            <p><strong>Added notes or symptoms:</strong> Lorem ipsum dolor sit amet, consectetur adipisicing elit.
              Quas suscipit et quod possimus laudantium rerum fugiat, deleniti facilis dignissimos perspiciatis.</p>

            <form action="" class="">
              <div class="mb-3">
                <label for="recomendaciones">Recommendations</label>
                <textarea class="form-control" name="recomendaciones" required></textarea>
              </div>

              <div class="mb-3">
                <label for="receta">Prescription</label>
                <input type="file" class="form-control-file" name="receta" id="receta" accept="application/pdf"
                  required>
              </div>

              <button class="btn btn-success" type="submit"><i class="fas fa-envelope-open-text"></i> Finish
                review</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>