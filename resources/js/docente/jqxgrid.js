const initTable = async (jqxTable) => {
    const url = 'reporte-getdocentes';
    const root = 'docentes';
    debugger
    const source = jqxDefaultSource(url, root, _datafields());
    const dataAdapter = jqxDefaultDataAdapter(source, jqxTable);

    jqxDefaultInit(jqxTable, dataAdapter);
}

const _datafields = () => {
    return [{
        name: 'dni',
        type: 'int'
    }];
}

const _columns = () => {
    return [{
        datafield: 'dni',
        text: 'DNI',
        cellsalign: 'left',
    }];
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
        showaggregates: true,
        columnsreorder: true,
        showstatusbar: true,
        statusbarheight: 20,
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


