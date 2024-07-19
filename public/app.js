// Importez Axios
import axios from 'axios';

// Utilisez Axios pour effectuer des requêtes
document.addEventListener('DOMContentLoaded', function() {
    axios.get('/api/statistics', {
        headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('token')
        }
    })
    .then(response => {
        const data = response.data;
        document.getElementById('daily-total').innerText = data.daily.total_tasks;
        document.getElementById('daily-completed').innerText = data.daily.completed_tasks;
        document.getElementById('daily-completion-rate').innerText = data.daily.completion_rate;
        document.getElementById('daily-average-time').innerText = data.daily.average_completion_time;

        document.getElementById('weekly-total').innerText = data.weekly.total_tasks;
        document.getElementById('weekly-completed').innerText = data.weekly.completed_tasks;
        document.getElementById('weekly-completion-rate').innerText = data.weekly.completion_rate;
        document.getElementById('weekly-average-time').innerText = data.weekly.average_completion_time;

        document.getElementById('monthly-total').innerText = data.monthly.total_tasks;
        document.getElementById('monthly-completed').innerText = data.monthly.completed_tasks;
        document.getElementById('monthly-completion-rate').innerText = data.monthly.completion_rate;
        document.getElementById('monthly-average-time').innerText = data.monthly.average_completion_time;
    })
    .catch(error => {
        console.error('Error fetching statistics:', error);
    });
});
