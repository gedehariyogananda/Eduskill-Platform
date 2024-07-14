@extends('templates.master')
@section('title', 'Detail Data Courses')
@section('page-name', 'Detail Data Courses')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/extensions/simple-datatables/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/scss/pages/simple-datatables.scss') }}">
@endpush
@section('content')

<section class="section">
    <div class="card">
        <div class="container ">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <a class="btn" href="{{ route('course.index') }}"><i class="fa fa-arrow-left"></i></a>
                    <a href="{{ route('course.addCourses', $slug) }}" class="btn btn-primary"><i class="fa fa-plus"></i>
                        Add Video</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="table2">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Duration Course</th>
                        <th>Title Course</th>
                        <th>Transkrip Course</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($courseDetails->course_details as $course)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $course->duration_course }}</td>
                        <td>{{ $course->title_course }}</td>
                        <td>{{ $course->transkrip_course }}</td>
                        <td>{{ $course->created_at->format('d F Y') }}</td>
                        <td>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modalVideo{{ $course->id }}"><i class="fa fa-video"></i></button>
                            <a href="{{ route('course.editCourses', $course->slug_course) }}"
                                class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></a>
                            <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $course->slug_course }}"><i
                                    class="fa fa-trash"></i></button>
                        </td>
                    </tr>

                    <!-- modalVideos -->
                    <div class="modal fade" id="modalVideo{{ $course->id }}" tabindex="-1"
                        aria-labelledby="modalVideo{{ $course->id }}Label" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="modalVideo{{ $course->id }}Label">{{
                                        $course->title_course }}</h1>
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
                    document.getElementById("table2")
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
                        window.location.href = '/data-courses/' + slug + '/delete';
                    }
                });
            });
        });
    });
</script>
@endpush