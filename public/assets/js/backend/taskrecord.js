define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'taskrecord/index' + location.search,
                    add_url: 'taskrecord/add',
                    edit_url: 'taskrecord/edit',
                    //del_url: 'taskrecord/del',
                    multi_url: 'taskrecord/multi',
                    import_url: 'taskrecord/import',
                    table: 'taskrecord',
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
                        //{field: 'id', title: __('Id')},
                        {field: 'taskid', title: /*__('Taskid')*/"编译ID"},
                        //{field: 'teacher', title: __('Teacher')},
                        {field: 'subtime', title: __('Subtime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'uid1', title: /*__('Uid')*/"姓名"},
                        {field: 'uid', title: /*__('Uid')*/"用户ID"},
                        {field: 'operate', title: /*__('Operate')*/"查看代码", table: table, events: Table.api.events.operate, formatter: function(value, row, index) {
                            // 自定义操作按钮的formatter
                            var html = [];
                            html.push('<a href="javascript:;" class="btn btn-success btn-editone btn-xs" title="查看代码"><i class="fa fa-pencil"></i></a>');
                            return html.join('');
                        }}
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
