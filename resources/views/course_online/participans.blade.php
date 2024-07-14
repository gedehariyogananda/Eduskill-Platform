@extends('templates.master')
@section('title', 'Detail Data User')
@section('page-name', 'Detail Data User')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/extensions/simple-datatables/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/scss/pages/simple-datatables.scss') }}">
@endpush
@section('content')

<section class="section">
    <div class="card">
        <div class="container ">
            <div class="card-header">
                <a class="btn" href="javascript:history.back()">
                    <i class="fa fa-arrow-left"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="table3">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name Participan</th>
                        <th>Email</th>
                        <th>Payment Method</th>
                        <th>Amount Payment</th>
                        <th>Status Payment</th>
                        @if($slugId->category_course == "Private Course")
                        <th>Packet Class</th>
                        @endif
                        <th>Joined At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($courseParticipans as $course)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $course->user->name }}</td>
                        <td>{{ $course->user->email }}</td>
                        <td>
                            {{ $course->course->payment_gateway ? $course->course->payment_gateway->payment_method :
                            "Free" }}
                        </td>
                        <td>
                            {{ $course->course->payment_gateway ? $course->course->payment_gateway->amount_payment
                            :"Free" }}
                        </td>
                        <td>
                            <span class="badge bg-success">Paid</span>
                        </td>
                        @if($slugId->category_course == "Private Course")
                        <td>{{ $course->packet_class->name_packet_class }}</td>
                        @endif
                        <td>{{ $course->created_at->format('d F Y') }}</td>
                    </tr>

                    <!-- modalVideos -->
                    <div class="modal fade" id="modalVideo{{ $course->id }}" tabindex="-1"
                        aria-labelledby="modalVideo{{ $course->id }}Label" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="modalVideo{{ $course->id }}Label">Akaudawudaw</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-2">
                                    <div class="ratio ratio-16x9">
                                        <iframe class="embed-responsive-item" src="{{ $course->url_video_course }}"
                                            allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- endModal --}}
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</section>
</div>
@endsection

@push('scripts')
<script src="{{ asset ('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
<script>
    let dataTable = new simpleDatatables.DataTable(
                    document.getElementById("table3")
                )               
</script>
@endpush