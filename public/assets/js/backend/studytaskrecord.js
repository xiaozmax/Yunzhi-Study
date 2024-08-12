define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'studytaskrecord/index' + location.search,
                    add_url: 'studytaskrecord/add',
                    edit_url: 'studytaskrecord/edit',
                    //del_url: 'studytaskrecord/del',
                    multi_url: 'studytaskrecord/multi',
                    import_url: 'studytaskrecord/import',
                    table: 'studytaskrecord',
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
                        {field: 'id', title: /*__('Id')*/"任务记录ID"},
                        {field: 'uid', title: __('Uid')},
                        {field: 'uidn', title: "用户名"},
                        {field: 'study_taskid', title: __('Study_taskid')},
                        {field: 'study_taskidt', title: "学习任务"},
                        {field: 'done', title: __('Done'), formatter: function(value, row, index) {
                            return value != 0 ? "<a style='color:green;'>已完成</a>" : "<a style='color:red;'>未完成</a>";
                        }},
                        {field: 'operate', title: /*__('Operate')*/"查看记录", table: table, events: Table.api.events.operate, formatter: function(value, row, index) {
                            // 自定义操作按钮的formatter
                            var html = [];
                            html.push('<a href="javascript:;" class="btn btn-success btn-editone btn-xs" title="查看记录"><i class="fa fa-pencil"></i></a>');
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
