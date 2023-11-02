define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'functions/index' + location.search,
                    add_url: 'functions/add',
                    edit_url: 'functions/edit',
                    del_url: 'functions/del',
                    multi_url: 'functions/multi',
                    import_url: 'functions/import',
                    table: 'functions',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'functions_id',
                sortName: 'functions_id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'functions_id', title: __('Functions_id')},
                        {field: 'key', title: __('Key'), operate: 'LIKE'},
                        {field: 'msg', title: __('Msg'), operate: 'LIKE'},
                        {field: 'addtime', title: __('Addtime'), operate: 'LIKE'},
                        {field: 'update', title: __('Update'), operate: 'LIKE'},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});
