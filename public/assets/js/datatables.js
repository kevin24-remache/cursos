$(document).ready(function () {

    $("#example").DataTable({
        columnDefs: [
            { targets: 'exclude-view', visible: false }
        ],
        initComplete: function () {
            // Mostrar la tabla después de que DataTables se haya inicializado
            $(this).removeClass('d-none');
            // Redimensionar las columnas para que sean responsive
            var table = $(this).DataTable();
            table.responsive.recalc();
        },
        language: {
            buttons: {
                sLengthMenu: "Mostrar _MENU_ resultados",
                pageLength: {
                    _: "Mostrar %d resultados",
                },
            },
            zeroRecords: "No hay coincidencias",
            info: "Mostrando _END_ resultados de _MAX_",
            infoEmpty: "No hay datos disponibles",
            infoFiltered: "(Filtrado de _MAX_ registros totales)",
            search: "Buscar",
            emptyTable: "No existen registros",
            paginate: {
                first: "Primero",
                previous: "Anterior",
                next: "Siguiente",
                last: "Último",
            },
        },
        responsive: true,
        dom: "Bfrtip",
        buttons: [
            {
                extend: "pageLength",
                className: "bg-secondary text-white",
            },

            {
                extend: 'collection',
                text: '<i class="fa fa-download"></i> Exportar',
                buttons: [
                    {
                        extend: 'copyHtml5',
                        text: '<i class="fa fa-files-o text-info"></i> Copiar',
                        titleAttr: 'Copiar'
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o text-success"></i> Excel',
                        titleAttr: 'Excel'
                    },
                    {
                        extend: 'csvHtml5',
                        text: '<i class="fa fa-file-text-o text-primary"></i> CSV',
                        titleAttr: 'CSV'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fa fa-file-pdf-o text-red"></i> PDF',
                        titleAttr: 'PDF'
                    }
                ]
            },

            {
                text: '<i class="fa fa-lg fas fa-plus-circle"></i> Agregar',
                titleAttr: 'Agregar',
                className: 'bg-success text-white',
                action: function () {
                    window.location.href = base_url + "admin/event/new";
                },
            },
            {
                text: '<i class="fa-lg fas fa-trash-restore"></i><p class="tooltip-text">Eliminados</p>',
                className: 'd-none',

                action: function () {
                    $("#createEventModal").modal("show");
                },
            },
        ],
        lengthMenu: [10, 25, 50, 100],
    });

    $("#category").DataTable({
        columnDefs: [
            { targets: 'exclude-view', visible: false }
        ],
        initComplete: function () {
            // Mostrar la tabla después de que DataTables se haya inicializado
            $(this).removeClass('d-none');
            // Redimensionar las columnas para que sean responsive
            var table = $(this).DataTable();
            table.responsive.recalc();
        },
        language: {
            buttons: {
                sLengthMenu: "Mostrar _MENU_ resultados",
                pageLength: {
                    _: "Mostrar %d resultados",
                },
            },
            zeroRecords: "No hay coincidencias",
            info: "Mostrando _END_ resultados de _MAX_",
            infoEmpty: "No hay datos disponibles",
            infoFiltered: "(Filtrado de _MAX_ registros totales)",
            search: "Buscar",
            emptyTable: "No existen registros",
            paginate: {
                first: "Primero",
                previous: "Anterior",
                next: "Siguiente",
                last: "Último",
            },
        },
        responsive: true,
        dom: "Bfrtip",
        buttons: [
            {
                extend: "pageLength",
                className: "bg-secondary text-white",
            },

            {
                extend: 'collection',
                text: '<i class="fa fa-download"></i> Exportar',
                buttons: [
                    {
                        extend: 'copyHtml5',
                        text: '<i class="fa fa-files-o text-info"></i> Copiar',
                        titleAttr: 'Copiar'
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o text-success"></i> Excel',
                        titleAttr: 'Excel'
                    },
                    {
                        extend: 'csvHtml5',
                        text: '<i class="fa fa-file-text-o text-primary"></i> CSV',
                        titleAttr: 'CSV'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fa fa-file-pdf-o text-red"></i> PDF',
                        titleAttr: 'PDF'
                    }
                ]
            },

            {
                text: '<i class="fa fa-lg fas fa-plus-circle"></i> Agregar',
                titleAttr: 'Agregar',
                className: 'bg-success text-white',
                action: function () {
                    window.location.href = base_url + "admin/category/new";
                },
            },
            {
                text: '<i class="fa-lg fas fa-trash-restore"></i><p class="tooltip-text">Eliminados</p>',
                className: 'd-none',

                action: function () {
                    $("#createEventModal").modal("show");
                },
            },
        ],
        lengthMenu: [10, 25, 50, 100],
    });
});