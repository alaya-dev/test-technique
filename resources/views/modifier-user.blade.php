@extends('include')
@section('here')
   <div class="container-fluid">
     <h4 class="mb-sm-0 font-size-18">Modifier l'utilisateur</h4>

    <!-- start page title -->
    <div class="row">
   
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);"></a></li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

      <div class="row">
            <div class="col-12">

                <form action="/ModifyUser" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{$data->id}}">

                    <div class="mb-3 row">
                        <label for="example-text-input" class="col-md-2 col-form-label">Name</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" value="{{$data->name}}" name="name" id="example-text-input" placeholder="Entrez votre nom" oninput="this.value = this.value.replace(/\d/g, '')">
                        </div>
                    </div>
                    
                    <div class="mb-3 row">
                        <label for="example-email-input" class="col-md-2 col-form-label">Email</label>
                        <div class="col-md-10">
                            <input class="form-control" type="email" value="{{$data->email}}" placeholder="Entrez votre Email"
                                id="example-email-input" name="email">
                        </div>
                    </div>

                
                </div>
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </form>

            </div>
        </div>
      </div> <!-- container-fluid -->
@endsection                