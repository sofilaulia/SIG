/*!
* Start Bootstrap - Freelancer v7.0.6 (https://startbootstrap.com/theme/freelancer)
* Copyright 2013-2022 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-freelancer/blob/master/LICENSE)
*/
//
// Scripts
// 

window.addEventListener('DOMContentLoaded', event => {

    // Navbar shrink function
    var navbarShrink = function () {
        const navbarCollapsible = document.body.querySelector('#mainNav');
        if (!navbarCollapsible) {
            return;
        }
        if (window.scrollY === 0) {
            navbarCollapsible.classList.remove('navbar-shrink')
        } else {
            navbarCollapsible.classList.add('navbar-shrink')
        }

    };

    // Shrink the navbar 
    navbarShrink();

    // Shrink the navbar when page is scrolled
    document.addEventListener('scroll', navbarShrink);

    // Activate Bootstrap scrollspy on the main nav element
    const mainNav = document.body.querySelector('#mainNav');
    if (mainNav) {
        new bootstrap.ScrollSpy(document.body, {
            target: '#mainNav',
            offset: 72,
        });
    };

    // Collapse responsive navbar when toggler is visible
    const navbarToggler = document.body.querySelector('.navbar-toggler');
    const responsiveNavItems = [].slice.call(
        document.querySelectorAll('#navbarResponsive .nav-link')
    );
    responsiveNavItems.map(function (responsiveNavItem) {
        responsiveNavItem.addEventListener('click', () => {
            if (window.getComputedStyle(navbarToggler).display !== 'none') {
                navbarToggler.click();
            }
        });
    });

});

async function fetchCities() {
    const { data: cityList } = await fetch('https://satudata.jabarprov.go.id/api-backend/bigdata/diskominfo/od_kode_wilayah_dan_nama_wilayah_kota_kabupaten')
    .then((response) => response.json())
    .then((data) => data)

    cityList.map(city => {
        if (city.bps_kota_kode > 0) {
            $('#city').append($('<option>', {
                value: `${city.bps_kota_kode}-_-${city.latitude}-_-${city.longitude}`,
                text: city.bps_kota_nama
            }))
        }
    })

    return true
}

async function fetchHospitals(kode) {
    const { data: private } = await fetch(`https://satudata.jabarprov.go.id/api-backend//bigdata/dinkes/od_15932_daftar_rumah_sakit_milik_swasta__kabupatenkota?limit=100&skip=0&where=%7B%22kode_kabupaten_kota%22%3A%5B%22${kode}%22%5D%7D`)
    .then((response) => response.json())
    .then((data) => data)

    const { data: goverment } = await fetch(`https://satudata.jabarprov.go.id/api-backend//bigdata/dinkes/od_15931_daftar_rumah_sakit_milik_pem__kabupatenkota?limit=10&skip=0&where=%7B%22kode_kabupaten_kota%22%3A%5B%22${kode}%22%5D%7D`)
    .then((response) => response.json())
    .then((data) => data)

    return [...private, ...goverment]
}

async function fetchVillages(kode) {
    const { data } = await fetch(`https://satudata.jabarprov.go.id/api-backend//bigdata/dpmdes/idm_dftr_titik_koordinat_desa__des_kel?limit=10&skip=0&where=%7B%22bps_kode_kabupaten_kota%22%3A%5B%22${kode}%22%5D%7D`)
    .then((response) => response.json())
    .then((data) => data)

    return [...data]
}

async function printJSON(file, key) {
    const response = await fetch(`data/${file}.json`)
    const json = await response.json()
    
    return json[key]
}

function redirect_to(file) {
    window.location.href = `./${file}`;
}

function titleCase(str) {
    var splitStr = str.toLowerCase().split(' ');
    for (var i = 0; i < splitStr.length; i++) {
        // You do not need to check if i is larger than splitStr length, as your for does that for you
        // Assign it back to the array
        splitStr[i] = splitStr[i].charAt(0).toUpperCase() + splitStr[i].substring(1);     
    }
    // Directly return the joined string
    return splitStr.join(' '); 
 }