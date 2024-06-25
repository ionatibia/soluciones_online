@extends('layouts.app')

@section('content')
    <service-form></service-form>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                {{ __('Services') }}
                            </div>
                            <div class="col-md-6 text-end">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#createServiceModal">
                                    <i class="bi bi-plus-circle-fill h3"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (Route::current()->getName())
                            <services :onlymine="false"></services>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
