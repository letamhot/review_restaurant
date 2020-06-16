<div class="page-search">
  <!-- Search Form-->
  <form action="" method="post" hidden >
      @csrf
      <div class="form-group floating-addon floating-addon-not-append">
          <div class="input-group">
              <div class="input-group-prepend">
                  <div class="input-group-text">
                      <i class="fas fa-search"></i>
                  </div>
              </div>
              <input type="text" class="form-control" id="search" name="search" placeholder="Search">
              <div class="input-group-append">
                  <button type="submit" class="btn btn-primary btn-lg">
                    Search
                  </button>
              </div>
          </div>
      </div>
  </form>
  <div class="mt-3">
    <a href="{{ url('/') }}">Back to Home</a>
  </div>
</div>