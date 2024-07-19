@extends('include')

@section('here')
<div class="container-fluid">

    <!-- start page title -->
    
    <!-- end page title -->
    <h4 class="mb-sm-0 font-size-18">Ajouter une tâche</h4>

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
                    <form action="ajouttask" method="POST">
                        @csrf

                        <div class="mb-3 row">
                            <label for="title" class="col-md-2 col-form-label">Titre</label>
                            <div class="col-md-10">
                                <input class="form-control" name="titre" type="text" placeholder="Titre de la tâche"
                                    id="title">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="description" class="col-md-2 col-form-label">Description</label>
                            <div class="col-md-10">
                                <textarea class="form-control" name="description" rows="3"
                                    placeholder="Description de la tâche" id="description"></textarea>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="example-select-input" class="col-md-2 col-form-label">Assigner à</label>
                                <div class="col-md-10">
                                    <select class="form-control" name="user_id" id="example-select-input">
                                        @foreach($users as $user)
                                            @if ($user->role == 'member')
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="deadline" class="col-md-2 col-form-label">Délai</label>
                            <div class="col-md-10">
                                <input class="form-control" name="deadline" type="date" id="deadline">
                            </div>
                        </div>
                        

                </div>
                <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>
            </div> <!-- end card -->

        </div> <!-- end col -->
    </div> <!-- end row -->

</div> <!-- container-fluid -->
@endsection
