define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'order/index' + location.search,
                    add_url: 'order/add',
                    edit_url: 'order/edit',
                    del_url: 'order/del',
                    multi_url: 'order/multi',
                    import_url: 'order/import',
                    table: 'order',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'order_id',
                sortName: 'order_id',
                fixedColumns: true,
                fixedRightNumber: 1,
                columns: [
                    [
                        {checkbox: true},
                        {field: 'order_id', title: __('Order_id')},
                        {field: 'member_id', title: __('Member_id')},
                        {field: 'orderno', title: __('Orderno'), operate: 'LIKE'},
                        {field: 'trade_id', title: __('Trade_id'), operate: 'LIKE'},
                        {field: 'amount', title: __('Amount'), operate:'BETWEEN'},
                        {field: 'actual_amount', title: __('Actual_amount'), operate:'BETWEEN'},
                        {field: 'token', title: __('Token'), operate: 'LIKE'},
                        {field: 'payment_url', title: __('Payment_url'), operate: 'LIKE', formatter: Table.api.formatter.url},
                        {field: 'addtime', title: __('Addtime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false},
                        {field: 'status', title: __('Status'), searchList: {"-1":__('Status -1'),"0":__('Status 0'),"1":__('Status 1')}, formatter: Table.api.formatter.status},
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
