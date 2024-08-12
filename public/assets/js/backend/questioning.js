define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'questioning/index' + location.search,
                    add_url: 'questioning/add',
                    edit_url: 'questioning/edit',
                    //del_url: 'questioning/del',
                    multi_url: 'questioning/multi',
                    import_url: 'questioning/import',
                    table: 'questioning',
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
                        {field: 'id', title: /*__('Id')*/"提问ID"},
                        {field: 'uid', title: /*__('Uid')*/"用户名"},
                        {field: 'study_taskid', title: /*__('Study_taskid')*/"学习任务"},
                        //{field: 'task_record_id', title: "编译ID"},
                        {field: 'content', title: __('content'), formatter: function(value, row, index) {
                            var maxLength = 30; // 设置最大长度
                            var tempDiv = document.createElement('div');
                            // 确保value是字符串
                            tempDiv.innerHTML = String(value);
                            var text = tempDiv.textContent || tempDiv.innerText;
                            text = text.replace(/\s+/g, ' ').trim();
                            if (text.length > maxLength) {
                                return text.substring(0, maxLength) + '...';
                            }
                            return text;
                        }},
                        {field: 'reply_content', title: "回答情况", formatter: function(value, row, index) {
                            return !!value ? '已回答' : "<a style='color:red;'>未回答</a>";
                        }},
                        {field: 'operate', title: /*__('Operate')*/"回答问题", table: table, events: Table.api.events.operate, formatter: function(value, row, index) {
                            // 自定义操作按钮的formatter
                            var html = [];
                            html.push('<a href="javascript:;" class="btn btn-success btn-editone btn-xs" title="回答问题"><i class="fa fa-pencil"></i></a>');
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
