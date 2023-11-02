define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'sell/index' + location.search,
                    add_url: 'sell/add',
                    edit_url: 'sell/edit',
                    del_url: 'sell/del',
                    multi_url: 'sell/multi',
                    import_url: 'sell/import',
                    table: 'sell',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'sell_id',
                sortName: 'sell_id',
                fixedColumns: true,
                fixedRightNumber: 1,
                columns: [
                    [
                        {checkbox: true},
                        {field: 'sell_id', title: __('Sell_id')},
                        {field: 'url', title: __('Url'), operate: 'LIKE', formatter: Table.api.formatter.url},
                        {field: 'money', title: __('Money')},
                        {field: 'type', title: __('Type'), searchList: {"0":__('Type 0'),"1":__('Type 1')}, formatter: Table.api.formatter.normal},
                        {field: 'paymoney', title: __('Paymoney')},
                        {field: 'status', title: __('Status'), searchList: {"0":__('Status 0'),"1":__('Status 1'),"2":__('Status 2')}, formatter: Table.api.formatter.status},
                        {field: 'contact', title: __('Contact'), operate: 'LIKE'},
                        {field: 'contype', title: __('Contype'), searchList: {"0":__('Contype 0'),"1":__('Contype 1'),"2":__('Contype 2'),"3":__('Contype 3')}, formatter: Table.api.formatter.normal},
                        {field: 'apiurl', title: __('Apiurl'), operate: 'LIKE', formatter: Table.api.formatter.url},
                        {field: 'isuse', title: __('Isuse'), searchList: {"0":__('Isuse 0'),"1":__('Isuse 1')}, formatter: Table.api.formatter.normal},
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
