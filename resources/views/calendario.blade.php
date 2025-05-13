@extends('layouts.header')

@section('title', 'Calendario de Outfits')

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css">
    <style>
        .calendar-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        #calendar {
            margin-top: 20px;
        }

        /* Estilos del modal */
        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 10px 15px; /* Reduce el padding */
            border-radius: 8px; /* Bordes redondeados */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            width: 80%; /* Ancho relativo */
            max-width: 300px; /* Ancho máximo */
            max-height: 200px; /* Altura máxima */
            overflow-y: auto; /* Habilita el scroll si el contenido excede la altura */
        }

        .modal.active {
            display: block;
        }

        .modal h3 {
            font-size: 16px; /* Reduce el tamaño del título */
            margin-bottom: 10px; /* Espaciado inferior */
            text-align: center;
        }

        .modal-buttons {
            display: flex;
            justify-content: space-between;
            gap: 10px; /* Espaciado entre botones */
            margin-top: 10px; /* Reduce el margen superior */
        }

        .modal-buttons button {
            padding: 8px 12px; /* Reduce el tamaño de los botones */
            font-size: 12px; /* Reduce el tamaño de la fuente */
            border-radius: 4px; /* Bordes redondeados */
        }

        .btn-add {
            background-color: #28a745;
            color: white;
        }

        .btn-view {
            background-color: #007bff;
            color: white;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }

        .btn-close {
            background-color: #6c757d;
            color: white;
            margin-top: 10px; /* Espaciado superior */
            width: 100%; /* Botón de cerrar ocupa todo el ancho */
            font-size: 12px; /* Reduce el tamaño de la fuente */
        }

        .header {
            background-color: #002D68 !important;
            position: fixed !important;
            top: 0 !important;
            z-index: 1000 !important;
        }

        .notification-panel {
            position: absolute;
            top: 50px;
            right: 100px; /* Mueve el panel más a la izquierda */
            width: 320px; /* Aumenta el ancho si es necesario */
            background-color: #0D1117;
            color: white;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 15px;
            display: none;
            z-index: 1001;
        }

        .notification-panel.active {
            display: block;
        }

        .notification-panel ul li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5px 0;
            border-bottom: 1px solid #21262C;
            word-wrap: break-word; /* Permitir que el texto se ajuste */
        }

        .notification-panel ul li:last-child {
            border-bottom: none;
        }

        .mark-read-button {
            background-color: #2F81F7;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            white-space: nowrap; /* Evitar que el texto se corte */
        }

        .mark-read-button:hover {
            background-color: #1A73E8;
        }

        .profile-large {
            right: 70px !important;
        }

        .fc-daygrid-day {
            color: black; /* Asegura que los días sean negros */
        }

        .fc-daygrid-day.fc-day-today {
            background-color: #f8f9fa; /* Fondo claro para el día actual */
            color: black; /* Texto negro para el día actual */
        }

        .fc-daygrid-day:hover {
            background-color: #e9ecef; /* Fondo más claro al pasar el mouse */
        }
    </style>
@endsection

@section('scripts')

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendar');
            const modal = document.getElementById('modal');
            const modalOverlay = document.getElementById('modal-overlay');
            const modalTitle = document.getElementById('modal-title');
            const modalButtons = document.getElementById('modal-buttons');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: @json($events), // Los eventos se pasan desde el controlador
                dateClick: function (info) {
                    // Verificar si hay un evento en la fecha seleccionada
                    const eventsOnDate = calendar.getEvents().filter(event => {
                        return event.startStr === info.dateStr;
                    });

                    if (eventsOnDate.length > 0) {
                        // Si hay un evento, abrir el modal con las opciones del evento
                        openModal(info.dateStr, eventsOnDate[0]);
                    } else {
                        // Si no hay evento, mostrar opción para añadir
                        openModal(info.dateStr, null);
                    }
                },
                eventClick: function (info) {
                    // Abrir el modal con las opciones para el evento seleccionado
                    openModal(info.event.startStr, info.event);
                }
            });

            calendar.render();

            function openModal(date, event) {
                modalTitle.textContent = `Opciones para el día ${date}`;
                modalButtons.innerHTML = '';

                if (event) {
                    // Si hay un evento, mostrar opciones para ver o eliminar
                    modalButtons.innerHTML = `
                        <button class="btn-view" onclick="viewOutfit(${event.extendedProps.outfitId})">Ver Outfit</button>
                        <button class="btn-delete" onclick="deleteOutfit('${date}')">Eliminar Outfit</button>
                    `;
                } else {
                    // Si no hay evento, mostrar opción para añadir
                    modalButtons.innerHTML = `
                        <button class="btn-add" onclick="addOutfit('${date}')">Añadir Outfit</button>
                    `;
                }

                modal.classList.add('active');
                modalOverlay.classList.add('active');
            }

            function closeModal() {
                modal.classList.remove('active');
                modalOverlay.classList.remove('active');
            }

            modalOverlay.addEventListener('click', closeModal);
            document.getElementById('btn-close').addEventListener('click', closeModal);

            window.addOutfit = function (date) {
                window.location.href = `/outfits/create-from-calendar?date=${date}`;
            };

            window.viewOutfit = function (outfitId) {
                window.location.href = `/outfit/${outfitId}`;
            };

            window.deleteOutfit = function (date) {
                if (confirm('¿Estás seguro de que deseas eliminar este outfit?')) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/outfits/delete`;

                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = '{{ csrf_token() }}';

                    const dateInput = document.createElement('input');
                    dateInput.type = 'hidden';
                    dateInput.name = 'fecha';
                    dateInput.value = date;

                    form.appendChild(csrfInput);
                    form.appendChild(dateInput);

                    document.body.appendChild(form);
                    form.submit();
                }
            };
        });
    </script>
@endsection

@section('content')
    <div class="container mt-5">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="calendar-container">
            <h2>Calendario de Outfits</h2>
            <div id="calendar"></div>
        </div>
    </div>

    <!-- Modal -->
    <div id="modal" class="modal">
        <h3 id="modal-title"></h3>
        <div id="modal-buttons" class="modal-buttons"></div>
        <button id="btn-close" class="btn-close"></button>
    </div>
    <div id="modal-overlay" class="modal-overlay"></div>
@endsection