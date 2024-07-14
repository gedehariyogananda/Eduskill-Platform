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
                {{-- <select class="form-select w-25" id="sortingSelect">
                    <option value="{{ route('rawatjalan.index') }}" {{ request()->is('rawat-jalan/detail-kunjungan')
                        ? 'selected disabled' : '' }}>Semua Data Kunjungan</option>
                    <option value="{{ route('rawatjalan.sudahPemeriksaan') }}" {{ request()->
                        is('rawat-jalan/detail-kunjungan/sudah-pemeriksaan') ? 'selected disabled' : '' }}>Sudah
                        Pemeriksaan</option>
                    <option value="{{ route('rawatjalan.belumPemeriksaan') }}" {{ request()->
                        is('rawat-jalan/detail-kunjungan/belum-pemeriksaan') ? 'selected disabled' : '' }}>Belum
                        Pemeriksaan</option>
                </select> --}}
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="table1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Institusi</th>
                        <th>Is Verification</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($userSubscription as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->roles }}</td>
                        <td>{{ $user ? $user->institusi : "-" }}</td>
                        <td>
                            @if($user->is_verified_register == 1)
                            <span class="badge bg-success">Verified</span>
                            @else
                            <span class="badge bg-danger">Not Verified</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</section>
</div>

@push('scripts')
<script src="{{ asset ('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
<script>
    let dataTable = new simpleDatatables.DataTable(
                    document.getElementById("table1")
                )               
</script>
@endpush

@endsection