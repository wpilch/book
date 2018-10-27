//toastr
toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-bottom-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};
//ladda
let submitBtns = document.querySelectorAll( 'button[type=submit]');
for (let submitBtn of Array.from(submitBtns)) {
    if( !submitBtn.hasAttribute( 'data-style' ) ) {
        submitBtn.setAttribute( 'data-style', 'expand-left' );
    }
}

let laddaBtns = document.getElementsByClassName( 'ladda-button');
for (let laddaBtn of Array.from(laddaBtns)) {
    if( !laddaBtn.hasAttribute( 'data-style' ) ) {
        laddaBtn.setAttribute( 'data-style', 'expand-left' );
    }
}

let loadingBtns = document.getElementsByClassName( 'loading-button' );
for (let loadingBtn of Array.from(loadingBtns)) {
    if( loadingBtn && !loadingBtn.hasAttribute( 'data-style' ) ) {
        loadingBtn.setAttribute( 'data-style', 'expand-left' );
    }
    Ladda.bind( loadingBtn );
}
