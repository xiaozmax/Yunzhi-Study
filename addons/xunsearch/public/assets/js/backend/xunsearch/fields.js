define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'xunsearch/fields/index' + location.search,
                    add_url: 'xunsearch/fields/add' + location.search,
                    edit_url: 'xunsearch/fields/edit',
                    del_url: 'xunsearch/fields/del',
                    multi_url: 'xunsearch/fields/multi',
                    table: 'xunsearch_field',
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
                        {field: 'project_id', title: __('Project_id'), visible: false},
                        {field: 'name', title: __('Name')},
                        {field: 'title', title: __('Title')},
                        {field: 'type', title: __('Type'), searchList: {"string": 'string', "numeric": 'numeric', "date": 'date', "id": 'id', "title": 'title', "body": 'body'}, formatter: Table.api.formatter.normal},
                        {field: 'index', title: __('Index'), searchList: {"none": 'none', "self": 'self', "mixed": 'mixed', "both": 'both'}, formatter: Table.api.formatter.normal},
                        {field: 'tokenizer', title: __('Tokenizer'), visible: false},
                        {field: 'cutlen', title: __('Cutlen'), visible: false},
                        {field: 'weight', title: __('Weight'), visible: false},
                        {field: 'non_bool', title: __('Non_bool'), searchList: {"yes": __('Yes'), "no": __('No')}, formatter: Table.api.formatter.toggle},
                        {field: 'phrase', title: __('Phrase'), searchList: {"yes": __('Yes'), "no": __('No')}, formatter: Table.api.formatter.toggle},
                        {field: 'sortable', title: __('Sortable'), searchList: {"1": __('Yes'), "0": __('No')}, formatter: Table.api.formatter.toggle},
                        {field: 'extra', title: __('Extra'), searchList: {"1": __('Yes'), "0": __('No')}, formatter: Table.api.formatter.toggle},
                        {field: 'createtime', title: __('Createtime'), operate: 'RANGE', addclass: 'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'updatetime', title: __('Updatetime'), operate: 'RANGE', addclass: 'datetimerange', formatter: Table.api.formatter.datetime, visible: false},
                        {field: 'status', title: __('Status'), searchList: {"normal": __('Normal'), "hidden": __('Hidden')}, formatter: Table.api.formatter.status},
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
                $.validator.config({
                    rules: {
                        name: function (element) {
                            if (element.value.toString().match(/^\d+$/)) {
                                return __('Can not be digital');
                            }
                            if (!element.value.toString().match(/^\w{2,30}$/)) {
                                return "请填写2-30位数字、字母、下划线";
                            }
                            return $.ajax({
                                url: 'xunsearch/fields/check_element_available',
                                type: 'POST',
                                data: {project_id: $("#c-project_id").val(), id: $("#c-field_id").val(), name: element.name, value: element.value},
                                dataType: 'json'
                            });
                        }
                    }
                });
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});