define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'coin/index' + location.search,
                    add_url: 'coin/add',
                    edit_url: 'coin/edit',
                    del_url: 'coin/del',
                    multi_url: 'coin/multi',
                    import_url: 'coin/import',
                    table: 'coin',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'coin_id',
                sortName: 'coin_id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'coin_id', title: __('Coin_id')},
                        {field: 'member_id', title: __('Member_id')},
                        {field: 'type', title: __('Type'), searchList: {"0":__('Type 0'),"1":__('Type 1')}, formatter: Table.api.formatter.normal},
                        {field: 'number', title: __('Number')},
                        {field: 'msg', title: __('Msg'), operate: 'LIKE'},
                        {field: 'status', title: __('Status'), searchList: {"0":__('Status 0'),"1":__('Status 1')}, formatter: Table.api.formatter.status},
                        {field: 'addtime', title: __('Addtime'), operate: 'LIKE'},
                        {field: 'member.tg_id', title: __('Member.tg_id'), operate: 'LIKE'},
                        {field: 'member.username', title: __('Member.username'), operate: 'LIKE'},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate,formatter: Table.api.formatter.operate}
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
