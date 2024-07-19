@extends('include')
@section('here')


                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Liste des taches</h4>

                                   
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
                                                        <th>Titre</th>
                                                        <th>Description</th>
                                                        <th>Statut</th>
                                                        <th>Assigné à</th>
                                                        <th>Propriétaire</th>
                                                        <th>Créé le</th>
                                                        <th>Mis à jour le</th>
                                                        <th>Délai</th> 
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                            @foreach($data as $item)
                                                            <tr>
                                                                <td class="fw-medium">{{$item->id}}</td>
                                                                <td>{{$item->title}}</td>
                                                                <td>{{$item->description}}</td>
                                                                <td>
                                                            @if($item->status == 'en attente')
                                                                <span class="badge bg-warning">En attente</span>
                                                            @else
                                                                <span class="badge bg-success">Terminé</span>
                                                            @endif
                                                               </td>                                                                
                                                        <td>{{ $item->user->name }}</td> <!-- Affichez le nom assigné -->
                                                                <td>
                                                                        <p>Leader</p>
                                                                </td>                                                             
                                                                <td>{{ $item->created_at->format('d/m/Y H:i') }}</td> <!-- Affichez la date de création -->
                                                                <td>{{ $item->updated_at->format('d/m/Y H:i') }}</td> <!-- Affichez la date de mise à jour -->
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
                                                <td>
                                                <a href="/modifier-task/{{$item->id}}" class="btn btn-link text-primary" title="Modifier"><i class="fas fa-edit"></i></a>
                                                <a href="/SuppTask/{{$item->id}}" class="btn btn-link text-danger" title="Supprimer"><i class="fas fa-trash-alt"></i></a>

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
                
             
