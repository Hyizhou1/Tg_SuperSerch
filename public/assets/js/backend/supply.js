define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'supply/index' + location.search,
                    add_url: 'supply/add',
                    edit_url: 'supply/edit',
                    del_url: 'supply/del',
                    multi_url: 'supply/multi',
                    import_url: 'supply/import',
                    table: 'supply',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'supply_id',
                sortName: 'supply_id',
                fixedColumns: true,
                fixedRightNumber: 1,
                columns: [
                    [
                        {checkbox: true},
                        {field: 'supply_id', title: __('Supply_id')},
                        {field: 'member_id', title: __('Member_id')},
                        {field: 'title', title: __('Title'), operate: 'LIKE'},
                        {field: 'moneyqj', title: __('Moneyqj'), operate: 'LIKE'},
                        {field: 'image', title: __('Image'), operate: false, events: Table.api.events.image, formatter: Table.api.formatter.image},
                        {field: 'messid', title: __('Messid'), operate: 'LIKE'},
                        {field: 'desu_id', title: __('Desu_id'), operate: 'LIKE'},
                        {field: 'type', title: __('Type'), searchList: {"0":__('Type 0'),"1":__('Type 1')}, formatter: Table.api.formatter.normal},
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
