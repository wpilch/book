// initial setUp
$(function () {
    //turn on tooltips
    $('[data-toggle="tooltip"]').tooltip();
    //turn on popovers
    $('[data-toggle="popover"]').popover();
    //handle input
    let input = $('.vib-input');
    input.focusin(function(){
        let formGroup = $(this).closest('.form-group');
        formGroup.addClass('is-focus');
        formGroup.removeClass('has-error');
        formGroup.removeClass('force-error');
    });
    input.focusout(function(){
        let formGroup = $(this).closest('.form-group');
        formGroup.removeClass('is-focus');
    });
});
// Handle bootstrap vibForms
(function() {
    'use strict';
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-bs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                let custom_validity = true;
                //Begin Pre-processing
                //Switch
                let checkboxes = form.querySelectorAll('input[type=checkbox]');
                checkboxes.forEach( function (checkbox) {
                    if(typeof(checkbox.dataset.plugin) != undefined){
                        if(checkbox.dataset.plugin == 'bSwitch'){
                            let hiddenPair = document.getElementById(checkbox.dataset.hiddenPair);
                            if(checkbox.checked){
                                hiddenPair.value = checkbox.dataset.onValue
                            }
                            else{
                                hiddenPair.value = checkbox.dataset.offValue
                            }
                        }
                    }
                });

                //End pre-processing

                if (form.checkValidity() === false || custom_validity === false) {
                    event.preventDefault();
                    event.stopPropagation();
                    form.classList.add('was-validated');

                }else{
                    form.classList.add('was-validated');
                    if (form.classList.contains('is-ajax')) {
                        event.preventDefault();
                        event.stopPropagation();
                        handelAjaxForm();
                    }else{
                        afterBsValidationNoAjax();
                    }
                }
            }, false);
        });
    }, false);
})();
