@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Issue list ') }}</div>
                <div class="card-body">
                <table class="table table-bordered mb-5">
                <thead>
                    <tr class="table-success">
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Current Status</th>
                        <th scope="col">Tags</th>
                    </tr>
                </thead>
                    <tbody>
                        <?php $i=1; ?>
                        @foreach($data as $row)
                        
                        <tr>
                            <th scope="row">{{($data->currentPage() - 1) * $data->perPage() + $loop->iteration}}</th>
                            <td>{{ $row->title }}</td>
                            <td>{{ $row->status }}</td>
                            <td>{{ $row->tags }}</td>
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
</div><style>
    svg{
        width:50px;
    }
    .flex-1{
        display:none;
    }
    </style>
@endsection
