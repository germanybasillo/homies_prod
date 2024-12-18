<x-app-layout>
    <x-slot name="header">
        <div class="content-header">
            <div class="container-fluid">
               <div class="row mb-2">
                  <div class="col-sm-6">
                     <h1 class="m-0 text-dark"><span class="fa fa-home"></span> Rooms Selected</h1>
                  </div>
                  <div class="col-sm-6">
                     <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Rooms Selected</li>
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
		       <th>Room No</th>
		       <th>Bed No</th>
			<th>Bed Status</th>
                       <th>Room Description</th>
                       <th>Room Image</th>
                       <th>Action</th>
                    </tr>
                 </thead>
		 <tbody>

         @foreach($hubrentals as $hubrental)
            <!-- Check if there are selecteds for the current hubrental -->
            @if ($hubrental->selecteds->isNotEmpty())
                <!-- Display Hubrental name row only if there are selected records -->
                <tr>
                    <td colspan="6" class="text-center"><strong>Hubrental: {{ $hubrental->address }}</strong></td>
                </tr>

                @foreach ($hubrental->selecteds as $selected)

                    <tr>
		       <td>{{$selected->room_no}}</td>
                       <td>{{$selected->bed_no}}</td>
                        <td>{{$selected->bed_status}}</td>
                       <td>{{$selected->description}}</td>
                       <td>
                        @php
                        $profiles = [
                            ['profile' => 'profile1', 'caption' => 'caption1'],
                            ['profile' => 'profile2', 'caption' => 'caption2'],
                            ['profile' => 'profile3', 'caption' => 'caption3'],
                            ['profile' => 'profile4', 'caption' => 'caption4'],
                            ['profile' => 'profile5', 'caption' => 'caption5'],
                            ['profile' => 'profile6', 'caption' => 'caption6'],
                        ];
                    @endphp
                    
                    <div class="flip-container">
                        @foreach ($profiles as $profile)
                            @php
                                $profilePath = $selected->{$profile['profile']};
                                $captionText = $selected->{$profile['caption']};
                                $imagePath = storage_path('app/public/' . $profilePath); // Adjusted to point to the correct path
                                $isImageExists = file_exists($imagePath);
                            @endphp
                            @if ($profilePath)
                                <div class="flip-card">
                                    <div class="flip-card-inner">
                                        <div class="flip-card-front">
                                            <img 
                                                src="{{ $isImageExists ? asset('storage/' . $profilePath) : asset($profilePath) }}" 
                                                alt="Image {{ $loop->index + 1 }}"
                                                class="flip-image"
                                            >
                                        </div>
                                        <div class="flip-card-back">
                                            <p class="caption-text">{{ $captionText }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    </td>
                       <td class="text-right">
                          <a class="btn btn-sm btn-success" href="/selecteds/{{$selected->id}}"><i
                                class="fa fa-edit"></i></a>
                          <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal{{$selected->id}}"><i
                                class="fa fa-trash-alt"></i></a>
                       </td>
                    </tr>
                    <div id="deleteModal{{$selected->id}}" class="modal animated rubberBand delete-modal" role="dialog">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form id="deleteForm{{$selected->id}}" action="{{ route('selecteds.destroy', $selected->id) }}" method="post">
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
		    @endif
                  @endforeach
                 </tbody>
              </table>                    
            </div>
        </div>
    </div>
</div>

<style>
    .flip-container {
        display: flex;               /* Use flex to arrange children in a line */
        flex-direction: row;        /* Ensure items are in a single row */
        overflow: hidden;           /* Hide any overflow */
        white-space: nowrap;        /* Keep items in a single line */
        justify-content: flex-start; /* Aligns items to the start */
    }

    .flip-card {
        width: 50px;                /* Default width of each flip card */
        height: 50px;               /* Default height of each flip card */
        perspective: 1000px;        /* Perspective for 3D effect */
        margin: 0;                  /* Remove margins */
        padding: 0;                 /* Remove padding */
    }

    .flip-card-inner {
        position: relative;
        width: 100%;
        height: 100%;
        text-align: center;
        transition: transform 0.6s;
        transform-style: preserve-3d;
        cursor: pointer;
    }

    .flip-card:hover .flip-card-inner {
        transform: rotateY(180deg);
    }

    .flip-card-front, .flip-card-back {
        position: absolute;
        width: 100%;
        height: 100%;
        backface-visibility: hidden;
        border: 2px solid gray;
        border-radius: 8px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .flip-card-front {
        background-color: #fff;
    }

    .flip-card-front img {
        width: 100%;
        height: 100%;
        object-fit: cover; /* Make sure images cover the card without distortion */
    }

    .flip-card-back {
        background-color: #f8f9fa;
        transform: rotateY(180deg);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px; /* If you want padding here, you can keep this; otherwise, remove it */
    }

    .caption-text {
        font-size: 12px; /* Reduced font size for small screens */
        color: #333;
    }

    /* Responsive adjustments */
    @media (min-width: 600px) {
        .flip-card {
            width: 75px;   /* Adjust size for larger screens */
            height: 75px;
        }
        
        .caption-text {
            font-size: 14px; /* Adjust caption font size */
        }
    }

    @media (min-width: 900px) {
        .flip-card {
            width: 100px;  /* Adjust size for larger screens */
            height: 100px;
        }

        .caption-text {
            font-size: 16px; /* Adjust caption font size */
        }
    }
</style>

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
