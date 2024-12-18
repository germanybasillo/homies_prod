<x-app-layout>
    <x-slot name="header">
    <div class="content-header">
        <div class="container-fluid">
           <div class="row mb-2">
              <div class="col-sm-6">
                 <h1 class="m-0 text-dark"><span class="fa fa-bed"></span>Hub Rental</h1>
              </div>
              <div class="col-sm-6">
                 <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Hub Rental</li>
                 </ol>
              </div>
          </div>
        </div>
    </x-slot>
    <div class="container-fluid">
        <div class="card card-info elevation-2">
	   <br>

	   @php
          $hubrentals = \App\Models\Hubrental::all();
	   @endphp
	  
           <div class="col-md-12 table-responsive">
              <table id="example1" class="table table-bordered table-hover">
                 <thead class="btn-cancel">
                    <tr>
                       <th>Name</th>
                       <th>Type</th>
                       <th>Latitude</th>
		       <th>Longitude</th>
                        <th>Address</th>
			<th>Price</th>
                        <th>Status</th>
			<th>Action</th> 
                    </tr>
                 </thead>
                 <tbody>
                    @foreach($hubrentals as $hubrental)
                    <tr>
                       <td>{{$hubrental->name}}</td>
		       <td>{{$hubrental->type}}</td>
                       <td>{{$hubrental->lat}}</td>
		       <td>{{$hubrental->lng}}</td>
                       <td>{{$hubrental->address}}</td>
		       <td>{{$hubrental->price}}</td>
                       <td>{{$hubrental->status}}</td>
                       <td class="text-right">
                          <a class="btn btn-sm btn-success" href="#" id="changestatus" data-id="{{$hubrental->id}}" data-status="{{$hubrental->status}}"><i class="fa fa-edit"></i></a>
                          <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal{{$hubrental->id}}"><i
                                class="fa fa-trash-alt"></i></a>
                       </td>
                    </tr>
                    <div id="deleteModal{{$hubrental->id}}" class="modal animated rubberBand delete-modal" role="dialog">
                      <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                              <form id="deleteForm{{$hubrental->id}}" action="{{ route('hubrentals.destroy', $hubrental->id) }}" method="post">
                                  @csrf
                                  @method('DELETE')
                                  <div class="modal-body text-center">
                                      <img src="{{asset('logo.png')}}" alt="Logo" width="50" height="46">
                                      <h3>Are you sure you want to delete this Operator?</h3>
                                      <div class="m-t-20">
                                          <button type="button" class="btn btn-white" data-dismiss="modal" style="background-color: blue;color:white;border-color:blue;">Close</button>
                                          <button type="submit" class="btn btn-danger">Delete</button>
                                      </div>
                                  </div>
                              </form>
                          </div>
                      </div>
                  </div>
                 @endforeach
               </tbody>
            </table>                    
          </div>
      </div>
    </div>
    </div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('#changestatus').forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const hubrentalId = this.getAttribute('data-id');
            const currentStatus = this.getAttribute('data-status');

            Swal.fire({
                title: 'Change Status',
                html: `
                    <form id="statusForm" action="/hubrentals/${hubrentalId}/status" method="POST">
                        <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                        <div class="form-group">
                            <label for="status">Change Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="pending" ${currentStatus === 'pending' ? 'selected' : ''}>Pending</option>
                                <option value="paid" ${currentStatus === 'paid' ? 'selected' : ''}>Approved</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Update Status</button>
                    </form>
                `,
                showCancelButton: true,
                showConfirmButton: false,
                cancelButtonText: 'Close',
                didOpen: () => {
                    const form = document.getElementById('statusForm');
                    form.addEventListener('submit', function (e) {
                        e.preventDefault();

                        fetch(form.action, {
                            method: 'POST',
                            body: new FormData(form),
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Success', 'Status updated successfully!', 'success').then(() => {
                                    location.reload(); // Reload to reflect changes
                                });
                            } else {
                                Swal.fire('Error', data.message || 'Failed to update status.', 'error');
                            }
                        })
                        .catch(error => {
                            Swal.fire('Error', 'An unexpected error occurred.', 'error');
                        });
                    });
                }
            });
        });
    });
});
</script>







    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
    <script>
     Swal.fire({
         title: 'Success!',
         text: "{{ session('success') }}",
         icon: 'success',
         confirmButtonText: 'OK'
     });
    </script>
    @endif    
    </x-app-layout>
