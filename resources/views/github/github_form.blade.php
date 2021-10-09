@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Fetch data ') }}</div>

                <div class="card-body">
                   <form action="{{ url('/get_git_data')}}" method="post">
                       @csrf
                       <div class="form-group row">
                            <label for="github_url" class="col-md-2 col-form-label text-md-right">{{ __('Git Url ') }}</label>

                            <div class="col-md-8">
                                <input id="github_url" type="text" class="form-control @error('github_url') is-invalid @enderror" name="github_url" value="{{ old('github_url') }}" required autocomplete="github_url" autofocus>

                               
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    @if(session()->has('class'))
                                <p class="{{session('class')}}" style="text-align:center;">{{session('message')}}</p>
                            @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
