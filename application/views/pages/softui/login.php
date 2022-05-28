<style>
    .main-content{
        background-image: radial-gradient( circle farthest-corner at 10% 20%,rgba(166,239,253,1) 0%, rgba(97,186,255,1) 90.1%)
    }
</style>
<div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg blur blur-rounded top-0 z-index-3 shadow position-absolute my-3 py-2 start-0 end-0 mx-4">
          <div class="container-fluid">
            <h4 style="margin: 0;" class="navbar-brand font-weight-bolder ms-lg-0 ms-3 ">
              LOGIN MPERMISSION
            </h4>
            <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon mt-2">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </span>
            </button>
            <div class="collapse navbar-collapse" id="navigation">
              <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                  <a class="nav-link me-2" href="<?= base_url('auth/register')?>">
                    <i class="fas fa-user-circle opacity-6 text-dark me-1"></i>
                    Daftar
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link me-2" href="<?= base_url('auth/login')?>">
                    <i class="fas fa-key opacity-6 text-dark me-1"></i>
                    Masuk
                  </a>
                </li>
              </ul>
              
            </div>
          </div>
        </nav>
        <!-- End Navbar -->
      </div>
    </div>
  </div>
<main class="mt-0">
    <section>
      <div class="page-header min-vh-75">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
              <div class="card card-plain mt-8">
                <div class="card-header pb-0 text-left bg-transparent">
                  <h3 class="font-weight-bolder text-info text-gradient">Selamat Datang Kembali</h3>
                </div>
                <div class="card-body">
                  <form id="form-login" method="POST" action="<?= base_url('ws/login')?>" role="form">
                    <label>Email atau Username</label>
                    <div class="mb-3">
                      <input id="user" name="user" data-rule-required="true"  type="text" class="form-control" placeholder="user" aria-label="user" aria-describedby="user-addon">
                    </div>
                    <label>Password</label>
                    <div class="mb-3">
                      <input id="password" name="pass" type="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="password-addon">
                    </div>
                    <div class="text-center">
                      <label style="dislabellay: none" class="text-danger" id="alert_danger"></label>
                      <button type="sumbit" id="btn-login" class="btn bg-gradient-info w-100 mt-4 mb-0">Masuk</button>
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <!-- <p style="cursor: pointer;" id="reset-password" class="mb-0 text-sm mx-auto text-info text-gradient font-weight-bold">
                    Lupa password?, klik disini untuk ganti password
                  </p> -->
                  <p class="mb-4 text-sm mx-auto">
                    Belum Daftar?
                    <a href="<?= base_url('auth/register')?>" class="text-info text-gradient font-weight-bold">Daftar disini</a>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8" style="width: 125%">
                <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('<?= base_url('public/assets/img/sideImage/login2.svg') ?>')"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
          var options = {
            damping: '0.5'
          }
          Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
        $(document).ready(function(){
          $('body').addClass('main-content');
          $('main').removeClass('main-content')
        })
</script>