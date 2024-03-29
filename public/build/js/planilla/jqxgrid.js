const initTable = async (jqxTable) => {
    const url = 'reporte-getplanillas';
    const root = 'planillas';

    const source = jqxDefaultSource(url, root, _datafields());
    const dataAdapter = jqxDefaultDataAdapter(source, jqxTable);

    jqxDefaultInit(jqxTable, dataAdapter);
}

const _datafields = () => {
    return [
        { name: 'dni', type: 'string' },
        { name: 'nombres', type: 'string' },
        { name: 'apellidos', type: 'string' },
        { name: 'description', type: 'string' },
        { name: 'imponible', type: 'string' },
        { name: 'haberes', type: 'string' },
        { name: 'liquido', type: 'string' },
        { name: 'fecha', type: 'string' },
        { name: 'ruta', type: 'string' },
        { name: 'observacion', type: 'string' },
        { name: 'estado', type: 'string' }
    ];
}

const _columns = () => {
    return [
        {
            datafield: 'nombres',
            text: 'Nombres',
            cellsalign: 'left',
        },
        {
            datafield: 'apellidos',
            text: 'Apellidos',
            cellsalign: 'left',
        },
        {
            datafield: 'description',
            text: 'Descripcion',
            cellsalign: 'left',
        },
        {
            datafield: 'imponible',
            text: 'Imponible',
            cellsalign: 'left',
        },
        {
            datafield: 'haberes',
            text: 'Haberes',
            cellsalign: 'left',
        },
        {
            datafield: 'liquido',
            text: 'Liquido',
            cellsalign: 'left',
        },
        {
            datafield: 'fecha',
            text: 'Fecha',
            cellsalign: 'center',
            cellsformat: 'dd-MM-yyyy',
            filtertype: 'range',
            columntype: 'datetimeinput'
        },
        {
            datafield: 'ruta',
            text: 'Archivo',
            cellsalign: 'left',
            cellsrenderer: function (row, columnfield, value) {
                return '<div style="font-weight: bold; margin: 3px;"><a href="' + window.location.origin + '/storage/' + value + '">Descargar archivo</a></div>';
            }
        },
        {
            datafield: 'observacion',
            text: 'Observacion',
            cellsalign: 'left',
        },
    ];
}

// INIT
const jqxDefaultDataAdapter = (source) => {
    return (new $.jqx.dataAdapter(source, {
        downloadComplete: function (data, textStatus, jqXHR) { },
        loadComplete: function (data) { },
        loadError: function (xhr, status, error) { }
    }));
}

const jqxDefaultSource = (url, root, datafields) => {
    return {
        url: window.location.origin + '/' + url,
        root: root,
        id: 'id',
        data: {},
        datatype: "json",
        type: 'POST',
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
        },
        datafields: datafields
    }
}

const jqxDefaultInit = (jqxTable, dataAdapter) => {
    // _cleanLocalStorage(jqxTable);

    $(jqxTable).jqxGrid({
        theme: 'default-theme',
        width: '100%',
        height: _getHeight(),
        source: dataAdapter,
        altrows: true,
        pageable: true,
        columns: _columns(),
        pagermode: "simple",
        pagesize: 50,
        virtualmode: true,
        filterable: true,
        showfilterrow: true,
        sortable: false,
        columnsresize: true,
        // autosavestate: true,
        // autoloadstate: true,
        showaggregates: true,
        columnsreorder: true,
        showstatusbar: true,
        statusbarheight: 20,
        rendergridrows: function () {
            return dataAdapter.records;
        }
    });

    $(jqxTable).on('filter', function () {
        $(jqxTable).jqxGrid('updatebounddata', 'filter');
    });

    $(jqxTable).on('sort', function () {
        $(jqxTable).jqxGrid('updatebounddata', 'sort');
    });

    $(jqxTable).on('rowdoubleclick', function (event) {
        if (typeof (jqxDefaultRowDoubleClick) === 'function') {
            jqxDefaultRowDoubleClick(jqxTable);
        }
    });
}

const _getHeight = () => {
    const height = window.innerHeight;
    const minHeight = 400;
    const restPercentage = 0.29;
    const defaultHeight = Math.max(minHeight, height - (height * restPercentage));

    return `${defaultHeight} px`;
}

const _cleanLocalStorage = (jqxTable) => {
    const id = jqxTable.id;
    const localStorageData = JSON.parse(localStorage.getItem(`jqxGrid${id}`) || '{}');

    const {
        sortcolumn,
        sortdirection,
        ...updatedData
    } = localStorageData;

    updatedData.filters = { filterscount: 0 };
    updatedData.pagenum = 0;

    localStorage.setItem(`jqxGrid${id}`, JSON.stringify(updatedData));
}

const print_popup = (link_) => {
    const link = link_;
    const ancho = 830;
    const alto = 600;

    let posicion_x;
    let posicion_y;

    posicion_x = (screen.width / 2) - (ancho / 2);
    posicion_y = ((screen.height - 90) / 2) - (alto / 2);
    _popup = window.open(link, link, "width=" + ancho + ",height=" + alto + ",menubar=0,toolbar=0,directories=0,scrollbars=no,resizable=no,left=" + posicion_x + ",top=" + posicion_y +
        "");
    return _popup;
}

const prin_document = (jqxTable, title) => {
    let gridContent = $(jqxTable).jqxGrid('exportdata', 'html').replace(/font-size:10px;/g, "").replace(/formatString:;dataType:string;/g, "").replace(/height:[^;]*;/g, "");

    // Crear un objeto DOMParser
    var parser = new DOMParser();

    // Analizar el contenido HTML
    var doc = parser.parseFromString(gridContent, 'text/html');

    // Eliminar la columna de cabecera <th>Archivo</th>
    var table = doc.querySelector('table');
    if (table) {
        var headerRow = table.querySelector('thead tr');
        var headerCells = headerRow.querySelectorAll('th');

        // Encontrar la columna que contiene "<th>Archivo</th>"
        var columnIndexToRemove = -1;
        for (var i = 0; i < headerCells.length; i++) {
            if (headerCells[i].textContent.trim() === 'Archivo') {
                columnIndexToRemove = i;
                break;
            }
        }

        if (columnIndexToRemove >= 0) {
            // Eliminar la columna de la cabecera
            headerRow.removeChild(headerCells[columnIndexToRemove]);
        }
    }

    // Seleccionar todas las filas en el cuerpo de la tabla
    var rows = doc.querySelectorAll('tbody tr');

    // Iterar a través de las filas
    rows.forEach(function (row) {
        // Obtener todas las celdas de la fila
        var cells = row.querySelectorAll('td');

        // Verificar si hay al menos dos celdas en la fila antes de intentar eliminar la penúltima
        if (cells.length >= 2) {
            // Obtener la penúltima celda y eliminarla
            var penultimateCell = cells[cells.length - 2];
            row.removeChild(penultimateCell);
        }
    });

    // Obtener el HTML modificado
    gridContent = doc.documentElement.outerHTML;



    const newWindow = print_popup('');
    const document_ = newWindow.document.open();

    const css = `
            <style type="text/css">
            table {
                border: solid 1px #DDEEEE;
                border-collapse: collapse;
                border-spacing: 0;
                font: normal 12px Arial, sans-serif !important;
            }
            table thead th {
                color: #336B6B;
                padding: 5px;
                text-transform: uppercase;
                font-weight: bold !important;
                border: 1px solid #DDEEEE !important;
            }
            table tbody td {
                border: solid 1px #DDEEEE !important;
                color: #333;
                padding: 4px;
            }
            h3{
                font: bold 12px Arial, sans-serif !important;
                text-transform: uppercase;
            }
            </style>`;

    const pageContent =
        '<!DOCTYPE html>\n' +
        '<html>\n' +
        '<head>\n' +
        '<meta charset="utf-8" />\n' +
        '<title>' + title + '</title>\n' +
        css +
        '</head>\n' +
        '<body>\n' +
        '<center><h3>' + title + '</h3><center>' +
        gridContent +
        '\n</body>\n</html>';

    document_.write(pageContent);
    document_.close();
    newWindow.print();
}
