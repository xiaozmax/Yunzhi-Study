define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'studytask/index' + location.search,
                    add_url: 'studytask/add',
                    edit_url: 'studytask/edit',
                    del_url: 'studytask/del',
                    multi_url: 'studytask/multi',
                    import_url: 'studytask/import',
                    table: 'studytask',
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
                        {field: 'title', title: __('title')},
                        {field: 'content', title: __('content'), formatter: function(value, row, index) {
                            var maxLength = 80; // 设置最大长度
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
                        {field: 'class_id', title: __('Class_id')},
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
