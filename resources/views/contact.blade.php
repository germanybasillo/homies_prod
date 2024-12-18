<x-app-layout>
    <x-slot name="header">
    <div class="content-header">
        <div class="container-fluid">
           <div class="row mb-2">
              <div class="col-sm-6">
                 <h1 class="m-0 text-dark"><span class="fa fa-envelope"></span> Contacts Form</h1>
              </div>
              <div class="col-sm-6">
                 <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Contact Form</li>
                 </ol>
              </div>
          </div>
        </div>
    </x-slot>
    <div class="container-fluid">
        <div class="card card-info elevation-2">
           <br>
           <div class="col-md-12 table-responsive">
              <table id="example1" class="table table-bordered table-hover">
                 <thead class="btn-cancel">
                    <tr>
                       <th>Contact Id</th>
                       <th>Name</th>
                       <th>Email</th>
		       <th>Comment</th>
                     </tr>
                 </thead>
                 <tbody>
		 @foreach ($contacts as $contact)
		 <tr>
                       <td>{{$contact->id}}</td>
                       <td>{{ $contact->name }}</td>
		       <td>{{ $contact->email }}</td>
			<td>{{ $contact->comment }}</td>
                     </tr> 
                  </div>
                 @endforeach
               </tbody>
            </table>                    
          </div>
      </div>
    </div>
    </div>    
    </x-app-layout>
