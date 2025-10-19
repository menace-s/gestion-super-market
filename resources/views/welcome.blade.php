@extends('layouts.app')

@section('content')

<div class="content">
    <div class="row">
        <div class="col-xl-3 col-sm-6 col-12 d-flex">
            <div class="dash-widget w-100">
                <div class="dash-widgetimg">
                    <span><img src="assets/img/icons/dash1.svg" alt="img"></span>
                </div>
                <div class="dash-widgetcontent">
                    <h5>CFA <span class="counters" data-count="222">222 </span></h5>
                    <h6>Somme Total Rechargement</h6>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12 d-flex">
            <div class="dash-widget dash1 w-100">
                <div class="dash-widgetimg">
                    <span><img src="assets/img/icons/dash2.svg" alt="img"></span>
                </div>
                <div class="dash-widgetcontent">
                    <h5>CFA <span class="counters" data-count="22">22</span></h5>
                    <h6>Somme Total Paiement</h6>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12 d-flex">
            <div class="dash-widget dash2 w-100">
                <div class="dash-widgetimg">
                    <span><img src="assets/img/icons/dash3.svg" alt="img"></span>
                </div>
                <div class="dash-widgetcontent">
                    <h5>CFA <span class="counters" data-count="34">34 </span></h5>
                    <h6>Somme Total rembourssement</h6>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12 d-flex">
            <div class="dash-widget dash3 w-100">
                <div class="dash-widgetimg">
                    <span><img src="assets/img/icons/dash4.svg" alt="img"></span>
                </div>
                <div class="dash-widgetcontent">
                    <h5>CFA <span class="counters" data-count="222">222</span> </h5>
                    <h6>Somme Total transaction</h6>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12 d-flex">
            <div class="dash-count">
                <div class="dash-counts">
                    <h4>222</h4>
                    <h5>Nombres des Usagers</h5>
                </div>
                <div class="dash-imgs">
                    <i data-feather="user"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12 d-flex">
            <div class="dash-count das1">
                <div class="dash-counts">
                    <h4>2222</h4>
                    <h5>Nombre des Chauffeurs</h5>
                </div>
                <div class="dash-imgs">
                    <i data-feather="user-check"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12 d-flex">
            <div class="dash-count das2">
                <div class="dash-counts">
                    <h4>222</h4>
                    <h5>Nombre de rechargment</h5>
                </div>
                <div class="dash-imgs">
                    <img src="assets/img/icons/file-text-icon-01.svg" class="img-fluid" alt="icon">
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12 d-flex">
            <div class="dash-count das3">
                <div class="dash-counts">
                    <h4>2</h4>
                    <h5>Nombre des paiements</h5>
                </div>
                <div class="dash-imgs">
                    <img style="color: white" src="assets/img/icons/dollar.svg" class="img-fluid" alt="icon">
                </div>
            </div>
        </div>
    </div>
    <!-- Button trigger modal -->

    <div class="row">
        <div class="col-xl-7 col-sm-12 col-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Statistiques Mensuelles</h5>
                    <div class="graph-sets">
                        <ul class="mb-0">
                            <li><span>Recharge</span></li>
                            <li><span>Paiement</span></li>
                        </ul>
                        <div class="dropdown dropdown-wraper">
                            <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                2
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                    <li><a href="javascript:void(0);" class="dropdown-item year-option" data-year="2">2</a></li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="stats_charts"></div>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

        <script>
            const currentYear = 2;
            const rechargesMois = 3;
            const paiementsMois = 4;

            const moisLabels = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sept', 'Oct', 'Nov', 'Déc'];

            // Initialiser le graphique
            let chart = new ApexCharts(document.querySelector("#stats_charts"), {
                chart: { type: 'line', height: 300 },
                series: [
                    { name: 'Recharges', data: rechargesMois[currentYear] || new Array(12).fill(0) },
                    { name: 'Paiements', data: paiementsMois[currentYear] || new Array(12).fill(0) }
                ],
                xaxis: { categories: moisLabels },
                colors: ['#28a745', '#FF4D4D'],
                dataLabels: { enabled: true },
                stroke: { curve: 'smooth' },
                title: { text: 'Montants des recharges et paiements (par mois)', align: 'center' }
            });

            chart.render();

            // Mise à jour lors du clic sur une année
            document.querySelectorAll('.year-option').forEach(item => {
                item.addEventListener('click', function (e) {
                    e.preventDefault();
                    const year = this.dataset.year;

                    document.getElementById('dropdownMenuButton').innerText = year;

                    chart.updateSeries([
                        {
                            name: 'Recharges',
                            data: rechargesMois[year] || new Array(12).fill(0)
                        },
                        {
                            name: 'Paiements',
                            data: paiementsMois[year] || new Array(12).fill(0)
                        }
                    ]);
                });
            });
        </script>


        <div class="col-xl-5 col-sm-12 col-12 d-flex">
            <div class="card flex-fill default-cover mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Derniers inscrits</h4>
                    <div class="view-all-link">
                        <a href="{{ route('admin.administration.users.index') }}" class="view-all d-flex align-items-center">
                            Voir tout<span class="ps-2 d-flex align-items-center"><i data-feather="arrow-right" class="feather-16"></i></span>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive dataview">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Contact</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <tr>
                                        <td>ddddd</td>
                                        <td>ldldld</td>
                                        <td>dddme</td>

                                    </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Transactions Récentes</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive dataview">
                <table class="table dashboard-expired-products">
                    <thead>
                        <tr>
                            <th>Beneficiaire</th>
                            <th>Montant</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td>dldd</td>
                            <td>2222 FCFA</td>
                            <td>DDDD</td>
                            <td>ddddd</td>
                            <td><span class="badge bg-success">ddd </span> </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
