jQuery(document).ready(function ($) {

    function normalizeTransportFeatureLabels(context) {
        var $context = context ? $(context) : $(document);

        $context.find('.mptbm_transport_search_area ul.list_inline_two li span[title]').each(function () {
            var $label = $(this);
            var title = ($label.attr('title') || '').trim();

            if (!title || title.indexOf(':') === -1) {
                return;
            }

            var normalizedTitle = title.replace(':', ': ');

            if ($label.text().trim() !== normalizedTitle) {
                $label.text(normalizedTitle);
            }
        });
    }

    function findScrollableParent(element) {
        var $element = $(element);
        var $parent = $element.parent();

        while ($parent.length) {
            var overflow = $parent.css('overflow-y');
            if (overflow === 'auto' || overflow === 'scroll') {
                if ($parent[0].scrollHeight > $parent[0].clientHeight) {
                    return $parent;
                }
            }
            $parent = $parent.parent();
        }

        var $modalContent = $element.closest('.urbantaxi-modal-content');
        if ($modalContent.length && $modalContent[0].scrollHeight > $modalContent[0].clientHeight) {
            return $modalContent;
        }

        var $mainSection = $element.closest('.mainSection');
        if ($mainSection.length && $mainSection[0].scrollHeight > $mainSection[0].clientHeight) {
            return $mainSection;
        }

        var $mpStickyArea = $element.closest('.mp_sticky_depend_area');
        if ($mpStickyArea.length && $mpStickyArea[0].scrollHeight > $mpStickyArea[0].clientHeight) {
            return $mpStickyArea;
        }

        return null;
    }

    normalizeTransportFeatureLabels(document);

    $(document).ajaxComplete(function () {
        normalizeTransportFeatureLabels(document);
    });

    $(document).on('click', '.mptbm_transport_select', function (e) {

        e.preventDefault();
        e.stopPropagation();

        var $button = $(this);
        var $scrollableParent = findScrollableParent($button);

        if ($scrollableParent) {
            $scrollableParent.animate({
                scrollTop: $scrollableParent[0].scrollHeight
            }, 500);
        }

    });

});