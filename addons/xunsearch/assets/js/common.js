$(function () {
    var form = $('#search-form');
    var search = $("input[name='q']", form);
    search.autoComplete({
        minChars: 1,
        menuClass: 'autocomplete-search',
        header: '',
        footer: '',
        source: function (term, response) {
            try {
                xhr.abort();
            } catch (e) {
            }
            xhr = $.getJSON(form.data("suggestion"), {name: form.data("project"), q: term}, function (data) {
                response(data);
            });
        },
        onSelect: function (e, term, item) {
            if (typeof callback === 'function') {
                callback.call(elem, term, item);
            } else {
                form.trigger("submit");
            }
        }
    });
    form.submit(function () {
        if (search.val() == '') {
            alert('请输入搜索关键词');
            search.focus();
            return false;
        }
    });
    $(document).on("click", "ul.orderlist li a", function () {
        $("input[name=order]", form).val($(this).data("value"));
        form.trigger("submit");
    });
});