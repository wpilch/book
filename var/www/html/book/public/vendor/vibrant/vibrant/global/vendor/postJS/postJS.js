/**
 * Created by edmac on 23/06/17.
 */
function postJS(path, parameters, target, method) {
    target = typeof target !== 'undefined' ? target : '';
    method = typeof method !== 'undefined' ? method : 'post';

    var form = $('<form id="postJs"></form>');
    form.remove();
    form.attr("method", method);
    form.attr("action", path);
    form.attr("target", target);

    $.each(parameters, function(key, value) {
        var field = $('<input>');

        field.attr("type", "hidden");
        field.attr("name", key);
        field.attr("value", value);

        form.append(field);
    });

    // The form needs to be a part of the document in
    // order for us to be able to submit it.
    $(document.body).append(form);

    var win = form.submit();
    if(target == '_blank'){
        if (win) {
            //Browser has allowed it to be opened
            win.focus();
        } else {
            //Browser has blocked it
            alert('Please allow the use of popups');
        }
    }
}
