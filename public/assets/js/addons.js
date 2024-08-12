define([], function () {
    require(['../addons/bootstrapcontextmenu/js/bootstrap-contextmenu'], function (undefined) {
    if (Config.controllername == 'index' && Config.actionname == 'index') {
        $("body").append(
            '<div id="context-menu">' +
            '<ul class="dropdown-menu" role="menu">' +
            '<li><a tabindex="-1" data-operate="refresh"><i class="fa fa-refresh fa-fw"></i>刷新</a></li>' +
            '<li><a tabindex="-1" data-operate="refreshTable"><i class="fa fa-table fa-fw"></i>刷新表格</a></li>' +
            '<li><a tabindex="-1" data-operate="close"><i class="fa fa-close fa-fw"></i>关闭</a></li>' +
            '<li><a tabindex="-1" data-operate="closeOther"><i class="fa fa-window-close-o fa-fw"></i>关闭其他</a></li>' +
            '<li class="divider"></li>' +
            '<li><a tabindex="-1" data-operate="closeAll"><i class="fa fa-power-off fa-fw"></i>关闭全部</a></li>' +
            '</ul>' +
            '</div>');

        $(".nav-addtabs").contextmenu({
            target: "#context-menu",
            scopes: 'li[role=presentation]',
            onItem: function (e, event) {
                var $element = $(event.target);
                var tab_id = e.attr('id');
                var id = tab_id.substr('tab_'.length);
                var con_id = 'con_' + id;
                switch ($element.data('operate')) {
                    case 'refresh':
                        $("#" + con_id + " iframe").attr('src', function (i, val) {
                            return val;
                        });
                        break;
                    case 'refreshTable':
                        try {
                            if ($("#" + con_id + " iframe").contents().find(".btn-refresh").size() > 0) {
                                $("#" + con_id + " iframe")[0].contentWindow.$(".btn-refresh").trigger("click");
                            }
                        } catch (e) {

                        }
                        break;
                    case 'close':
                        if (e.find(".close-tab").length > 0) {
                            e.find(".close-tab").click();
                        }
                        break;
                    case 'closeOther':
                        e.parent().find("li[role='presentation']").each(function () {
                            if ($(this).attr('id') == tab_id) {
                                return;
                            }
                            if ($(this).find(".close-tab").length > 0) {
                                $(this).find(".close-tab").click();
                            }
                        });
                        break;
                    case 'closeAll':
                        e.parent().find("li[role='presentation']").each(function () {
                            if ($(this).find(".close-tab").length > 0) {
                                $(this).find(".close-tab").click();
                            }
                        });
                        break;
                    default:
                        break;
                }
            }
        });
    }
    $(document).on('click', function () { // iframe内点击 隐藏菜单
        try {
            top.window.$(".nav-addtabs").contextmenu("closemenu");
        } catch (e) {
        }
    });

});
require.config({
    paths: {
        'clicaptcha': '../addons/clicaptcha/js/clicaptcha'
    },
    shim: {
        'clicaptcha': {
            deps: [
                'jquery',
                'css!../addons/clicaptcha/css/clicaptcha.css'
            ],
            exports: '$.fn.clicaptcha'
        }
    }
});

require(['form'], function (Form) {
    window.clicaptcha = function (captcha) {
        require(['clicaptcha'], function (undefined) {
            captcha = captcha ? captcha : $("input[name=captcha]");
            if (captcha.length > 0) {
                var form = captcha.closest("form");
                var parentDom = captcha.parent();
                // 非文本验证码
                if ($("a[data-event][data-url]", parentDom).length > 0) {
                    return;
                }
                if (captcha.parentsUntil(form, "div.form-group").length > 0) {
                    captcha.parentsUntil(form, "div.form-group").addClass("hidden");
                } else if (parentDom.is("div.input-group")) {
                    parentDom.addClass("hidden");
                }
                captcha.attr("data-rule", "required");
                // 验证失败时进行操作
                captcha.on('invalid.field', function (e, result, me) {
                    //必须删除errors对象中的数据，否则会出现Layer的Tip
                    delete me.errors['captcha'];
                    captcha.clicaptcha({
                        src: '/addons/clicaptcha/index/start',
                        success_tip: '验证成功！',
                        error_tip: '未点中正确区域，请重试！',
                        callback: function (captchainfo) {
                            form.trigger("submit");
                            return false;
                        }
                    });
                });
                // 监听表单错误事件
                form.on("error.form", function (e, data) {
                    captcha.val('');
                });
            }
        });
    };
    // clicaptcha($("input[name=captcha]"));

    if (typeof Frontend !== 'undefined') {
        Frontend.api.preparecaptcha = function (btn, type, data) {
            require(['form'], function (Form) {
                $("#clicaptchacontainer").remove();
                $("<div />").attr("id", "clicaptchacontainer").addClass("hidden").html(Template("captchatpl", {})).appendTo("body");
                var form = $("#clicaptchacontainer form");
                form.data("validator-options", {
                    valid: function (ret) {
                        data.captcha = $("input[name=captcha]", form).val();
                        Frontend.api.sendcaptcha(btn, type, data, function (data, ret) {
                            console.log("ok");
                        });
                        return true;
                    }
                })
                Form.api.bindevent(form);
            });
        };
    }

    var _bindevent = Form.events.bindevent;
    Form.events.bindevent = function (form) {
        _bindevent.apply(this, [form]);
        var captchaObj = $("input[name=captcha]", form);
        if (captchaObj.length > 0) {
            clicaptcha(captchaObj);
            if ($(form).attr("name") === 'captcha-form') {
                setTimeout(function () {
                    captchaObj.trigger("invalid.field", [{key: 'captcha'}, {errors: {}}]);
                }, 100);
            }
        }
    }
});

//判断系统深色模式变化，修改切换按钮
var matchMedia = window.matchMedia(('(prefers-color-scheme: dark)'));
matchMedia.addEventListener('change', function () {
    var mode = this.matches ? 'dark' : 'light';
    //只有当cookie中无手动定义值时才进行操作
    if (document.cookie.indexOf("thememode=") === -1 && Config.darktheme.mode === 'auto') {
        $("body").toggleClass("darktheme", mode === "dark");
    }
});

if (typeof Config.darktheme !== 'undefined' && Config.darktheme.switchbtn) {

    // 切换模式
    var switchMode = function (mode) {
        // 获取当前深色模式
        if (mode === 'auto') {
            var isDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
            mode = isDarkMode ? 'dark' : 'light';
        }

        if (mode === 'auto') {
        } else if (mode === 'dark') {
            $("body").addClass("darktheme");
            $(".darktheme-link").removeAttr("media");
        } else {
            $("body").removeClass("darktheme");
            $(".darktheme-link").attr("media", "(prefers-color-scheme: dark)");
        }
    };

    // 创建Cookie
    var createCookie = function (name, value) {
        var date = new Date();
        date.setTime(date.getTime() + (365 * 24 * 60 * 60 * 1000));
        var url = Config.moduleurl.replace(location.origin, "");
        var path = url ? url.substring(url.lastIndexOf("/")) : "/";
        document.cookie = encodeURIComponent(Config.cookie.prefix + name) + "=" + encodeURIComponent(value) + "; path=" + path + "; expires=" + date.toGMTString();
    };

    if (Config.controllername === 'index' && Config.actionname === 'index') {
        var mode = Config.darktheme.mode;
        if (mode === 'auto') {
            var isDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
            mode = isDarkMode ? 'dark' : 'light';
        }
        var html = '<li class="theme-li">' +
            '<button type="button" title="切换' + (mode === 'dark' ? '浅色' : '深色') + '模式" data-mode="' + (mode === 'dark' ? 'light' : 'dark') + '" class="theme-toggle">' +
            '<svg class="sun-and-moon" aria-hidden="true" width="24" height="24" viewBox="0 0 24 24">\n' +
            '      <circle class="sun" cx="12" cy="12" r="6" mask="url(#moon-mask)" fill="currentColor" />\n' +
            '      <g class="sun-beams" stroke="currentColor">\n' +
            '        <line x1="12" y1="1" x2="12" y2="3" />\n' +
            '        <line x1="12" y1="21" x2="12" y2="23" />\n' +
            '        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64" />\n' +
            '        <line x1="18.36" y1="18.36" x2="19.78" y2="19.78" />\n' +
            '        <line x1="1" y1="12" x2="3" y2="12" />\n' +
            '        <line x1="21" y1="12" x2="23" y2="12" />\n' +
            '        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36" />\n' +
            '        <line x1="18.36" y1="5.64" x2="19.78" y2="4.22" />\n' +
            '      </g>\n' +
            '      <mask class="moon" id="moon-mask">\n' +
            '        <rect x="0" y="0" width="100%" height="100%" fill="white" />\n' +
            '        <circle cx="24" cy="10" r="6" fill="black" />\n' +
            '      </mask>\n' +
            '    </svg>' +
            '</button>' +
            '</li>';
        $(html).prependTo("#firstnav > div > ul");

        //点击切换按钮
        $(document).on("click", ".theme-toggle", function () {
            var mode = $(this).attr("data-mode");
            switchMode(mode);
            createCookie("thememode", mode);
            $("iframe").each(function () {
                try {
                    $(this)[0].contentWindow.$("body").trigger("swithmode", [mode]);
                } catch (e) {

                }
            });
            $(this).attr("data-mode", mode === 'dark' ? 'light' : 'dark').attr("title", '切换' + (mode === 'dark' ? '浅色' : '深色') + '模式');
        });

        //判断系统深色模式变化，修改切换按钮
        var matchMedia = window.matchMedia(('(prefers-color-scheme: dark)'));
        matchMedia.addEventListener('change', function () {
            var mode = this.matches ? 'dark' : 'light';
            //只有当cookie中无手动定义值时才切换
            if (document.cookie.indexOf("thememode=") === -1 && Config.darktheme.mode === 'auto') {
                $(".theme-toggle").attr("data-mode", mode === 'dark' ? 'light' : 'dark').attr("title", '切换' + (mode === 'dark' ? '浅色' : '深色') + '模式');
            }
        });
    } else {
        //添加事件
        $("body").on("swithmode", function (e, mode) {
            switchMode(mode);
            $("iframe").each(function () {
                try {
                    $(this)[0].contentWindow.$("body").trigger("swithmode", [mode]);
                } catch (e) {

                }
            });
        });
    }
}
require.config({
    paths: {
        'editable': '../libs/bootstrap-table/dist/extensions/editable/bootstrap-table-editable.min',
        'x-editable': '../addons/editable/js/bootstrap-editable.min',
    },
    shim: {
        'editable': {
            deps: ['x-editable', 'bootstrap-table']
        },
        "x-editable": {
            deps: ["css!../addons/editable/css/bootstrap-editable.css"],
        }
    }
});
if ($("table.table").length > 0) {
    require(['editable', 'table'], function (Editable, Table) {
        $.fn.bootstrapTable.defaults.onEditableSave = function (field, row, oldValue, $el) {
            var data = {};
            data["row[" + field + "]"] = row[field];
            Fast.api.ajax({
                url: this.extend.edit_url + "/ids/" + row[this.pk],
                data: data
            });
        };
    });
}

window.UEDITOR_HOME_URL = Config.__CDN__ + "/assets/addons/ueditor/";
require.config({
    paths: {
        'ueditor.config': '../addons/ueditor/ueditor.config',
        'ueditor': '../addons/ueditor/ueditor.all.min',
        'ueditor.zh': '../addons/ueditor/i18n/zh-cn/zh-cn',
        'zeroclipboard': '../addons/ueditor/third-party/zeroclipboard/ZeroClipboard.min',
    },
    shim: {
        'ueditor': {
            deps: ['zeroclipboard', 'ueditor.config'],
            exports: 'UE',
            init: function (ZeroClipboard) {
                //导出到全局变量，供ueditor使用
                window.ZeroClipboard = ZeroClipboard;
            },
        },
        'ueditor.zh': ['ueditor']
    }
});
require(['form', 'upload'], function (Form, Upload) {
    var _bindevent = Form.events.bindevent;
    Form.events.bindevent = function (form) {
        _bindevent.apply(this, [form]);
        try {
            //绑定editor事件
            require(['ueditor', 'ueditor.zh'], function (UE, undefined) {
                UE.list = [];
                window.UEDITOR_CONFIG['uploadService'] = function (context, editor) {
                    return {
                        Upload: () => { return Upload },
                        Fast: () => { return Fast },
                    }
                };
                $(Config.ueditor.classname || '.editor', form).each(function () {
                    var id = $(this).attr("id");
                    var name = $(this).attr("name");
                    $(this).removeClass('form-control');
                    UE.list[id] = UE.getEditor(id, {
                        allowDivTransToP: false, //阻止div自动转p标签
                        initialFrameWidth: '100%',
                        initialFrameHeight: 320,
                        autoFloatEnabled: false,
                        baiduMapAk: Config.ueditor.baiduMapAk || '', //百度地图api密钥（ak）
                        // autoHeightEnabled: true, //自动高度
                        zIndex: 90,
                        xssFilterRules: false,
                        outputXssFilter: false,
                        inputXssFilter: false,
                        catchRemoteImageEnable: true,
                        imageAllowFiles: '',//允许上传的图片格式，编辑器默认[".png", ".jpg", ".jpeg", ".gif", ".bmp"]
                    });
                    UE.list[id].addListener("contentChange", function () {
                        $('#' + id).val(this.getContent());
                        $('textarea[name="' + name + '"]').val(this.getContent());
                    })
                });
            })
        } catch (e) {
            console.log('绑定editor事件', e)
        }
    }
});
});