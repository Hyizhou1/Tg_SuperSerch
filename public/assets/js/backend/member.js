define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'member/index' + location.search,
                    add_url: 'member/add',
                    edit_url: 'member/edit',
                    del_url: 'member/del',
                    multi_url: 'member/multi',
                    import_url: 'member/import',
                    table: 'member',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'member',
                sortName: 'member',
                fixedColumns: true,
                fixedRightNumber: 1,
                columns: [
                    [
                        {checkbox: true},
                        {field: 'member', title: __('Member')},
                        {field: 'tg_id', title: __('Tg_id'), operate: 'LIKE'},
                        {field: 'username', title: __('Username'), operate: 'LIKE'},
                        {field: 'firstname', title: __('Firstname'), operate: 'LIKE'},
                        {field: 'lastname', title: __('Lastname'), operate: 'LIKE'},
                        {field: 'headimg', title: __('Headimg'), operate: 'LIKE'},
                        {field: 'money', title: __('Money'), operate:'BETWEEN'},
                        {field: 'coin', title: __('Coin')},
                        {field: 'utoken', title: __('Utoken'), operate: 'LIKE'},
                        {field: 'ishhr', title: __('Ishhr'), searchList: {"0":__('Ishhr 0'),"1":__('Ishhr 1')}, formatter: Table.api.formatter.normal},
                        {field: 'member_id', title: __('Member_id')},
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
