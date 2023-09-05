const initTable = async (jqxTable) => {
    const url = 'reporte-getinstituciones';
    const root = 'instituciones';

    const source = jqxDefaultSource(url, root, _datafields());
    const dataAdapter = jqxDefaultDataAdapter(source, jqxTable);

    jqxDefaultInit(jqxTable, dataAdapter);
}

const _datafields = () => {
    return [
        { name: 'codigo', type: 'string' },
        { name: 'descripcion', type: 'string' },
        { name: 'niveles', type: 'string' },
        // { name: 'apellidos', type: 'string' },
        // { name: 'direccion', type: 'string' },
        // { name: 'telefono', type: 'string' },
        // { name: 'asignatura', type: 'string' },
        // { name: 'estado', type: 'string' }
    ];
}

const _columns = () => {
    return [
        {
            datafield: 'codigo',
            text: 'Codigo',
            cellsalign: 'left',
        },
        {
            datafield: 'descripcion',
            text: 'Descripcion',
            cellsalign: 'left',
        },
        {
            datafield: 'niveles',
            text: 'Niveles',
            cellsalign: 'left',
        }
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
        sortable: true,
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
    const gridContent = $(jqxTable).jqxGrid('exportdata', 'html').replace(/font-size:10px;/g, "").replace(/formatString:;dataType:string;/g, "").replace(/height:[^;]*;/g, "");

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
