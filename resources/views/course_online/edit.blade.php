@extends('templates.master')
@section('title', 'Service Course')
@section('page-name', 'Service Course')
@push('styles')
{{-- Disini Tempat Buat Naruh Custom CSS (Mungkin Ada) But Not Mandatory --}}
@endpush
@section('content')
<div class="card">
    <div class="card-body">
        @if(Route::Is('course.edit'))
        <form action="{{ route('course.update', $course->slug_course) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            @endif

            @if(Route::Is('course.create'))
            <form action="{{ route('course.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @endif

                <div class="form-group">
                    <label for="name_course">Name</label>
                    <input type="text" class="form-control" id="name_course" name="name_course"
                        value="{{ old('name_course', $course->name_course ?? '') }}">
                    @error('name_course')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="instructor_course">Teaching</label>
                    <input type="text" class="form-control" id="instructor_course" name="instructor_course"
                        value="{{ old('instructor_course', $course->instructor_course ?? '') }}">
                    @error('instructor_course')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="experiences_instructor_course">Teaching Experiences</label>
                    <input type="text" class="form-control" id="experiences_instructor_course"
                        name="experiences_instructor_course"
                        value="{{ old('experiences_instructor_course', $course->experiences_instructor_course ?? '') }}">
                    @error('experiences_instructor_course')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="banner_course">Banner</label>
                    <input type="file" class="form-control" id="banner_course" name="banner_course" accept="image/*"
                        onchange="previewImage(event)">
                    <small class="form-text text-muted">Please upload an image with dimensions 400 x 500 pixels.</small>
                    <img id="preview" src="#" alt="Preview"
                        style="max-width: 400px; max-height: 500px; margin-top: 10px; display: none;">
                    @error('banner_course')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="category_course">Category</label>
                    <select class="form-control" id="category_course" name="category_course">

                        @if(Route::Is('course.edit'))
                        <option value="" disabled> -- Select Category -- </option>
                        <option value="Online Course" {{ old('category_course', $course->category_course ?? '') ==
                            'Online Course' ? 'selected' : '' }}>Online Course</option>
                        <option value="Private Course" {{ old('category_course', $course->category_course ?? '') ==
                            'Private Course' ? 'selected' : '' }}>Private Course</option>
                        @endif
                        @if(Route::Is('course.create'))
                        <option value="" disabled selected> -- Select Category -- </option>
                        <option value="Online Course">Online Course</option>
                        <option value="Private Course">Private Course</option>
                        @endif

                    </select>
                    @error('category_course')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description_course">Description</label>
                    <textarea class="form-control" id="description_course"
                        name="description_course">{{ old('description_course', $course->description_course ?? '') }}</textarea>
                    @error('description_course')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_free_course" name="is_free_course"
                            value="1" {{ old('is_free_course', $course->is_free_course ?? '') ? 'checked' : '' }}
                        onchange="togglePriceInput()">
                        <label class="form-check-label" for="is_free_course">Is Free Course</label>
                    </div>
                    <small class="form-text text-muted">Selected the checkbox to set free course.</small>
                    @error('is_free_course')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group" id="price_course_group">
                    <label for="price_course">Price</label>
                    <input type="number" class="form-control" id="price_course" name="price_course"
                        value="{{ old('price_course', $course->price_course ?? '') }}">
                    @error('price_course')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <label class="mt-2" for="price_course">Price Discount</label>
                    <input type="number" class="form-control" id="price_discount_course" name="price_discount_course"
                        value="{{ old('price_discount_course', $course->price_discount_course ?? '') }}">
                    @error('price_discount_course')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
    </div>
</div>

@endsection
@push('scripts')
<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('preview');
            output.src = reader.result;
            output.style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]);
    }

    function togglePriceInput() {
        var isFreeCourse = document.getElementById('is_free_course').checked;
        var priceDiscountInput = document.getElementById('price_discount_course');
        if (isFreeCourse) {
            priceDiscountInput.value = 0;
        } else {
            priceDiscountInput.value = "{{ old('price_discount_course', $course->price_discount_course ?? '') }}";
        }
    }

    // Call the function on page load to set the initial state
    togglePriceInput();
</script>
@endpush