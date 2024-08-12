define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'article/index' + location.search,
                    add_url: 'article/add',
                    edit_url: 'article/edit',
                    del_url: 'article/del',
                    multi_url: 'article/multi',
                    import_url: 'article/import',
                    table: 'article',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'article_id',
                sortName: 'article_id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'article_id', title: "文章ID"},
                        {field: 'title', title: __('Title')},
                        {field: 'category_id', title: /*__('Category_id')*/"分类"},
                        {field: 'weight', title: __('Weight')},
                        {field: 'isshow', title: __('Isshow'), formatter: function(value, row, index) {
                            return value != 0 ? '展示' : "<a style='color:red;'>隐藏</a>";
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
