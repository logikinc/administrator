$.AdminArchitect = {};

$.AdminArchitect.toggleCollection = function () {
    $(document).on('click', '#toggle_collection', function () {
        var fn = $(this);

        $('input[type=checkbox].collection-item').each(function () {
            $(this).prop("checked", fn.prop('checked'));
        });
    });
};

$.AdminArchitect.handleBatchActions = function () {
    function selected() {
        return $('input[type=checkbox]:checked.collection-item');
    }

    $(document).on('click', '.batch-actions a[data-action]', function () {
        if (! selected().length) {
            return false;
        }

        if ((msg = $(this).data('confirmation')) && !window.confirm(msg)) {
            return false;
        }

        $('#batch_action').val($(this).data('action'));
        $('#collection').submit();

        return false;
    });
};

$.AdminArchitect.dateControls = function () {
    $('[data-filter-type="date"]').datepicker({
        format: 'yyyy-mm-dd',
        clearBtn: false,
        multidate: false
    });

    $('[data-filter-type="daterange"]').daterangepicker({
        format: 'YYYY-MM-DD',
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate: moment()
    });
};

$.AdminArchitect.localize = function () {
    $('button[data-locale]').click(function () {
        var fn = $(this), locale = fn.data('locale');
        var translatable = fn.closest('.translatable-block').find('.translatable');

        translatable.map(function (index, item) {
            var fn = $(item);
            if (fn.data('locale') == locale) {
                fn.removeClass('hidden');
            } else {
                fn.addClass('hidden');
            }
        });
    })
};

$(function () {
    /**
     * Handle LiveSearch controls
     * @type {any}
     */
    $('[data-type="livesearch"]').selectize({
        valueField: 'id',
        labelField: 'name',
        searchField: ['name'],
        create: false,
        loadThrottle: 500,
        maxOptions: 100,
        load: function (query, callback) {
            if (!query.length >= 3) return callback();

            var selectize = $($(this)[0].$input);

            var url = (baseUrl = selectize.data('url')) +
                (baseUrl.indexOf('?') == -1 ? '?' : '&') +
                'query=' + query;

            $.ajax({
                url: url,
                type: 'GET',
                error: callback,
                success: function (res) {
                    if (! res.hasOwnProperty('items')) {
                        console.error(
                            'Livesearch response should have "items" collection. ' +
                            'Each element in collection must have at least 2 keys: "id" and "name"'
                        );

                        return false;
                    }

                    return callback(res.items);
                }
            });
        }
    });

    $('.fancybox').fancybox({
        afterLoad: function () {
            var width, height;
            if (width = $(this.element).data('width')) {
                this.width = width;
            }

            if (height = $(this.element).data("height")) {
                this.height = height;
            }
        }
    });
});
