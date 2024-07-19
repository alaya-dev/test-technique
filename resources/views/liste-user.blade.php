@extends('include')
@section('here')


                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Liste des utilisateurs</h4>

                                   
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
        
                                        <div class="col-xl-12">
                                                <div class="table-responsive mt-4 mt-xl-0">
                                                

                                                @if(session('success'))
                                                <div class="alert alert-success" role="alert">
                                                    {{session('success')}}
                                                </div>
                                                @endif

                                                @if(session('add'))
                                                <div class="alert alert-success" role="alert">
                                                    {{session('add')}}
                                                </div>
                                                @endif
        
                                        <div class="table-responsive">
                                        
                                            <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">

                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                            @foreach($data as $item)
                                                            <tr>
                                                                <td class="fw-medium">{{$item->id}}</td>
                                                                <td>{{$item->name}}</td>
                                                                <td>
                                                                    <a href="mailto:{{$item->email}}">{{$item->email}}</a>
                                                                </td>
                                                <td>
                                                <a href="/modifier-user/{{$item->id}}" class="btn btn-link text-primary" title="Modifier"><i class="fas fa-edit"></i></a>
                                                <a href="/SuppUser/{{$item->id}}" class="btn btn-link text-danger" title="Supprimer"><i class="fas fa-trash-alt"></i></a>

                                                </td>

                                                            </tr>
                                                            @endforeach
                                                    </tbody>
                                            </table>
                                        </div>
        
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->

                    </div> <!-- container-fluid -->
@endsection
                
             