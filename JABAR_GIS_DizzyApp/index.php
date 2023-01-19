<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Jabar GIS</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="assets/css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
</head>

<body id="page-top">
    <!-- Navigation-->
    <?php include_once('menu.php') ?>
    <!-- Masthead-->
    <header class="masthead bg-primary text-white text-center">
        <div class="container d-flex align-items-center flex-column">
            <!-- Masthead Avatar Image-->
            <img class="masthead-avatar mb-5" src="assets/img/hospital-marker-2nd.svg" alt="..." />
            <!-- Masthead Heading-->
            <h1 class="masthead-heading text-uppercase mb-0">Rumah Sakit</h1>
            <!-- Icon Divider-->
            <div class="divider-custom divider-light">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <!-- Masthead Subheading-->
            <p class="masthead-subheading font-weight-light mb-0">Persebaran Titik Lokasi</p>
        </div>
    </header>
    <!-- Map Section-->
    <section class="page-section hospital" id="hospital">
        <div class="container">
            <!-- Map Section Heading-->
            <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Map</h2>
            <!-- Icon Divider-->
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <!-- Map Grid Items-->
            <div class="row justify-content-center">
                <div class="col-md-4 mb-3">
                    <select id="city" class="form-control" onchange="reload_map(this.value)">
                        <option disabled selected>Silahkan Pilih Daerah</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <div id="map" style="width: 100%; height: 600px;"></div>
                    <span id="note"></span>
                </div>
            </div>
        </div>
    </section>
    <!-- Copyright Section-->
    <div class="copyright py-4 text-center text-white">
        <div class="container"><small>Copyright &copy; Dizzy App 2022 - 2023</small></div>
    </div>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://unpkg.com/jquery@3.6.0/dist/jquery.min.js"></script>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="assets/js/scripts.js"></script>
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <!-- * *                               SB Forms JS                               * *-->
    <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    <script>
        (function() {
            fetchCities()
        })();

        let map = null

        function reload_map(value) {
            const splitValue = value.split('-_-')
            const cityCode = splitValue[0]
            const cityLat = splitValue[1]
            const cityLong = splitValue[2]

            if (map !== null) {
                map.remove()
            }

            fetchHospitals(cityCode).then((data) => {
                map = L.map('map').setView([cityLat, cityLong], 13);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
                }).addTo(map);

                let counter = 0
                data.map(function(location, key) {
                    if (location.latitude !== null && location.longitude !== null) {
                        L.marker([location.latitude, location.longitude], {
                                icon: L.icon({
                                    iconUrl: `assets/img/pin-marker.png`,
                                    iconSize: [26, 37],
                                    iconAnchor: [16, 37],
                                    popupAnchor: [0, -28]
                                })
                            }).addTo(map)
                            .bindPopup(location.nama_rs)
                    } else {
                        counter++
                    }
                });

                if (counter > 0) {
                    document.getElementById('note').innerHTML = `Catatan: Sebanyak ${counter} rumah sakit tidak mempunyai latitude dan longitude`
                } else {
                    document.getElementById('note').innerHTML = `Catatan: -`
                }
            })
        }
    </script>
</body>

</html>