@extends('layouts.app')

@section('content')
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
                                <a href="{{ route('service.create') }}" type="button" class="btn btn-primary">
                                    <i class="bi bi-plus-circle-fill h3"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <services :onlymine="true"></services>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
