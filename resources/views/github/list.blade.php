@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Fetch data ') }}</div>
                <div class="card-body">
                @if(session()->has('class'))
                                <p class="{{session('class')}}" style="text-align:center;">{{session('message')}}</p>
                            @endif
                <table class="table table-bordered mb-5">
                <thead>
                    <tr class="table-success">
                        <th scope="col">#</th>
                        <th scope="col">Repo name</th>
                        <th scope="col">Created User</th>
                        <th scope="col">Created at</th>
                    </tr>
                </thead>
                    <tbody>
                        <?php $i=1; ?>
                        @foreach($data as $row)
                        
                        <tr>
                            <th scope="row">{{($data->currentPage() - 1) * $data->perPage() + $loop->iteration}}</th>
                            <td>{{ $row->name }}</td>
                            <td><a href="{{ url('/issue-list') }}/{{ $row->id }}">{{ $row->user->email }}</a></td>
                            <td>{{ $row->created_at }}</td>
                        </tr>
                        <?php $i++; ?>
                        @endforeach
                    </tbody>
                </table>
                 <div class="d-flex justify-content-center">
                     {!! $data->links() !!}
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    svg{
        width:50px;
    }
    .flex-1{
        display:none;
    }
    </style>
@endsection
