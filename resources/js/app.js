import createI18n from './lang/lang.js';
const lang = createI18n({locale: window.Locale || 'vi'});
import 'bootstrap';
import $ from 'jquery';
window.$ = $;
import 'metismenu';
import JsBarcode from "jsbarcode";
import Swal from 'sweetalert2';
window.Swal = Swal;
import * as FilePond from 'filepond';
import 'filepond/dist/filepond.min.css';
window.FilePond = FilePond;
const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
});
window.showAlertSuccess = function(message) {
    Toast.fire({
        icon: "success",
        title: lang.alert_success,
        text: message,
        showCloseButton: true,
        timer: 1500
    });
}

window.showAlertError = function(message) {
    Toast.fire({
        icon: "error",
        title: lang.alert_error,
        text: message,
        showCloseButton: true,
        timer: 1500
    });
}

import Choices from 'choices.js';
import 'choices.js/public/assets/styles/choices.min.css';
$(document).ready(function() {
    $('.choices').each(function() {
        new Choices(this, {
            noResultsText: lang.choices_no_result,
            itemSelectText: lang.choices_press_enter,
            placeholder: true,
        });
    });
});
window.formatDecimalNumber = function formatDecimalNumber(number,decimal,localeId){
    return new Intl.NumberFormat(localeId, { 
        minimumFractionDigits: decimal,
        maximumFractionDigits: decimal
    }).format(number);
}

window.Choices = Choices;