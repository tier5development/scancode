@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Generate scancode now
                    <a href="#" onclick="logout()" class="float-right">Log out</a>
                    <form action="{{ route('logout') }}" method="post" id="logout-form">
                        {{ csrf_field() }}
                    </form>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="from" role="form" id="auth-scancode-generate" method="get" action="{{ route('access_token.index') }}">
                        <input type="hidden" name="facebook_user" id="facebook-user" value="{{ $facebookUserId }}" />
                        <div class="form-group">
                            <label for="facebook-page">Facebook page <span class="text-danger">*</span></label>
                            <select name="facebook_page" class="form-control" id="facebook-page" required>
                                <option value="">Select one</option>
                                @foreach ($facebookPages as $facebookPage)
                                    <option value="{{ $facebookPage->id }}">{{ $facebookPage->name }}</option>
                                @endforeach
                            </select>
                            <p id="facebook-page-error-text" class="error-off">Please select one of your Facebook pages.</p>
                        </div>
                        <div class="form-group">
                            <label for="ref">Ref</label>
                            <input type="text" name="ref" id="ref" class="form-control" placeholder="Ref is a URL parameter which will postback to your page" />
                        </div>
                        <div class="form-group">
                            <label for="size">Image Size <span class="text-danger">*</span></label>
                            <select name="size" id="size" class="form-control" id="product" required>
                                <option value="">Select one</option>
                                @for ($size = 100; $size <= 2000; $size += 100)
                                    <option value="{{ $size }}">{{ "${size}x${size}" }}</option>
                                @endfor
                            </select>
                            <p id="size-error-text" class="error-off">Please select one of the image sizes.</p>
                        </div>
                        <div class="form-group">
                            <input type="submit" id="generate" class="btn btn-primary btn-md float-right" value="Generate" />
                        </div>
                    </form>

                    <div id="auth-scancode-display" class="text-center" style="margin-top: 50px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
