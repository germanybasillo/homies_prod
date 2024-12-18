<x-app-layout>
    <x-slot name="header">
        <section class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h1 class="m-0 text-dark">Your Profile</h1>
                </div>
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Profile</li>
                  </ol>
                </div>
              </div>
    </x-slot>
    <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-success">
              <!-- form start -->
              <form role="form" id="quickForm">
                <div class="card-body">
                  <div class="row">
                  <div class="col-md-4">
                  <div class="form-group">
                    @include('profile.partials.update-profile-information-form')
                  </div></div>
                  <div class="col-md-4">
                  <div class="form-group">
                    @include('profile.partials.update-password-form')
                  </div></div>
                  <div class="col-md-4">
                  <div class="form-group">
                    @include('profile.partials.delete-user-form')
                  </div>
                  </div>
                <!-- /.card-body -->
              </form>
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
</x-app-layout>

