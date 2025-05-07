document.addEventListener('DOMContentLoaded', function() {
    // --- CARRUSEL PRINCIPAL ---
    const images = document.querySelectorAll('.carousel-image');
    let imgIndex = 0;
    if (images.length) {
      images[imgIndex].classList.add('active');
      setInterval(() => {
        images[imgIndex].classList.remove('active');
        imgIndex = (imgIndex + 1) % images.length;
        images[imgIndex].classList.add('active');
      }, 5000);
    }
  
    // --- CARRUSEL 3D DE PERFILES ---
    const carousel3d = document.querySelector('.carousel-3d');
    if (carousel3d) {
      const items3d = carousel3d.querySelectorAll('.item-3d');
      const total3d = items3d.length;
      let idx3d = 0;
      const radius = 300;                  // Radio del círculo, ajustar si es necesario
      const angleStep = 360 / total3d;
  
      function setup3D() {
        items3d.forEach((item, i) => {
          const angle = angleStep * i;
          item.style.transform = `rotateY(${angle}deg) translateZ(${radius}px)`;
          item.style.opacity = i === 0 ? '1' : '0.6';
        });
      }
  
      function rotate3D() {
        idx3d = (idx3d + 1) % total3d;
        items3d.forEach((item, i) => {
          const angle = angleStep * ((i - idx3d + total3d) % total3d);
          item.style.transform = `rotateY(${angle}deg) translateZ(${radius}px)`;
          item.style.opacity = i === idx3d ? '1' : '0.6';
        });
      }
  
      setup3D();
      setInterval(rotate3D, 3000);
    }
  
    // --- CLIMA Y PRONÓSTICO ---
    const apiKey = '5759400295967954990f7e00afa6406d';
    const weatherIcon      = document.getElementById('weather-icon');
    const weatherDesc      = document.getElementById('weather-description');
    const locationElem     = document.getElementById('location');
    const currentTempElem  = document.getElementById('current-temperature');
    const forecastContainer= document.getElementById('forecast-container');
    const dateElem         = document.getElementById('current-date');
    const toggleBtn        = document.getElementById('toggle-weather');
    const weatherContent   = document.getElementById('weather-content');
    const modal            = document.getElementById('day-modal');
    const modalClose       = document.getElementById('close-modal');
    const modalTitle       = document.getElementById('modal-day-title');
    const modalDetails     = document.getElementById('modal-day-details');
  
    // Mostrar/ocultar sección de clima
    if (toggleBtn && weatherContent) {
      toggleBtn.addEventListener('click', () => {
        weatherContent.classList.toggle('hidden');
      });
    }
  
    // Función común para abrir modal
    function openModal(day, details) {
      modalTitle.textContent   = `Detalles del día: ${day}`;
      modalDetails.innerHTML   = `
        <p><strong>Temperatura:</strong> ${details.temp}°C</p>
        <p><strong>Descripción:</strong> ${details.description}</p>
        <p><strong>Humedad:</strong> ${details.humidity}%</p>
        <p><strong>Viento:</strong> ${details.wind} m/s</p>
      `;
      modal.classList.add('active');
    }
  
    // Cerrar modal
    if (modalClose) {
      modalClose.addEventListener('click', () => modal.classList.remove('active'));
      window.addEventListener('click', e => {
        if (e.target === modal) modal.classList.remove('active');
      });
    }
  
    // Obtener ubicación y datos meteorológicos
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(async function(position) {
        const lat = position.coords.latitude;
        const lon = position.coords.longitude;
  
        // Clima actual
        try {
          const wRes = await fetch(
            `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&units=metric&lang=es&appid=${apiKey}`
          );
          const wData = await wRes.json();
          weatherIcon.src           = `https://openweathermap.org/img/wn/${wData.weather[0].icon}@2x.png`;
          weatherDesc.textContent   = wData.weather[0].description;
          locationElem.textContent  = wData.name;
          currentTempElem.textContent = `${Math.round(wData.main.temp)}°C`;
        } catch (err) {
          console.error('Error al cargar clima actual:', err);
        }
  
        // Pronóstico
        try {
          const fRes = await fetch(
            `https://api.openweathermap.org/data/2.5/forecast?lat=${lat}&lon=${lon}&units=metric&lang=es&appid=${apiKey}`
          );
          const fData = await fRes.json();
          const days = {};
  
          // Extraer sólo mediodía de cada día
          fData.list.forEach(item => {
            if (item.dt_txt.endsWith('12:00:00')) {
              const date = new Date(item.dt * 1000);
              const dayName = date.toLocaleDateString('es-ES', { weekday: 'long' });
              days[dayName] = {
                temp: Math.round(item.main.temp),
                icon: item.weather[0].icon,
                description: item.weather[0].description,
                humidity: item.main.humidity,
                wind: item.wind.speed
              };
            }
          });
  
          // Mostrar pronóstico para los próximos 3 días
          forecastContainer.innerHTML = '';
          Object.keys(days).slice(0, 3).forEach(day => {
            const d = days[day];
            const div = document.createElement('div');
            div.classList.add('forecast-day');
            div.innerHTML = `
              <p>${day}</p>
              <img src="https://openweathermap.org/img/wn/${d.icon}@2x.png" alt="Icono ${d.description}">
              <p>${d.temp}°C</p>
              <button class="details-button" data-day="${day}" data-details='${JSON.stringify(d)}'>
                Ver más detalles
              </button>
            `;
            forecastContainer.appendChild(div);
          });
  
          // Fecha actual
          const now = new Date();
          dateElem.textContent = now.toLocaleDateString('es-ES', {
            weekday: 'long', day: 'numeric', month: 'long'
          });
  
          // Delegación de evento para botones "Ver más detalles"
          forecastContainer.addEventListener('click', e => {
            const btn = e.target.closest('.details-button');
            if (!btn) return;
            const day     = btn.dataset.day;
            const details = JSON.parse(btn.dataset.details);
            openModal(day, details);
          });
        } catch (err) {
          console.error('Error al cargar pronóstico:', err);
        }
      });
    } else {
      alert('La geolocalización no está disponible en este navegador.');
    }
  });
  