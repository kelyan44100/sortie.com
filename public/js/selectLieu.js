var field = document.getElementById('field');
var operator = document.getElementById('operator');
field.onchange = function () { fieldcheck(); }
operator.onchange = function () { fieldcheck(); }
fieldcheck();

function fieldcheck() {
    if (field.value === 'Plugin ID') {
        for (i = 0; i < operator.options.length; ++i) {
            if (operator.options[i].value !== 'EQUALS') {
                operator.options[i].disabled = true;
            }
        };
        operator.value = 'EQUALS';
    } else {
        for (i = 0; i < operator.options.length; ++i) {
            operator.options[i].disabled = false;
        };

    }
}