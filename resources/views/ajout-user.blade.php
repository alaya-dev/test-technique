@extends('include')
@section('here')
                    <div class="container-fluid">

                        <!-- start page title -->
                        
                        <!-- end page title -->
                        <h4 class="mb-sm-0 font-size-18">Ajouter un membre</h4>

                        <div class="row">
                            <div class="col-12">
                            <br>
                                <div class="card">
                                    <div class="card-body">
                                    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
                                    <form action="/ajoutuser" method="POST" >
                                        @csrf
                                        
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">Name</label>
                                            <div class="col-md-10">
                                                <input class="form-control" name="name"  type="text" placeholder="Votre nom "
                                                    id="example-text-input">
                                            </div>
                                        </div>


                                        <div class="mb-3 row">
                                            <label for="example-email-input" class="col-md-2 col-form-label">Email</label>
                                            <div class="col-md-10">
                                                <input class="form-control"  name="email" type="email"  placeholder="Votre email"
                                                    id="example-email-input">
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3 row">
                                            <label for="example-password-input" class="col-md-2 col-form-label">Password</label>
                                            <div class="col-md-10">
                                                <input class="form-control" name="password" type="password"   placeholder="Votre mot de passe"  
                                                    id="example-password-input">
                                            </div>  
                                        </div>
                                        
                                    </div>
                                    <button type="submit" class="btn btn-primary">Ajouter</button>

                                </div> <!-- end col -->

                            </div>
                         <!-- end row -->
                                    
                        </div> <!-- container-fluid -->
                    </div>
@endsection