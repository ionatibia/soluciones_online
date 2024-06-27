@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create Service') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('service.store') }}" enctype="multipart/form-data">
                            @csrf
                            {{-- Title --}}
                            <div class="row mb-3">
                                <label for="title"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Title') }}</label>

                                <div class="col-md-6">
                                    <input id="title" type="text"
                                        class="form-control @error('title') is-invalid @enderror" name="title"
                                        value="{{ old('title') }}" required autocomplete="title" autofocus>

                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            {{-- Description --}}
                            <div class="row mb-3">
                                <label for="description"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Description') }}</label>

                                <div class="col-md-6">
                                    <textarea id="description" type="text" class="form-control @error('description') is-invalid @enderror"
                                        name="description" value="{{ old('description') }}" required autocomplete="description" autofocus rows="6"></textarea>

                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            {{-- Image --}}
                            <div class="row mb-3">
                                <label for="image"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Image') }}</label>

                                <div class="col-md-6">
                                    <input id="image" type="file" class="form-control" name="image"
                                        onchange="previewImg(this)">
                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            {{-- Preview image --}}
                            <div class="row mb-3">
                                <label for="previewImage"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Preview') }}</label>
                                <div class="col-md-6">
                                    <div id="previewImage" class="mb-3 text-center">
                                        <img id="preview" width="400" height="200"
                                            src="{{ '/assets/services/default.webp' }}" alt="">
                                    </div>
                                </div>
                            </div>
                            {{-- Is published --}}
                            <div class="row mb-3">
                                <label for="is_published"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Is published') }}</label>

                                <div class="col-md-6  form-check form-switch">
                                    <input id="is_published" type="checkbox" class="form-check-input" name="is_published"
                                        style="transform: scale(1.8);margin-top:10px;margin-left:10px">
                                    @error('is_published')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Buttons --}}
                            <div class="row mb-3 text-center">
                                <div class="col-md-6">
                                    <a href="{{ route('home') }}" type="button" class="btn btn-secondary btn-lg"
                                        style="width:150px">{{ __('Cancel') }}</a>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary btn-lg" style="width:150px">
                                        {{ __('Create') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function previewImg(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                let elem = document.getElementById('preview');
                console.log(elem);
                elem.src = e.target.result;
                elem.with = '100px';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
