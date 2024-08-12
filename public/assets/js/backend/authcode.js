define(['jquery', 'bootstrap', 'backend', 'table', 'form', 'editable'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'authcode/index' + location.search,
                    add_url: 'authcode/add',
                    edit_url: 'authcode/edit',
                    del_url: 'authcode/del',
                    multi_url: 'authcode/multi',
                    import_url: 'authcode/import',
                    table: 'authcode',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'classid', title: /*__('Classid')*/"绑定班级"},
                        {field: 'code', title: __('Code'), editable: true},
                        {field: 'isusing', title: __('Isusing'),
                        editable: {
                            type: 'select',
                            pk: 1,
                            source: [
                                {value: 1, text: '启用'},
                                {value: 0, text: '停用'},
                            ]
                        }},
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
