define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'advtype/index' + location.search,
                    add_url: 'advtype/add',
                    edit_url: 'advtype/edit',
                    del_url: 'advtype/del',
                    multi_url: 'advtype/multi',
                    import_url: 'advtype/import',
                    table: 'advtype',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'advtype_id',
                sortName: 'advtype_id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'advtype_id', title: __('Advtype_id')},
                        {field: 'name', title: __('Name'), operate: 'LIKE'},
                        {field: 'money', title: __('Money'), operate:'BETWEEN'},
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
