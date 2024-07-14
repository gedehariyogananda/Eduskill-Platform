@extends('templates.master')
@section('title', 'Service Courses')
@section('page-name', 'Service Course')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="card-title"><a class="btn" href="{{ route('course.show', $routeCourse) }}"><i
                    class="fa fa-arrow-left"></i></a>
        </div>

        @if(Route::is('course.editCourses'))
        <form action="{{ route('course.updateCourses', $course->slug_course) }}" method="POST">
            @csrf
            @method('patch')
            @endif

            @if(Route::is('course.addCourses'))
            <form action="{{ route('course.addCourses', $course->slug_course) }}" method="POST">
                @csrf
                @endif
                <div class="form-group">
                    <label for="title_course">Title</label>
                    <input type="text" name="title_course" id="title_course" class="form-control" required
                        value="{{ old('title_course', $course->title_course ?? '') }}">
                    @error('title_course')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="url_video_course">Video URL</label>
                    <input type="text" name="url_video_course" id="url_video_course" class="form-control"
                        pattern="https:\/\/www\.youtube\.com\/embed\/[a-zA-Z0-9_-]{11}(\?.*)?"
                        placeholder="https://www.youtube.com/embed/VIDEO_ID?params" required
                        value="{{ old('url_video_course', $course->url_video_course ?? '') }}">
                    <small class="form-text text-muted">Enter a valid YouTube embed URL.</small>
                    @error('url_video_course')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="duration_course">Duration</label>
                    <input type="text" name="duration_course" id="duration_course" class="form-control"
                        pattern="^([0-1]?[0-9]|2[0-3]):([0-5]?[0-9]):([0-5]?[0-9])$" placeholder="Example: 01:30:00"
                        required value="{{ old('duration_course', $course->duration_course ?? '') }}">
                    <small class="form-text text-muted">Enter duration in HH:MM:SS format.</small>
                    @error('duration_course')
                    <div class="text-danger">
                        {{ $message }}

                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="transkrip_course">Transcript</label>
                    <textarea name="transkrip_course" id="transkrip_course" class="form-control" rows="5"
                        required>{{ old('transkrip_course', $course->transkrip_course ?? '') }}</textarea>
                    @error('transkrip_course')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('duration_course').addEventListener('input', function (e) {
        const pattern = /^([0-1]?[0-9]|2[0-3]):([0-5]?[0-9]):([0-5]?[0-9])$/;
        const value = e.target.value;
        if (!pattern.test(value)) {
            e.target.setCustomValidity('Please enter a valid duration in HH:MM:SS format. Example : 01:30:00');
        } else {
            e.target.setCustomValidity('');
        }
    });
</script>

<script>
    document.getElementById('url_video_course').addEventListener('input', function (e) {
        const pattern = /^https:\/\/www\.youtube\.com\/embed\/[a-zA-Z0-9_-]{11}(\?.*)?$/;
        const value = e.target.value;
        if (!pattern.test(value)) {
            e.target.setCustomValidity('Please enter a valid YouTube embed URL.');
        } else {
            e.target.setCustomValidity('');
        }
    });
</script>
@endpush