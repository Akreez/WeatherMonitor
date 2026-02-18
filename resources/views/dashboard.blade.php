<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Időjárás Monitor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 p-10">
    
    <div class="max-w-4xl mx-auto">
        <div class="bg-white p-6 rounded shadow mb-8">
            <h2 class="text-xl mb-4 font-semibold">Új város hozzáadása</h2>
            <form action="{{route('cities.store')}}" method="POST" class="flex gap-4">
                @csrf
                <input type="text" name="name" placeholder="Város neve" class="border p-2 rounded w-full" required>
                <input type="text" name="country" placeholder="Ország" class="border p-2 rounded w-full" required>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-800">Hozzáadás</button>
            </form>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b">
                        <th class="py-2">Város</th>
                        <th class="py-2">Ország</th>
                        <th class="py-2">Legutóbbi hőmérséklet</th>
                        <th class="py-2">Művelet</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cities as $city)
                    <tr class="border-b">
                        <td class="py-2">{{$city->name}}</td>
                        <td class="py-2">{{$city->country}}</td>
                        <td class="py-2">
                            {{$city->latestWeatherData ? $city->latestWeatherData->temperature . ' °C' : 'Nincs adat'}}
                        </td>
                        <td class="py-2 flex items-center">
                            <button onclick="showChart({{ $city->id }}, '{{ $city->name }}')" class="text-blue-500 hover:text-blue-700 font-medium">
                                Grafikon
                            </button>

                            <form action="{{route('cities.destroy', $city->id)}}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 ml-4">Törlés</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div id="chartContainer" class="mt-8 bg-white p-6 rounded shadow hidden">
            <h3 id="chartTitle" class="text-lg font-bold mb-4"></h3>
            <div class="h-64">
                <canvas id="weatherChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        let myChart;

        function showChart(cityId, cityName) {
            const container = document.getElementById('chartContainer');
            container.classList.remove('hidden');
            document.getElementById('chartTitle').innerText = cityName + " hőmérséklet alakulása";

            // API hívás (ügyelj, hogy a /api/weather/{id} útvonal éljen)
            fetch(`/api/weather/${cityId}`)
                .then(response => response.json())
                .then(data => {
                    const labels = data.history.map(m => new Date(m.created_at).toLocaleTimeString('hu-HU')).reverse();
                    const temps = data.history.map(m => m.temperature).reverse();

                    const ctx = document.getElementById('weatherChart').getContext('2d');

                    if (myChart) {
                        myChart.destroy();
                    }

                    myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Hőmérséklet (°C)',
                                data: temps,
                                borderColor: 'rgb(59, 130, 246)',
                                tension: 0.3,
                                fill: true,
                                backgroundColor: 'rgba(59, 130, 246, 0.1)'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false
                        }
                    });

                    container.scrollIntoView({ behavior: 'smooth' });
                })
                .catch(err => alert("Hiba az adatok betöltésekor."));
        }
    </script>
</body>
</html>