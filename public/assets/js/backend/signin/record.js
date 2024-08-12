define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'signin.record/index' + location.search,
                    add_url: 'signin.record/add',
                    edit_url: 'signin.record/edit',
                    del_url: 'signin.record/del',
                    multi_url: 'signin.record/multi',
                    import_url: 'signin.record/import',
                    table: 'signin_record',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'record_id',
                sortName: 'record_id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'record_id', title: __('Record_id')},
                        {field: 'signinid', title: __('Signinid')},
                        {field: 'userid', title: __('Userid')},
                        {field: 'time', title: __('Time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
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
