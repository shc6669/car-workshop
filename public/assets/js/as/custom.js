// Datepicker
$('#start_at').datepicker({
    orientation: 'bottom',
    startView: 'month',
    format: 'yyyy-mm-dd'
});

// Select2
$("#car_id").select2({"allowClear":true,"placeholder":{"id":"","text":"Please Select Option"}});
$("#mechanic_id").select2({"allowClear":true,"placeholder":{"id":"","text":"Please Select Option"}});
$("#user_id").select2({"allowClear":true,"placeholder":{"id":"","text":"Please Select Option"}})
