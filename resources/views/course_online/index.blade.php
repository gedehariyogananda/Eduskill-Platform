@extends('templates.master')
@section('title', 'Service Course Eduskill')
@section('page-name', 'Service Eduskill')

@push('styles')
<style>
    .card {
        border: none;
        height: 100%;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
    }

    .card:hover {
        transform: translateY(-10px);
    }

    .card-img-top {
        height: 150px;
        object-fit: cover;
        position: relative;
    }

    .card-footer {
        background-color: #f8f9fa;
        border-top: none;
        padding: 10px 15px;
    }

    .badge {
        font-size: 10px;
        padding: 5px 10px;
    }

    .badge-position {
        position: absolute;
        top: 10px;
        right: 10px;
    }

    .real-price {
        text-decoration: line-through;
        color: red;
    }

    .discount-price {
        font-size: 1.2em;
    }
</style>
@endpush

@section('content')

<div class="container my-2">
    @if(Route::Is('course.index'))
    <a class="btn btn-sm btn-primary" href="{{ route('course.create') }}"><i class="fa fa-plus"></i> Add New Course</a>
    @endif
    <div class="row mt-3">
        @foreach($allCourses as $course)
        <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
            <div class="card h-100">
                <div class="position-relative">
                    <img src="{{ asset('storage/'.$course->banner_course) }}" class="card-img-top"
                        alt="{{ $course->name_course }}">
                    @if($course->category_course == 'Private Course')
                    <span class="badge bg-dark badge-position">Private Course</span>
                    @else
                    <span class="badge bg-secondary badge-position">Online Course</span>
                    @endif
                </div>
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">{{ $course->name_course }}</h6>
                        <div>
                            @if($course->status_course == 'published')
                            <span class="badge bg-success">Publish</span>
                            @endif
                            @if($course->status_course == 'unpublished')
                            <span class="badge bg-danger">Not Publish</span>
                            @endif
                            @if($course->status_course == 'archived')
                            <span class="badge bg-danger">Archive</span>
                            @endif
                        </div>
                    </div>
                    <p class="mb-0">Teaching: {{ $course->instructor_course }}</p>

                    @if($course->category_course != "Private Course")
                    <h6 class="mb-0 mt-3">Price :
                        @if ($course->price_course == 0)
                        Free
                        @else
                        <span class="real-price">Rp. {{ number_format($course->price_course, 0, ',', '.') }}</span>
                        @endif
                    </h6>
                    <h6 class="mb-0 mt-3">Discount Price :
                        @if ($course->price_discount_course == 0)
                        Free
                        @else
                        Rp. {{ number_format($course->price_discount_course, 0, ',', '.') }}
                        @endif
                    </h6>
                    @endif

                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a class="btn btn-sm btn-primary"
                            href="{{ route('course.showParticipans', $course->slug_course) }}"><i
                                class="bi bi-people"></i>{{ $course->course_users->count() }} Participans </a>
                        @if($course->category_course != "Private Course")
                        <a href="{{ route('course.show', $course->slug_course) }}" class="btn btn-success btn-sm"><i
                                class="fa fa-play-circle"></i> {{ $course->course_details->count() }} Videos</a>
                        @endif
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <a href="{{ route('course.edit', $course->slug_course) }}" class="btn btn-sm btn-warning"><i
                                class="fa fa-pencil"></i>Edit</a>
                        @if($course->status_course != 'archived')
                        <button class="btn btn-sm btn-danger archives-btn" data-id="{{ $course->slug_course }}"><i
                                class="fa fa-archive"></i> Archive</button>
                        @endif
                        @if($course->status_course == 'archived')
                        <button class="btn btn-sm btn-info unarchives-btn" data-id="{{ $course->slug_course }}"><i
                                class="fa fa-undo"></i> Unarchive</button>
                        @endif
                        @if($course->status_course == 'published')
                        <button class="btn btn-sm btn-info delete-btn" data-id="{{ $course->slug_course }}"><i
                                class="fa fa-undo"></i> Unpublish</button>
                        @endif
                        @if($course->status_course == 'unpublished')
                        <button class="btn btn-sm btn-info restore-btn" data-id="{{ $course->slug_course }}"><i
                                class="fa fa-paper-plane"></i> Publish</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-btn');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const slug = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Are you sure to unpublish the course?',
                    text: 'Next you can publish this course!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, unpublish it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/course/archive/' + slug;
                    }
                });
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.restore-btn');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const slug = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Are you sure to publish the course?',
                    text: 'The course will be openned again!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, publish it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect to delete route
                        window.location.href = '/course/unarchive/' + slug;
                    }
                });
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.archives-btn');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const slug = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Are you sure to archive the course?',
                    text: 'Next u can to recovery this course!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, archive it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect to delete route
                        window.location.href = '/course/archives/' + slug;
                    }
                });
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.unarchives-btn');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const slug = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Are you sure to unarchives the course?',
                    text: 'By default, status will be Not Published!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, Unarchive it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect to delete route
                        window.location.href = '/course/recovery/' + slug;
                    }
                });
            });
        });
    });
</script>


@endpush