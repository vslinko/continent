/**
 * Copyright 2012 Rithis Studio LLC
 * Author Vyacheslav Slinko <vyacheslav.slinko@rithis.com>
 */

(function () {
    $(function () {
        var $textButton = $('[data-publication-add=text]');
        var $emptyButton = $('[data-publication-add=empty]');

        var checkAddButtons = function () {
            if ($('[data-publication-block=empty]').length == 1) {
                $emptyButton.hide();
            } else {
                $emptyButton.show();
            }
        };

        checkAddButtons();

        var $publication = $('[data-publication]');
        var $trash = $('[data-publication-trash]');

        $publication.sortable({
            axis: 'y',
            connectWith: '[data-publication-trash]',
            cursor: 'move',
            items: '[data-publication-block]',
            opacity: .5,
            start: function () {
                $trash.show();
            },
            stop: function () {
                $trash.hide();
            }
        });

        $trash.droppable({
            accept: '[data-publication-block]',
            hoverClass: 'hover',
            drop: function (event, ui) {
                ui.draggable.remove();
                checkAddButtons();
            }
        });

        $('[data-publication-block]').live('click', function () {
            var $this = $(this);

            var type = $this.attr('data-publication-block');

            if (type == 'text') {
                $publication.sortable('disable');

                $this.attr('contenteditable', 'true');

                $this.blur(function () {
                    $this.removeAttr('contenteditable');
                    $publication.sortable('enable');
                });
            }
        });

        var addFunctionFactory = function (type) {
            return function () {
                var $block = $('<div></div>');
                $block.addClass('publication-block');
                $block.attr('data-publication-block', type);

                $publication.append($block);
                checkAddButtons();
            };
        };

        $textButton.click(addFunctionFactory('text'));
        $emptyButton.click(addFunctionFactory('empty'));

        $('[data-publication-button]').click(function () {
            var data = {
                title: $('[data-publication-title]').html(),
                blocks: []
            };

            $('[data-publication-block]').each(function () {
                data.blocks.push({
                    type: $(this).attr('data-publication-block'),
                    content: $(this).html().trim()
                });
            });

            var url = $(this).attr('data-publication-button');

            $.ajax({
                cache: false,
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function (data) {
                    document.location.href = url;
                },
                type: 'PUT',
                url: url
            });
        });
    });
})();
