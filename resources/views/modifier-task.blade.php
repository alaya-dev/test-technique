@extends('include')
@section('here')
   <div class="container-fluid">
     <h4 class="mb-sm-0 font-size-18">Modifier la tache </h4>

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

                <form action="/ModifyTask" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{$task->id}}">

                    <div class="mb-3 row">
                <label for="example-text-input" class="col-md-2 col-form-label">Titre</label>
                <div class="col-md-10">
                    <input class="form-control" type="text" value="{{$task->title}}" name="title" id="example-text-input" placeholder="Entrez le titre" oninput="this.value = this.value.replace(/\d/g, '')">
                </div>
            </div>

            <div class="mb-3 row">
                <label for="example-text-input" class="col-md-2 col-form-label">Description</label>
                <div class="col-md-10">
                    <input class="form-control" type="text" value="{{$task->description}}" name="description" id="example-text-input" placeholder="Entrez la description">
                </div>
            </div>

            <div class="mb-3 row">
                <label for="example-text-input" class="col-md-2 col-form-label">Délai</label>
                <div class="col-md-10">
                    <input class="form-control" type="date" value="{{$task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('Y-m-d') : ''}}" name="deadline" id="example-text-input" placeholder="Entrez le délai">
                </div>
            </div>

        
           </div>
        </div>
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </form>

            </div>
        </div>
      </div> <!-- container-fluid -->
@endsection                