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

        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }

        .modal.active {
            display: block;
        }

        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .modal-overlay.active {
            display: block;
        }

        .modal-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .modal-buttons button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-add {
            background-color: #28a745;
            color: white;
        }

        .btn-view {
            background-color: #007bff;
            color: white;
        }

        .btn-replace {
            background-color: #ffc107;
            color: white;
        }

        .btn-close {
            background-color: #dc3545;
            color: white;
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
                    openModal(info.dateStr, null);
                },
                eventClick: function (info) {
                    openModal(info.event.startStr, info.event);
                }
            });

            calendar.render();

            function openModal(date, event) {
                modalTitle.textContent = `Opciones para el día ${date}`;
                modalButtons.innerHTML = '';

                if (event) {
                    // Si hay un evento, mostrar opciones para ver o sustituir
                    modalButtons.innerHTML = `
                        <button class="btn-view" onclick="viewOutfit(${event.extendedProps.outfitId})">Ver Outfit</button>
                        <button class="btn-replace" onclick="replaceOutfit('${date}')">Sustituir Outfit</button>
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
                window.location.href = `/outfits/${outfitId}`;
            };

            window.replaceOutfit = function (date) {
                window.location.href = `/outfits/replace?date=${date}`;
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
        <button id="btn-close" class="btn-close">Cerrar</button>
    </div>
    <div id="modal-overlay" class="modal-overlay"></div>
@endsection