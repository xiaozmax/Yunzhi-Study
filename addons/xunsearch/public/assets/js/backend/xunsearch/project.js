define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'xunsearch/project/index' + location.search,
                    add_url: 'xunsearch/project/add',
                    edit_url: 'xunsearch/project/edit',
                    del_url: 'xunsearch/project/del',
                    multi_url: 'xunsearch/project/multi',
                    table: 'xunsearch_project',
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
                        {field: 'name', title: __('Name')},
                        {field: 'title', title: __('Title')},
                        {field: 'charset', title: __('Charset')},
                        {field: 'indexstatus', title: __('Serverindex'), formatter: Controller.api.formatter.portstatus},
                        {field: 'searchstatus', title: __('Serversearch'), formatter: Controller.api.formatter.portstatus},
                        {
                            field: 'view', title: __('前台'), formatter: function (value, row, index) {
                                return '<a href="' + row['url'] + "" + '" target="_blank" class="btn btn-xs btn-success"><i class="fa fa-home"></i></a>';
                            }
                        },
                        {field: 'createtime', title: __('Createtime'), operate: 'RANGE', addclass: 'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'updatetime', title: __('Updatetime'), visible: false, operate: 'RANGE', addclass: 'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'status', title: __('Status'), searchList: {"normal": __('Normal'), "hidden": __('Hidden')}, formatter: Table.api.formatter.status},
                        {
                            field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate,
                            buttons: [
                                {
                                    name: "fields",
                                    text: "字段列表",
                                    classname: "btn btn-xs btn-info btn-dialog",
                                    icon: "fa fa-list",
                                    url: "xunsearch/fields?project_id={ids}"
                                },
                                {
                                    name: "logger",
                                    text: "搜索词列表",
                                    classname: "btn btn-xs btn-success btn-dialog",
                                    icon: "fa fa-list",
                                    url: "xunsearch/logger?project_id={ids}"
                                },
                                {
                                    name: "configure",
                                    text: "生成配置",
                                    confirm: "确认生成配置文件？<br><span class='text-danger'>此操作将会覆盖现有的配置文件!</span>",
                                    classname: "btn btn-xs btn-warning btn-ajax",
                                    icon: "fa fa-gear",
                                    url: "xunsearch/project/refresh?project_id={ids}"
                                },
                                {
                                    name: "reset",
                                    text: "重置索引",
                                    disable: function (row, index) {
                                        return parseInt(row['isreset']) == 0 ? true : false;
                                    },
                                    confirm: "确认重置索引数据库？<br><span class='text-danger'>如果数据量较大，建议使用命令行重置!</span>",
                                    classname: "btn btn-xs btn-danger btn-ajax",
                                    icon: "fa fa-database",
                                    url: "xunsearch/project/reset?project_id={ids}",
                                },
                                {
                                    name: "flush",
                                    text: "强制刷新",
                                    classname: "btn btn-xs btn-primary btn-ajax",
                                    icon: "fa fa-refresh",
                                    url: "xunsearch/project/flush?project_id={ids}",
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

                $.validator.config({
                    rules: {
                        name: function (element) {
                            if (element.value.toString().match(/^\d+$/)) {
                                return __('Can not be digital');
                            }
                            return $.ajax({
                                url: 'xunsearch/project/check_element_available',
                                type: 'POST',
                                data: {id: $("#project-id").val(), name: element.name, value: element.value},
                                dataType: 'json'
                            });
                        }
                    }
                });
                Form.api.bindevent($("form[role=form]"));
            },
            formatter: {
                portstatus: function (value, row, index) {
                    if (value) {
                        return '<span class="text-success btn-status"><i class="fa fa-circle"></i> 正常</span>';
                    } else {
                        return '<span class="text-danger btn-status"><i class="fa fa-circle"></i> 检测失败</span>';
                    }
                }
            }
        }
    };
    return Controller;
});
