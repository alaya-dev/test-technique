@extends('include-member')
@section('here')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Liste des tâches</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-xl-12">
                        <div class="table-responsive mt-4 mt-xl-0">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Titre</th>
                                            <th>Description</th>
                                            <th>Statut</th>
                                            <th>Propriétaire</th>
                                            <th>Créé le</th>
                                            <th>Mis à jour le</th>
                                            <th>Délai</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $item)
                                        <tr>
                                            <td class="fw-medium">{{ $item->id }}</td>
                                            <td>{{ $item->title }}</td>
                                            <td>{{ $item->description }}</td>
                                            <td>
                                                <form action="{{ route('update.status', ['id' => $item->id]) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-link text-success" {{ $item->isCompleted() ? 'disabled' : '' }}>
                                                        {{ $item->status == 'en attente' ? 'En attente' : 'Terminé' }}
                                                    </button>
                                                </form>
                                            </td>
                                            <td>{{ $item->user->name }}</td>
                                            <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                            <td>{{ $item->updated_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                {{-- Vérifie si $item->deadline est défini --}}
                                                    @if ($item->deadline)
                                                {{-- Affiche la date de $item->deadline au format jour/mois/année --}}
                                                    {{ \Carbon\Carbon::parse($item->deadline)->format('d/m/Y') }}
                                                    @else
                                                {{-- Affiche un tiret si $item->deadline n'est pas défini --}}
                                                    -
                                                    @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->
            </div> <!-- container-fluid -->
        </div> 
    </div>    

            <!--
        <script>
                function handleStatusChange(task) 
                {
                    if (task.status === 'completed') {
                        alert("Impossible de changer une tâche terminée en attente.");
                        return;
                    }    
                }
        </script>       
            -->         
@endsection
