@extends('layouts.header')

@section('title', 'Calendario de Outfits')

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css">
    <link rel="stylesheet" href="{{ asset('css/calendario.css') }}">

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