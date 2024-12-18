<x-app-layout>
    <x-slot name="header">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark"><span class="fa fa-list-alt"></span> Collectibles</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Collectibles</li>
                        </ol>
                    </div>
                </div>
            </div>
        </x-slot>

        <div class="container-fluid">
            <div class="card card-info elevation-2">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover"> 
                            <thead>
                                <tr>
                                    <th>Tenant Name</th>
                                    <th>Room No.</th>
                                    <th>Bed No.</th>
                                    <th>Total Payment</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($paymentmessages->isEmpty())
                                    <tr>
                                        <td colspan="4" class="text-center">No data</td>
                                    </tr>
                                @elseif ($paymentmessages->first()->status === 'pending')
                                    <tr>
                                        <td colspan="4" class="text-center" style="color: red">Pending</td>
                                    </tr>
                                @elseif ($paymentmessages->first()->status === 'paid')
                                    {{-- Iterate over payment messages --}}
                                    @foreach ($paymentmessages as $paymentmessage)
                                        {{-- Get the corresponding booking message for this payment --}}
                                        @php
                                            $bookingmessage = $bookingmessages->firstWhere('sender_id', $paymentmessage->sender_id); 
                                        @endphp
                                        @if ($bookingmessage)
                                            <tr>
                                                <td>{{ $paymentmessage->sender->name }}</td>
                                                <td>{{ $bookingmessage->selected->room_no }}</td>
                                                <td>{{ $bookingmessage->selected->bed_no }}</td>
                                                <td>{{ $paymentmessage->total }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td><b>Total Collectible</b></td>
                                        <td>
                                            {{-- Sum the total payment from payment messages --}}
                                            {{ $paymentmessages->sum('total') }}
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
