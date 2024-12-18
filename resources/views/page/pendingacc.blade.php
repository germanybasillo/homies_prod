<x-app-layout>
    <x-slot name="header">
    <div class="content-header">
        <div class="container-fluid">
           <div class="row mb-2">
              <div class="col-sm-6">
                 <h1 class="m-0 text-dark"><span class="fa fa-bed"></span>Rental Pending</h1>
              </div>
              <div class="col-sm-6">
                 <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Pending</li>
                 </ol>
              </div>
          </div>
        </div>
    </x-slot>
    <div class="container-fluid">
        <div class="card card-info elevation-2">
	   <br>

	   @php
           $users = \App\Models\User::where('user_type', 'rental_owner')->get();
	   @endphp
	  
           <div class="col-md-12 table-responsive">
              <table id="example1" class="table table-bordered table-hover">
                 <thead class="btn-cancel">
                    <tr>
                       <th>Email</th>
		       <th>Name</th>
			<th>Number</th>
                         <th>Document</th>
			<th>Valid Id</th>
			<th>Status</th>
                       	<th>Action</th> 
                    </tr>
                 </thead>
                 <tbody>
                    @foreach($users as $user)
                    <tr>
                       <td>{{$user->email}}</td>
		       <td>{{$user->name}}</td>
		       <td>{{$user->number}}</td>
		       <td>
@if($user->document)
    <div class="document-container">
        <!-- Link to Download the Document -->
        <a href="{{ asset($user->document) }}" class="btn btn-primary" download>
            Download Document
        </a>
    </div>
@endif

</td>



			  <td>
			   @if($user->valid_id)
        @if(file_exists(public_path('storage/' . $user->valid_id)))
            <img src="{{ asset('storage/' . $user->valid_id) }}" alt="Valid Id" class="profile-image" onclick="viewImage(this)">
        @else
            <img src="{{ asset($user->valid_id) }}" alt="Valid Id" class="profile-image" onclick="viewImage(this)">
        @endif
	@endif               
	</td>
<td>{{$user->status}}</td>


                       <td class="text-right">
                          <a class="btn btn-sm btn-success" href="#" id="changestatus" data-id="{{$user->id}}" data-status="{{$user->status}}"><i class="fa fa-edit"></i></a>
                          <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal{{$user->id}}"><i
                                class="fa fa-trash-alt"></i></a>
		       </td>
                               </tr>
                    <div id="deleteModal{{$user->id}}" class="modal animated rubberBand delete-modal" role="dialog">
                      <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                              <form id="deleteForm{{$user->id}}" action="{{ route('users.destroy', $user->id) }}" method="post">
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

<!-- Add the CSS in your Blade template or external stylesheet -->
<style>
    .profile-image {
        width: 50px;
        height: 50px;
        object-fit: cover;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    /* Optional: Add hover effect to make it clear it's clickable */
    .profile-image:hover {
        opacity: 0.7;
    }
</style>


<!-- JavaScript to view image in full size on click -->
<script>
    function viewImage(imageElement) {
        // Create a modal to view the image in full size
        const modal = document.createElement('div');
        modal.style.position = 'fixed';
        modal.style.top = '0';
        modal.style.left = '0';
        modal.style.width = '100%';
        modal.style.height = '100%';
        modal.style.backgroundColor = 'rgba(0, 0, 0, 0.7)';
        modal.style.display = 'flex';
        modal.style.alignItems = 'center';
        modal.style.justifyContent = 'center';
        modal.style.zIndex = '9999';

        const modalImage = document.createElement('img');
        modalImage.src = imageElement.src;
        modalImage.style.maxWidth = '100%';
        modalImage.style.maxHeight = '100%';
        modalImage.style.objectFit = 'contain';

        modal.appendChild(modalImage);
        document.body.appendChild(modal);

        // Close the modal when clicked
        modal.addEventListener('click', function() {
            document.body.removeChild(modal);
        });
    }
</script>











<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('#changestatus').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();

                // Get user data from button attributes
                const userId = this.getAttribute('data-id');
                const userStatus = this.getAttribute('data-status');

                // Show SweetAlert modal
                Swal.fire({
                    title: 'Change User Status',
                    html: `
                        <form id="statusForm" action="/users/${userId}/status" method="POST">
                            @csrf
                            @method('PATCH')
                            <label for="status">Status:</label>
                            <select name="status" id="statusSelect" class="swal2-input">
                                <option value="pending" ${userStatus === 'pending' ? 'selected' : ''}>Pending</option>
                                <option value="approaved" ${userStatus === 'approaved' ? 'selected' : ''}>Approved</option>
                            </select>
                        </form>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Update',
                    preConfirm: () => {
                        // Submit the form
                        const form = document.getElementById('statusForm');
                        form.submit();
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
