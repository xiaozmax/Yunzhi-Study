define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'signin/index' + location.search,
                    add_url: 'signin/add',
                    edit_url: 'signin/edit',
                    del_url: 'signin/del',
                    multi_url: 'signin/multi',
                    import_url: 'signin/import',
                    table: 'signin',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'sign_id',
                sortName: 'sign_id',
                columns: [
                    [
                        { checkbox: true },
                        //{field: 'sign_id', title: __('Sign_id')},
                        { field: 'userrange', title: __('Userrange') },
                        {
                            field: 'name',
                            title: '签到名称',
                            formatter: function (value, row, index) {
                                // 返回一个可点击的HTML链接
                                return '<a href="javascript:;" class="click-name" data-id="' + row.sign_id + '">' + value + '</a>';
                            }
                        },
                        { field: 'starttime', title: __('Starttime'), operate: 'RANGE', addclass: 'datetimerange', autocomplete: false, formatter: Table.api.formatter.datetime },
                        { field: 'endtime', title: __('Endtime'), operate: 'RANGE', addclass: 'datetimerange', autocomplete: false, formatter: Table.api.formatter.datetime },
                        { field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate }
                    ]
                ]
            });

            $(document).on('click', '.click-name', function () {
                var signinId = $(this).data('id');
                // 使用Layer弹出内部弹窗
                Layer.open({
                    type: 2,
                    title: '签到记录',
                    shadeClose: true,
                    shade: false,
                    maxmin: true, // 开启最大化最小化按钮
                    area: ['893px', '600px'],
                    content: 'signin/record?id=' + signinId
                });
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
