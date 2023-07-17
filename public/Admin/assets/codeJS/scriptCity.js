var fixHelperModified = function(e, tr) {
    var $originals = tr.children();
    var $helper = tr.clone();
    $helper.children().each(function(index) {
        $(this).width($originals.eq(index).width())
    });
    return $helper;
};

var updateIndex = function(e, ui) {
    var trData = document.getElementsByClassName('item');
    let ids = [];
    for(let i= 0 ; i<trData.length; i++) {
        ids.push(trData[i].getAttribute('aria-valuenow'));
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        }
    });
    if (ids) {
        ids = JSON.stringify(ids);
        $.get("/cities/updateRange", {
            "ids": ids,
        }, function(data, status, xhr) {
            var arrangement = document.getElementsByClassName('arrangement');
            for(let i= 0 ; i<arrangement.length; i++) {
                arrangement[i].innerHTML = i + 1;
            }
            location.reload();
        });
    }
    $('tr.index', ui.item.parent()).each(function(i) {
        $(this).html(i + 1);
    });
};

$("#user-list-table tbody").sortable({
axis: "y",
containment: "parent",
helper: fixHelperModified,
stop: updateIndex
}).disableSelection();
