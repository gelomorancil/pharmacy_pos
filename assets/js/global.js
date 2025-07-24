var delay = (function() {
    var timer = 0;
    return function(callback, ms) {
        clearTimeout(timer);
        timer = setTimeout(callback, ms);
    };
})();
var check_changes = (elements = []) => {
    var found = false;
    $.each(elements, function(key, val) {
        $(val).each(function() {
            if ($(this).data('default') !== $(this).val()) {
                found = true;
            }
        })
    });
    return found;
}

var update_forms = (elements = []) => {
    $.each(elements, function(key, val) {
        $(val).each(function() {
            $(this).data('default', $(this).val());

        })
    });

}

var unit_permission = (condition, values) => {    
    // switch (condition) {
    //     case 'lgu':
    //         return (bool) values.city_id && (bool) values->province_id && (bool) values->region_id; 
    //         break;
    //     case 'provincial':
    //         return  !((bool) values->city_id) && values->province_id && (bool) values->region_id; 
    //         break;
    //     case 'regional':
    //         return  !((bool) values->city_id) && !((bool) values->province_id) &&  (bool) values->region_id; 
    //         break;
    //     default:
    //         return false;
    //         break;
    // }
}

// var credentails_dialog = $.dialog({
//     lazyOpen: true,
//     closeIcon: true,
//     escapeKey: true,
//     backgroundDismiss: false,
//     type: 'red',
//     theme: 'modern',
//     class:'danger',
//     containerFluid: true,
//     columnClass: 'col-md-4 offset-md-4',
//     title: '',
//     content: '' +
//     '<h4>Security Alert!</h4>'+
//     '<div class="form">' +
//         '<div class="form-group">' +
//             '<input type="text" placeholder="username" class="name form-control credentials" data-field="username" required />' +
//             '<br>'+
//             '<input type="password" placeholder="password" class="name form-control credentials" data-field="password" required />' +
//             '<br>'+
//             '<button class="btn btn-success w-100" id="submit-credentails">SUBMIT <span class="loading" data-id="submit-credentails"></span></button>' +
//         '</div>' +
//     '</div>',

// });