@extends('back.layouts.master')
@section('title', 'Blogs')

@section('head')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.css"/>
@endsection

@section('master')
<div class="card border-light mt-3 shadow">
    <div class="card-header">
        <h5 class="d-inline-block">Blog list</h5>

        <a href="{{route('back.blogs.create')}}" class="btn btn-success btn-sm float-right"><i class="fas fa-plus"></i> Create new</a>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-sm" id="dataTable">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Status</th>
                <th scope="col" class="text-right">Action</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($blogs as $key => $blog)
                    <tr>
                        <th scope="row">{{$key + 1}}</th>
                        <td>{!! $blog->title !!}</td>
                        <td>
                            @include('switcher::switch', [
                                'table' => 'blogs',
                                'data' => $blog
                            ])
                        </td>
                        <td class="text-right">
                            <a class="btn btn-sm btn-success" href="{{route('back.blogs.edit', $blog->id)}}"><i class="fas fa-edit"></i></a>
                            <form class="d-inline-block" action="{{route('back.blogs.destroy', $blog->id)}}" method="POST">
                                @method('DELETE')
                                @csrf

                                <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Are you sure to remove?')"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('footer')
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.js"></script>

<script>
    $(document).ready( function () {
        $('#dataTable').DataTable({
            order: [[0, "asc"]],
        });
    });
</script>
@endsection
