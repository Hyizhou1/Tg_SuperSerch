define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'weight/index' + location.search,
                    add_url: 'weight/add',
                    edit_url: 'weight/edit',
                    del_url: 'weight/del',
                    multi_url: 'weight/multi',
                    import_url: 'weight/import',
                    table: 'weight',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'weight_id',
                sortName: 'weight_id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'weight_id', title: __('Weight_id')},
                        {field: 'group_id', title: __('Group_id')},
                        {field: 'keyword_id', title: __('Keyword_id')},
                        {field: 'sort', title: __('Sort')},
                        {field: 'payadv', title: __('Payadv')},
                        {field: 'addtime', title: __('Addtime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'keyword.title', title: __('Keyword.title'), operate: 'LIKE'},
                        {field: 'keyword.money', title: __('Keyword.money'), operate:'BETWEEN'},
                        {field: 'group.tggroup_id', title: __('Group.tggroup_id'), operate: 'LIKE'},
                        {field: 'group.group_username', title: __('Group.group_username'), operate: 'LIKE'},
                        {field: 'group.group_nick', title: __('Group.group_nick'), operate: 'LIKE'},
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
