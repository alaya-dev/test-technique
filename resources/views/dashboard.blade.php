@extends('include')
@section('here')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques des Tâches</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Statistiques des Tâches</h1>
        <div class="row">
            <div class="col-md-4">
                <div class="card text-center mb-4">
                    <div class="card-header">
                        Statistiques Quotidiennes
                    </div>
                    <div class="card-body">
                        <h5 class="card-title" id="dailyDate"></h5>
                        <p class="card-text">Tâches complétées: <span id="dailyTasksCompleted"></span></p>
                        <p class="card-text">Total des tâches: <span id="dailyTotalTasks"></span></p>
                        <p class="card-text">Taux d'achèvement: <span id="dailyCompletionRate"></span></p>
                        <p class="card-text">Temps moyen de complétion: <span id="dailyAverageCompletionTime"></span></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center mb-4">
                    <div class="card-header">
                        Statistiques Hebdomadaires
                    </div>
                    <div class="card-body">
                        <h5 class="card-title" id="weeklyPeriod"></h5>
                        <p class="card-text">Tâches complétées: <span id="weeklyTasksCompleted"></span></p>
                        <p class="card-text">Total des tâches: <span id="weeklyTotalTasks"></span></p>
                        <p class="card-text">Taux d'achèvement: <span id="weeklyCompletionRate"></span></p>
                        <p class="card-text">Temps moyen de complétion: <span id="weeklyAverageCompletionTime"></span></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center mb-4">
                    <div class="card-header">
                        Statistiques Mensuelles
                    </div>
                    <div class="card-body">
                        <h5 class="card-title" id="monthlyPeriod"></h5>
                        <p class="card-text">Tâches complétées: <span id="monthlyTasksCompleted"></span></p>
                        <p class="card-text">Total des tâches: <span id="monthlyTotalTasks"></span></p>
                        <p class="card-text">Taux d'achèvement: <span id="monthlyCompletionRate"></span></p>
                        <p class="card-text">Temps moyen de complétion: <span id="monthlyAverageCompletionTime"></span></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <canvas id="dailyChart"></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="weeklyChart"></canvas>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Récupérer les statistiques quotidiennes
            $.ajax({
                url: '/api/statistics/daily',
                type: 'GET',
                success: function(data) {
                    $('#dailyDate').text(data.date);
                    $('#dailyTasksCompleted').text(data.taches_terminees);
                    $('#dailyTotalTasks').text(data.taches_totales);
                    $('#dailyCompletionRate').text(data.taux_accomplissement);
                    $('#dailyAverageCompletionTime').text(data.temps_moyen_accomplissement);
                    // Afficher les données sur le graphique
                    displayChart('dailyChart', 'Statistiques Quotidiennes', [data.taches_terminees, data.taches_totales]);
                },
                error: function(error) {
                    console.error('Erreur lors de la récupération des statistiques quotidiennes:', error);
                }
            });

            // Récupérer les statistiques hebdomadaires
            $.ajax({
                url: '/api/statistics/weekly',
                type: 'GET',
                success: function(data) {
                    $('#weeklyPeriod').text(data.start_date + ' - ' + data.end_date);
                    $('#weeklyTasksCompleted').text(data.taches_terminees);
                    $('#weeklyTotalTasks').text(data.taches_totales);
                    $('#weeklyCompletionRate').text(data.taux_accomplissement);
                    $('#weeklyAverageCompletionTime').text(data.temps_moyen_accomplissement);
                    // Afficher les données sur le graphique
                    displayChart('weeklyChart', 'Statistiques Hebdomadaires', [data.taches_terminees, data.taches_totales]);
                },
                error: function(error) {
                    console.error('Erreur lors de la récupération des statistiques hebdomadaires:', error);
                }
            });

            // Récupérer les statistiques mensuelles
            $.ajax({
                url: '/api/statistics/monthly',
                type: 'GET',
                success: function(data) {
                    $('#monthlyPeriod').text(data.start_date + ' - ' + data.end_date);
                    $('#monthlyTasksCompleted').text(data.taches_terminees);
                    $('#monthlyTotalTasks').text(data.taches_totales);
                    $('#monthlyCompletionRate').text(data.taux_accomplissement);
                    $('#monthlyAverageCompletionTime').text(data.temps_moyen_accomplissement);
                    // Afficher les données sur le graphique
                    displayChart('monthlyChart', 'Statistiques Mensuelles', [data.taches_terminees, data.taches_totales]);
                },
                error: function(error) {
                    console.error('Erreur lors de la récupération des statistiques mensuelles:', error);
                }
            });
        });

        function displayChart(canvasId, label, data) {
            new Chart(document.getElementById(canvasId), {
                type: 'bar',
                data: {
                    labels: ['Complétées', 'Total'],
                    datasets: [{
                        label: label,
                        data: data,
                        backgroundColor: ['#4caf50', '#f44336']
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    </script>
</body>
</html>
@endsection
