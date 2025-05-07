    document.addEventListener('DOMContentLoaded', function() {
        const images = document.querySelectorAll('.carousel-image'); // Todas las imágenes
        let currentIndex = 0; // Índice de la imagen actual

        // Función para cambiar de imagen
        function changeSlide() {
            // Ocultar la imagen actual
            if (images[currentIndex]) {
                images[currentIndex].classList.remove('active');
            }

            // Calcular el nuevo índice
            currentIndex++;

            // Volver al inicio si se pasa del límite
            if (currentIndex >= images.length) {
                currentIndex = 0;
            }

            // Mostrar la nueva imagen
            if (images[currentIndex]) {
                images[currentIndex].classList.add('active');
            }
        }

        // Asignar la primera imagen como activa
        if (images[currentIndex]) {
            images[currentIndex].classList.add('active');
        }

        // Cambiar automáticamente cada 5 segundos
        setInterval(changeSlide, 5000);
    });

    //SLIDER PROFILES
    document.addEventListener("DOMContentLoaded", function() {
        const carousel = document.querySelector(".carousel-3d");
        const items = document.querySelectorAll(".carousel-3d .item-3d");
        const totalItems = items.length;
        let currentIndex = 0;

        // Configuración del carrusel
        const radius = 300; // Radio del círculo (ajustar si hace falta)
        const angleStep = 360 / totalItems;

        // Coloca cada item en su posición inicial en el círculo
        function setupCarousel() {
            for (let i = 0; i < totalItems; i++) {
                const angle = angleStep * i;
                items[i].style.transform = `rotateY(${angle}deg) translateZ(${radius}px)`;
            }
        }

        function rotateCarousel() {
            currentIndex = (currentIndex + 1) % totalItems;
            for (let i = 0; i < totalItems; i++) {
                const angle = angleStep * ((i - currentIndex + totalItems) % totalItems);
                items[i].style.transform = `rotateY(${angle}deg) translateZ(${radius}px)`;

                if (i === currentIndex) {
                    items[i].classList.add("active");
                    items[i].style.opacity = "1";
                } else {
                    items[i].classList.remove("active");
                    items[i].style.opacity = "0.6";
                }
            }
        }

        setupCarousel(); // Posicionamiento inicial
        setInterval(rotateCarousel, 3000); // Gira cada 3 segundos
    });

    document.addEventListener('DOMContentLoaded', function () {
        const apiKey = '5759400295967954990f7e00afa6406d'; // Clave de API para OpenWeatherMap
        const weatherIcon = document.getElementById('weather-icon');
        const weatherDescription = document.getElementById('weather-description');
        const locationElement = document.getElementById('location');
        const currentTemperature = document.getElementById('current-temperature');
        const forecastContainer = document.getElementById('forecast-container');
        const currentDate = document.getElementById('current-date');
        const toggleWeatherButton = document.getElementById('toggle-weather');
        const weatherContent = document.getElementById('weather-content');

        toggleWeatherButton.addEventListener('click', function () {
            weatherContent.classList.toggle('hidden');
        });

        // Obtener ubicación actual
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(async function (position) {
                const lat = position.coords.latitude;
                const lon = position.coords.longitude;

                // Obtener datos del clima actual
                const weatherResponse = await fetch(`https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&units=metric&lang=es&appid=${apiKey}`);
                const weatherData = await weatherResponse.json();

                // Actualizar datos del clima actual
                weatherIcon.src = `https://openweathermap.org/img/wn/${weatherData.weather[0].icon}@2x.png`;
                weatherDescription.textContent = weatherData.weather[0].description;
                locationElement.textContent = weatherData.name;
                currentTemperature.textContent = `${Math.round(weatherData.main.temp)}°C`;

                // Obtener datos del pronóstico
                const forecastResponse = await fetch(`https://api.openweathermap.org/data/2.5/forecast?lat=${lat}&lon=${lon}&units=metric&lang=es&appid=${apiKey}`);
                const forecastData = await forecastResponse.json();

                // Actualizar pronóstico
                forecastContainer.innerHTML = '';
                const days = {};
                forecastData.list.forEach(item => {
                    const date = new Date(item.dt * 1000);
                    const day = date.toLocaleDateString('es-ES', { weekday: 'long' });
                    if (!days[day]) {
                        days[day] = {
                            temp: Math.round(item.main.temp),
                            icon: item.weather[0].icon
                        };
                    }
                });

                Object.keys(days).slice(0, 3).forEach(day => {
                    const forecastDiv = document.createElement('div');
                    forecastDiv.innerHTML = `
                        <p>${day}</p>
                        <img src="https://openweathermap.org/img/wn/${days[day].icon}@2x.png" alt="Weather Icon">
                        <p>${days[day].temp}°C</p>
                    `;
                    forecastContainer.appendChild(forecastDiv);
                });

                // Actualizar fecha actual
                const now = new Date();
                currentDate.textContent = now.toLocaleDateString('es-ES', { weekday: 'long', day: 'numeric', month: 'long' });
            });
        } else {
            alert('La geolocalización no está soportada en este navegador.');
        }
    });