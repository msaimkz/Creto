@extends('Admin.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    @include('Admin.message')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Users</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('User-Export').'?keyword='.Request::get('keyword') }}" class="btn btn-primary">Download Excel</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <a href="{{route('user')}}" class="btn btn-primary">Reset</a>
                    <div class="card-tools">
                        <form action="" method="get">
                            <div class="input-group input-group" style="width: 250px;">
                                <input type="text" name="keyword" class="form-control float-right" placeholder="Search" value="{{Request::get('keyword')}}">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th width="60">ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone No</th>

                                <th>Registration Date</th>
                                <th width="100">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($users))
                            @foreach($users as $user)
                            
                            <tr>
                                <td>
                                    {{ $user->id }}
                                </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{  $user->mobile  }}</td>

                                <td>{{ \Carbon\Carbon::parse($user->created_at)->format('Y-m-d') }}</td>

                                <td>
                                    <a href="javascript:void(0)" class="text-danger w-4 h-4 mr-1" onclick="deleteUser('{{ $user->id }}')">
                                        <svg wire:loading.remove.delay="" wire:target="" class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path ath fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            @endif

                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
@section('js')

<script>
    function deleteUser(id) {
        var url = '{{route("Delete-User","ID")}}';
        var newurl = url.replace('ID', id)
        if (confirm('Are You sure want to delete')) {
            $.ajax({
                url: newurl,
                type: 'delete',
                data: {},
                dataType: 'json',
                success: function(response) {
                    if (response['status']) {
                        window.location.href = '{{route("user")}}'

                    } else {
                        window.location.href = '{{route("user")}}'
                    }
                }
            })
        }


    }
</script>
@endsection