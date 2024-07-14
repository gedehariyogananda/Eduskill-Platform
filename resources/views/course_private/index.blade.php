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
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddDatas">
                    <i class="bi bi-plus"></i> Add Data Privat Course
                </button>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="table4">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Institusi</th>
                        <th>Description Pivate Course</th>
                        <th>Teaching</th>
                        <th>Price Private</th>
                        <th>Salary Teaching</th>
                        <th>Net Funds</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($coursePrivatDatas as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->institusi }}</td>
                        <td>{{ $user->description_private_course }}</td>
                        <td>{{ $user->teaching_private_course }}</td>
                        <td> <span class="badge bg-primary"> {{ 'Rp. ' . number_format($user->deal_price_private_course,
                                0, ',', '.') }}</span>
                        </td>
                        <td> <span class="badge bg-danger"> {{ 'Rp. ' . number_format($user->salary_teaching, 0, ',',
                                '.') }}</span>
                        </td>
                        <td>
                            <span class="badge bg-success">{{ 'Rp. ' . number_format($user->net_funds_course, 0, ',',
                                '.') }}</span>

                        </td>
                        <td>

                            {{-- init modal see all datas --}}
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#modalDatas{{ $user->id }}">
                                <i class="bi bi-eye"></i>
                            </button>

                            <div class="modal fade" id="modalDatas{{ $user->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Detail Data Private Course
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group form-md-floating-label">
                                                            <label for="name">Name</label>
                                                            <input type="text" class="form-control" id="name"
                                                                name="name" value="{{ $user->name }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group form-md-floating-label">
                                                            <label for="email">Email</label>
                                                            <input type="text" class="form-control" id="email"
                                                                name="name" value="{{ $user->email }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group form-md-floating-label">
                                                            <label for="institusi">Institusi</label>
                                                            <input type="text" class="form-control" id="institusi"
                                                                name="institusi" value="{{ $user->institusi }}"
                                                                readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group form-md-floating-label">
                                                            <label for="major">Major</label>
                                                            <input type="text" class="form-control" id="major"
                                                                name="major" value="{{ $user->major }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group form-md-floating-label">
                                                            <label for="description_private_course">Description Private
                                                                Course</label>

                                                            <textarea class="form-control"
                                                                id="description_private_course"
                                                                name="description_private_course" rows="3"
                                                                readonly>{{ $user->description_private_course }}</textarea>


                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group form-md-floating-label">
                                                            <label for="teaching_private_course">Teaching Private
                                                                Course</label>
                                                            <input type="text" class="form-control"
                                                                id="teaching_private_course"
                                                                name="teaching_private_course"
                                                                value="{{ $user->teaching_private_course }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group form-md-floating-label">
                                                            <label for="description_teaching_private_course">Description
                                                                Teaching</label>
                                                            <textarea class="form-control"
                                                                id="description_teaching_private_course"
                                                                name="description_teaching_private_course" rows="3"
                                                                readonly>{{ $user->description_teaching_private_course }}</textarea>


                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group form-md-floating-label">
                                                            <label for="deal_price_private_course">Price Private
                                                                Course</label>
                                                            <input type="text" class="form-control"
                                                                id="deal_price_private_course"
                                                                name="deal_price_private_course"
                                                                value="{{ 'Rp. ' . number_format($user->deal_price_private_course, 0, ',', '.') }}"
                                                                readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group form-md-floating-label">
                                                            <label for="salary_teaching">Salary Teaching</label>
                                                            <input type="text" class="form-control" id="salary_teaching"
                                                                name="salary_teaching"
                                                                value="{{ 'Rp. ' . number_format($user->salary_teaching, 0, ',', '.') }}"
                                                                readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group form-md-floating-label">
                                                            <label for="net_funds_course">Net Funds</label>
                                                            <input type="text" class="form-control"
                                                                id="net_funds_course" name="net_funds_course"
                                                                value="{{ 'Rp. ' . number_format($user->net_funds_course, 0, ',', '.') }}"
                                                                readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- end modal see all datas --}}

                            {{-- init modal edit datas --}}
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#modalEditDatas{{ $user->id }}">
                                <i class="bi bi-pencil"></i>
                            </button>

                            <div class="modal fade" id="modalEditDatas{{ $user->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Data Private Course
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('courseprivate.update', $user->id) }}" method="post">
                                                @csrf
                                                @method('PATCH')
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group form-md-floating-label">
                                                                <label for="name">Name</label>
                                                                <input type="text" class="form-control" id="name"
                                                                    name="name" value="{{ $user->name }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group form-md-floating-label">
                                                                <label for="email">Email</label>
                                                                <input type="text" class="form-control" id="email"
                                                                    name="email" value="{{ $user->email }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group form-md-floating-label">
                                                                <label for="institusi">Institusi</label>
                                                                <input type="text" class="form-control" id="institusi"
                                                                    name="institusi" value="{{ $user->institusi }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group form-md-floating-label">
                                                                <label for="major">Major</label>
                                                                <input type="text" class="form-control" id="major"
                                                                    name="major" value="{{ $user->major }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group form-md-floating-label">
                                                                <label for="description_private_course">Description
                                                                    Private Course</label>
                                                                <textarea class="form-control"
                                                                    id="description_private_course"
                                                                    name="description_private_course"
                                                                    rows="3">{{ $user->description_private_course }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group form-md-floating-label">
                                                                <label for="teaching_private_course">Teaching Private
                                                                    Course</label>
                                                                <input type="text" class="form-control"
                                                                    id="teaching_private_course"
                                                                    name="teaching_private_course"
                                                                    value="{{ $user->teaching_private_course }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group form-md-floating-label">
                                                                <label
                                                                    for="description_teaching_private_course">Description
                                                                    Teaching</label>
                                                                <textarea class="form-control"
                                                                    id="description_teaching_private_course"
                                                                    name="description_teaching_private_course"
                                                                    rows="3">{{ $user->description_teaching_private_course }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group form-md-floating-label">
                                                                <label for="deal_price_private_course">Price Private
                                                                    Course</label>
                                                                <input type="number" class="form-control"
                                                                    id="deal_price_private_course"
                                                                    name="deal_price_private_course"
                                                                    value="{{ $user->deal_price_private_course }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group form-md-floating-label">
                                                                <label for="salary_teaching">Salary Teaching</label>
                                                                <input type="number" class="form-control"
                                                                    id="salary_teaching" name="salary_teaching"
                                                                    value="{{ $user->salary_teaching }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-between">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>

                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            {{-- end modal edit datas --}}

                            {{-- delete button --}}
                            <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $user->id }}"><i
                                    class="fa fa-trash"></i></button>
                            {{-- end delete button --}}
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</section>
</div>

{{-- Modal Add Data --}}

<div class="modal fade" id="modalAddDatas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Data User Private Course
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('courseprivate.store') }}" method="post">
                    @csrf
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-md-floating-label">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group form-md-floating-label">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" id="email" name="email">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group form-md-floating-label">
                                    <label for="institusi">Institusi</label>
                                    <input type="text" class="form-control" id="institusi" name="institusi">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group form-md-floating-label">
                                    <label for="major">Major</label>
                                    <input type="text" class="form-control" id="major" name="major">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group form-md-floating-label">
                                    <label for="description_private_course">Description
                                        Private Course</label>
                                    <textarea class="form-control" id="description_private_course"
                                        name="description_private_course" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group form-md-floating-label">
                                    <label for="teaching_private_course">Teaching Private
                                        Course</label>
                                    <input type="text" class="form-control" id="teaching_private_course"
                                        name="teaching_private_course">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group form-md-floating-label">
                                    <label for="description_teaching_private_course">Description
                                        Teaching</label>
                                    <textarea class="form-control" id="description_teaching_private_course"
                                        name="description_teaching_private_course" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group form-md-floating-label">
                                    <label for="deal_price_private_course">Price Private
                                        Course</label>
                                    <input type="number" class="form-control" id="deal_price_private_course"
                                        name="deal_price_private_course">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group form-md-floating-label">
                                    <label for="salary_teaching">Salary Teaching</label>
                                    <input type="number" class="form-control" id="salary_teaching"
                                        name="salary_teaching">
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>

            </div>
            </form>
        </div>
    </div>
</div>

{{-- end modal add datas --}}

@push('scripts')
<script src="{{ asset ('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
<script>
    let dataTable = new simpleDatatables.DataTable(
                    document.getElementById("table4")
                )               
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-btn');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const slug = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You will not be able to recover this course!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect to delete route
                        window.location.href = '/data-courses-private/' + slug + '/deleted';
                    }
                });
            });
        });
    });
</script>
@endpush

@endsection