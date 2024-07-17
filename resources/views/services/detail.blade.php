@extends('layouts.app')

@section('content')
    <div class="container mb-3">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12">
                                {{ $service->title }}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-12 text-center">
                                <div class="mb-3 text-center">
                                    <img id="preview" width="500" height="300" src="{{ $service->img_src }}"
                                        alt="">
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-12 text-center">
                                <div class="mb-3 text-center">
                                    {{ $service->description }}
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-12 text-center">
                                <div class="mb-3 text-center">
                                    {{ $service->price }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- CHAT / CHATS --}}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12">
                                @if (Auth::user()->id === $service->user_id)
                                    Chats
                                @else
                                    Chat
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
{{-- Auth::user()->name  --}}
