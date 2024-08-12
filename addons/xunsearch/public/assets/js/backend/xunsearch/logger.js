define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'xunsearch/logger/index' + location.search,
                    add_url: 'xunsearch/logger/add' + location.search,
                    edit_url: 'xunsearch/logger/edit' + location.search,
                    del_url: 'xunsearch/logger/del' + location.search,
                    multi_url: 'xunsearch/logger/multi',
                    table: 'xunsearch_logger',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'word',
                sortName: 'word',
                commonSearch: false,
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id'), visible: false},
                        {field: 'word', title: __('Word')},
                        {field: 'nums', title: __('Nums')},
                        {
                            field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate, buttons: [
                                {
                                    name: "search",
                                    text: "搜索结果",
                                    classname: "btn btn-xs btn-info",
                                    icon: "fa fa-search",
                                    url: Config.project_url + "?q={ids}",
                                    extend: "target='_blank'",
                                }
                            ]
                        }
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