let DataTable = {
    getProductCategories: function (ajaxUrl) {
        var table = $("#data_table").DataTable({
            responsive: true,
            bAutoWidth: false,
            "dom": 'frtip',
            "pageLength": 30,
            "searchDelay": 1500,
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": ajaxUrl,

                dataSrc: function (json) {
                    if (!json.recordsTotal) {
                        return false;
                    }
                    return json.data;
                }
            },

            "columns": [
                {"data": "id", "orderable": true,},
                {"data": "name", "orderable": true},
                {"data": "parent", "name":"parent.name","orderable": true}
            ],

        });
    },


};
