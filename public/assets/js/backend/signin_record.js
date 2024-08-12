define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'signin_record/index' + location.search,
                    add_url: 'signin_record/add',
                    edit_url: 'signin_record/edit',
                    del_url: 'signin_record/del',
                    multi_url: 'signin_record/multi',
                    import_url: 'signin_record/import',
                    table: 'signin_record',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'sign_id',
                sortName: 'sign_id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'sign_id', title: __('Sign_id')},
                        {field: 'user_id', title: __('User_id')},
                        {field: 'time', title: __('Time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'ip', title: __('Ip')},
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
