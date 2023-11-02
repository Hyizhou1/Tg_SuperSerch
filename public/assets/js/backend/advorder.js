define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'advorder/index' + location.search,
                    add_url: 'advorder/add',
                    edit_url: 'advorder/edit',
                    del_url: 'advorder/del',
                    multi_url: 'advorder/multi',
                    import_url: 'advorder/import',
                    table: 'advorder',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'advorder_id',
                sortName: 'advorder_id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'advorder_id', title: __('Advorder_id')},
                        {field: 'advorderno', title: __('Advorderno'), operate: 'LIKE'},
                        {field: 'member_id', title: __('Member_id')},
                        {field: 'advtype', title: __('Advtype')},
                        {field: 'money', title: __('Money'), operate:'BETWEEN'},
                        {field: 'other', title: __('Other'), operate: 'LIKE'},
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
