
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Plus Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../../../assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../../../assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="../../../assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="../../../assets/css/demo_1/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="../../../assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
          <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
              <div class="card auth-form-light text-left p-5">
                <div class="brand-logo">
                  <img src="../../../assets/images/logo.svg">
                </div>
                <h4>New here?</h4>
                <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
                <form class="pt-3" action="{{url('store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                  <div class="form-group">
                    <input type="text" class="form-control form-control-lg"  placeholder="First Name" name="firstname">
                  </div>

                  <div class="form-group">
                    <input type="text" class="form-control form-control-lg"  placeholder="Last Name" name="lastname">
                  </div>

                   <div class="form-group">
                    <input type="text" class="form-control form-control-lg"  placeholder="Father Name" name="father_name">
                  </div>

                  <div class="form-group">
                    <input type="text" class="form-control form-control-lg"  placeholder="Address" name="add">
                  </div>

                  <div class="form-group">
                    <input type="text" class="form-control form-control-lg"  placeholder="Mobile Number" name="mobile">
                  </div>

                  <div class="form-group">
                    <input type="email" class="form-control form-control-lg"  placeholder="Email" name="email">
                  </div>

                  <div class="form-group">
                    <input type="text" class="form-control form-control-lg"  placeholder="Password" name="password">
                  </div>

                  <div class="form-group">
                    <input type="file" class="form-control form-control-lg"  placeholder="Image" name="image">
                  </div>

                  <div class="mb-4">
                    <div class="form-check">
                      <label class="form-check-label text-muted">
                        <input type="checkbox" class="form-check-input"> I agree to all Terms & Conditions </label>
                    </div>
                  </div>
                  <div class="mt-3">
                   <button type="submit" class="btn btn-success btn-lg w-100">SIGN UP</button>
                  </div>
                  <div class="text-center mt-4 font-weight-light"> Already have an account? <a href="{{url('/')}}" class="text-primary">Login</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="../../../assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../../../assets/js/off-canvas.js"></script>
    <script src="../../../assets/js/hoverable-collapse.js"></script>
    <script src="../../../assets/js/misc.js"></script>
    <script src="../../../assets/js/settings.js"></script>
    <script src="../../../assets/js/todolist.js"></script>
    <!-- endinject -->
  </body>
</html>