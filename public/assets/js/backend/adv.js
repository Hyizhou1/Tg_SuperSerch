define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'adv/index' + location.search,
                    add_url: 'adv/add',
                    edit_url: 'adv/edit',
                    del_url: 'adv/del',
                    multi_url: 'adv/multi',
                    import_url: 'adv/import',
                    table: 'adv',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'adv_id',
                sortName: 'adv_id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'adv_id', title: __('Adv_id')},
                        {field: 'member_id', title: __('Member_id')},
                        {field: 'advtype_id', title: __('Advtype_id')},
                        {field: 'content', title: __('Content'), operate: 'LIKE'},
                        {field: 'url', title: __('Url'), operate: 'LIKE', formatter: Table.api.formatter.url},
                        {field: 'addtime', title: __('Addtime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false},
                        {field: 'endtime', title: __('Endtime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false},
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
