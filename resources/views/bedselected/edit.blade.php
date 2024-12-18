
<x-app-layout>
    <x-slot name="header">
        <section class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h1 class="m-0 text-dark"> Edit Bed Select</h1>
                </div>
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Bed Select</li>
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
              <form role="form" id="quickForm" action="{{ route('selectbeds.update', $selectbed->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                  <div class="row">
                  <div class="col-md-8 offset-md-2">
                  <div class="form-group">
                    <label>Bed No.</label>
                    <input type="text" name="bed_no" class="form-control" placeholder="ex. BD-0001" value="{{$selectbed->bed_no}}">
                    @if ($errors->has('bed_no'))
                    <span class="text-danger" style="color: red">{{ $errors->first('bed_no') }}</span>
                    @endif 
                  </div></div>
                  <div class="col-md-8 offset-md-2">
                    <div class="form-group">
                      <label>Description</label>
                      <input class="form-control" name="description" value="{{$selectbed->description}}">
                      @if ($errors->has('description'))
                      <span class="text-danger" style="color: red">{{ $errors->first('description') }}</span>
                      @endif 
                    </div></div>
                    <div class="col-md-8 offset-md-2">
                      <div class="form-group">
                        <label>Monthly Due</label>
                        <input type="number" step="0.01" name="monthly_due" id="monthly_due" class="form-control" placeholder="ex. 6000.00" value="{{$selectbed->monthly_due}}">
                        @if ($errors->has('monthly_due'))
                        <span class="text-danger" style="color: red">{{ $errors->first('monthly_due') }}</span>
                        @endif
                      </div></div>
                  <div class="col-md-8 offset-md-2">
                  
                    <label>Bed Status</label>
                    <div class="form-group">
                        <select class="form-control" name="bed_status">
                            <option value="occupied" {{ $selectbed->bed_status == 'occupied' ? 'selected' : '' }}>Occupied</option>
                            <option value="available" {{ $selectbed->bed_status == 'available' ? 'selected' : '' }}>Available</option>
                        </select>
                </div></div>
                </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: `
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            `,
        });
    </script>
    @endif
    </x-app-layout>
