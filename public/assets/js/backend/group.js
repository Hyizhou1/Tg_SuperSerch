define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'group/index' + location.search,
                    add_url: 'group/add',
                    edit_url: 'group/edit',
                    del_url: 'group/del',
                    multi_url: 'group/multi',
                    import_url: 'group/import',
                    table: 'group',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'group_id',
                sortName: 'group_id',
                fixedColumns: true,
                fixedRightNumber: 1,
                columns: [
                    [
                        {checkbox: true},
                        {field: 'group_id', title: __('Group_id')},
                        {field: 'member_id', title: __('Member_id')},
                        {field: 'tggroup_id', title: __('Tggroup_id'), operate: 'LIKE'},
                        {field: 'group_username', title: __('Group_username'), operate: 'LIKE'},
                        {field: 'group_type', title: __('Group_type'), searchList: {"0":__('Group_type 0'),"1":__('Group_type 1')}, formatter: Table.api.formatter.normal},
                        {field: 'group_nick', title: __('Group_nick'), operate: 'LIKE'},
                        {field: 'group_count', title: __('Group_count')},
                        {field: 'group_img', title: __('Group_img'), operate: 'LIKE'},
                        {field: 'iscj', title: __('Iscj'), searchList: {"0":__('Iscj 0'),"1":__('Iscj 1')}, formatter: Table.api.formatter.normal},
                        {field: 'issearch', title: __('Issearch'), searchList: {"0":__('Issearch 0'),"1":__('Issearch 1')}, formatter: Table.api.formatter.normal},
                        {field: 'istop', title: __('Istop'), searchList: {"0":__('Istop 0'),"1":__('Istop 1')}, formatter: Table.api.formatter.normal},
                        {field: 'isshield', title: __('Isshield'), searchList: {"0":__('Isshield 0'),"1":__('Isshield 1'),"2":__('Isshield 2')}, formatter: Table.api.formatter.normal},
                        {field: 'isenter', title: __('Isenter'), searchList: {"0":__('Isenter 0'),"1":__('Isenter 1'),"2":__('Isenter 2')}, formatter: Table.api.formatter.normal},
                        {field: 'entertype', title: __('Entertype'), searchList: {"0":__('Entertype 0'),"1":__('Entertype 1'),"2":__('Entertype 2')}, formatter: Table.api.formatter.normal},
                        {field: 'fileurl', title: __('Fileurl'), operate: 'LIKE', formatter: Table.api.formatter.url},
                        {field: 'isenteradv', title: __('Isenteradv'), searchList: {"0":__('Isenteradv 0'),"1":__('Isenteradv 1')}, formatter: Table.api.formatter.normal},
                        {field: 'timeadv', title: __('Timeadv'), searchList: {"0":__('Timeadv 0'),"1":__('Timeadv 1'),"2":__('Timeadv 2')}, formatter: Table.api.formatter.normal},
                        {field: 'timetype', title: __('Timetype'), searchList: {"0":__('Timetype 0'),"1":__('Timetype 1'),"2":__('Timetype 2')}, formatter: Table.api.formatter.normal},
                        {field: 'timefileurl', title: __('Timefileurl'), operate: 'LIKE', formatter: Table.api.formatter.url},
                        {field: 'handle', title: __('Handle'), searchList: {"0":__('Handle 0'),"1":__('Handle 1')}, formatter: Table.api.formatter.normal},
                        {field: 'searchcount', title: __('Searchcount')},
                        {field: 'group_status', title: __('Group_status'), searchList: {"0":__('Group_status 0'),"1":__('Group_status 1')}, formatter: Table.api.formatter.status},
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
