define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'cash/index' + location.search,
                    add_url: 'cash/add',
                    edit_url: 'cash/edit',
                    del_url: 'cash/del',
                    multi_url: 'cash/multi',
                    import_url: 'cash/import',
                    table: 'cash',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'cash_id',
                sortName: 'cash_id',
                fixedColumns: true,
                fixedRightNumber: 1,
                columns: [
                    [
                        {checkbox: true},
                        {field: 'cash_id', title: __('Cash_id')},
                        {field: 'member_id', title: __('Member_id')},
                        {field: 'money', title: __('Money'), operate:'BETWEEN'},
                        {field: 'actualmoney', title: __('Actualmoney'), operate:'BETWEEN'},
                        {field: 'surplus', title: __('Surplus'), operate:'BETWEEN'},
                        {field: 'status', title: __('Status'), searchList: {"-1":__('Status -1'),"0":__('Status 0'),"1":__('Status 1')}, formatter: Table.api.formatter.status},
                        {field: 'msg', title: __('Msg'), operate: 'LIKE'},
                        {field: 'utoken', title: __('Utoken'), operate: 'LIKE'},
                        {field: 'file', title: __('File'), operate: false, formatter: Table.api.formatter.file},
                        {field: 'addtime', title: __('Addtime'), operate: 'LIKE'},
                        {field: 'updatetime', title: __('Updatetime'), operate: 'LIKE'},
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
