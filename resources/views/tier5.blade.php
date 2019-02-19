@extends('layouts.app') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Generate scancode now for <a href="https://www.facebook.com/tier5development">Tier5</a> page</div>

                <div class="card-body">
                    <form class="from" role="form" id="tier5-scancode-generate" method="get" action="{{ route('access_token.index') }}">
                        <div class="form-group">
                            <label for="product">Product <span class="text-danger">*</span></label>
                            <select name="facebook_page" class="form-control" id="product" required>
                                <option value="">Select one</option>
                                @if (count($products))
                                    @foreach ($products as $product)
                                        <option value="{{ $product->name }}">{{ $product->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <p id="product-error-text" class="error-off">Please select one of the products.</p>
                        </div>
                        <div class="form-group">
                            <label for="affiliate-id">Affiliate ID <span class="text-danger">*</span></label>
                            <input type="text" name="affiliate_id" id="affiliate-id" class="form-control" placeholder="Your Tier5 Affiliate ID" required
                            />
                            <p id="affiliate-id-error-text" class="error-off">Please provide your Tier5 Affiliate ID.</p>
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

                    <div id="tier5-scancode-display" class="text-center" style="margin-top: 50px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
