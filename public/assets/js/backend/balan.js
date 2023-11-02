define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'balan/index' + location.search,
                    add_url: 'balan/add',
                    edit_url: 'balan/edit',
                    del_url: 'balan/del',
                    multi_url: 'balan/multi',
                    import_url: 'balan/import',
                    table: 'balan',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'balan_id',
                sortName: 'balan_id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'balan_id', title: __('Balan_id')},
                        {field: 'member_id', title: __('Member_id')},
                        {field: 'money', title: __('Money'), operate:'BETWEEN'},
                        {field: 'msg', title: __('Msg'), operate: 'LIKE'},
                        {field: 'addtime', title: __('Addtime'), operate: 'LIKE'},
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
