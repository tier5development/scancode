@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 text-center">
            <div class="row justify-content-center">
                <br>
                <h1 style="flex: 100%;">FB Scan Code Generator</h1>
                <h2>A Free Tool with &#x1F496; by <a href="https://www.facebook.com/king.jon.vaughn" target="_blank">Jon Vaughn</a></h2>
                <h3>Tier5 Affiliates please generate a scancode <a href="{{ route('tier5') }}">here</a> for Tier5 page</h3>
                <iframe id="ytVideo" width="100%" height="644" src="https://www.youtube.com/embed/xvAe0iBDHNA?autoplay=1" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
            </div>
            <br>
            <div id="spinner"
                style="
                    background: #4267b2;
                    border-radius: 5px;
                    color: white;
                    height: 40px;
                    text-align: center;
                    width: 300px;
                    font-family: Nunito;
                    font-size: 20px;
                    padding: 4px;">
                <span id="loading">Loading...</span>
                <div class="fb-login-button"
                    data-max-rows="1"
                    data-width="300"
                    data-size="large"
                    data-button-type="continue_with"
                    data-use-continue-as="true"
                    data-default-audience="everyone"
                    data-scope="public_profile, email, manage_pages, pages_messaging"
                    data-onlogin="checkLoginState()"
                ></div>
            </div>
            <br>
            @if (count($scancodes))
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Latest Scancodes...</h5>
                        <p class="card-text">
                            <div class="row justify-content-center align-item-center">
                                @foreach ($scancodes as $scancode)
                                    <div class="col-sm-4">
                                        <img height="200" width="200" src="{{ $scancode->scan_code_uri }}" alt="{{ $scancode->facebook_page_name }}" srcset="{{ $scancode->scan_code_uri }}" data-toggle="tooltip" title="{{ $scancode->facebook_page_name }}" />
                                    </div>
                                @endforeach
                            </div>
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
