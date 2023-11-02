define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'getmessage/index' + location.search,
                    add_url: 'getmessage/add',
                    edit_url: 'getmessage/edit',
                    del_url: 'getmessage/del',
                    multi_url: 'getmessage/multi',
                    import_url: 'getmessage/import',
                    table: 'getmessage',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'getmessage_id',
                sortName: 'getmessage_id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'getmessage_id', title: __('Getmessage_id')},
                        {field: 'chatid', title: __('Chatid'), operate: 'LIKE'},
                        {field: 'userid', title: __('Userid'), operate: 'LIKE'},
                        {field: 'type', title: __('Type'), operate: 'LIKE'},
                        {field: 'username', title: __('Username'), operate: 'LIKE'},
                        {field: 'firstName', title: __('Firstname'), operate: 'LIKE'},
                        {field: 'lastName', title: __('Lastname'), operate: 'LIKE'},
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
