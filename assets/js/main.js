let i = 0;

$(document).ready(function () {
  const getRandomId = (min = 0, max = 500000) => {
    min = Math.ceil(min);
    max = Math.floor(max);
    const num = Math.floor(Math.random() * (max - min + 1)) + min;
    return num.toString().padStart(6, "0")
  };
  $('#invoice-number').val('IG-' + getRandomId());

  $.validator.setDefaults({
		submitHandler: function() {
			setInvoice();
		}
	});
  $("#invoice-generator-form").validate({
    rules: {
      toName: {
        required: true,
				minlength: 3
      },
      toAddress: {
        required: true,
				minlength: 3
      },
      fromName: {
        required: true,
				minlength: 3
      },
      fromAddress: {
        required: true,
				minlength: 3
      },
      'name[]': {
        required: true,
				minlength: 3
      },
    },
    messages: {}
  });
  
});

$("#add-row").click(function () {
  let index = i+1;
  let rowHtml = '<tr id="addr-'+index+'"><td><input type="text" name="name[]" id="name-'+index+'" placeholder="Enter the item name" class="form-control"></td><td><input type="number" name="unit[]" id="unit-'+index+'" min="1" value="1" placeholder="Enter unit" class="form-control unit" data-index="'+index+'" required ></td><td><input type="number" name="unitPrice[]" id="unit-price-'+index+'" min="0.01" value="0.00" step=".01" placeholder="Enter unit price" class="form-control unitPrice" data-index="'+index+'" required ></td><td><select name="tax[]" id="tax-'+index+'" class="form-control tax" data-index="'+index+'" required ><option value="">Select Tax</option><option value="0">0%</option><option value="1">1%</option><option value="5">5%</option><option value="10">10%</option></select></td><td><input type="text" name="amount[]" id="amount-'+index+'" value="0.00" class="form-control amount" disabled="disabled"><input type="text" name="taxAmount[]" id="taxAmount-'+index+'" class="taxAmount" value="0.00" hidden /></td><td><button onclick="deleteRow('+index+')" type="button" class="btn btn-labeled btn-danger"><span class="btn-label"><em class="fa fa-trash"></em></span></button> <button onclick="clearRow('+index+')" type="button" class="btn btn-labeled btn-info"><span class="btn-label"><em class="fas fa-sync"></em></span></button></td></tr>';
  $('#invoice-table-body').append(rowHtml);
  i++;
});

function deleteRow(index) {
  $("#addr-"+index).remove();
  subTotalCalc();
}

function clearRow(index) {
  $('#name-'+index).val('');
  $('#unit-'+index).val(1);
  $('#unit-price-'+index).val('0.00');
  $('#tax-'+index).val('');
  $('#amount-'+index).val('0.00');
  $('#taxAmount-'+index).val('0.00');
  subTotalCalc();
}

$("body").on("keyup change", ".unit", function(e) {
  let index = $('#'+e.target.id).attr("data-index");
  totalAmountCalc(index);
});
$("body").on("keyup change", ".unitPrice", function(e) {
  let index = $('#'+e.target.id).attr('data-index');
  totalAmountCalc(index);
});
$("body").on("keyup change", ".tax", function(e) {
  let index = $('#'+e.target.id).attr('data-index');
  totalAmountCalc(index);
});
$("#discount-value").on("keyup change", function(e) {
  subTotalCalc();
});

$("#discount").change(function () {
  let discount = $(this).val();
  if(discount === 'PERCENTAGE') {
    $('#discount-value').val('0');
    $('#discount-value').removeAttr('step');
    $('#discount-value').attr('max', '100');
  } else {
    $('#discount-value').val('0.00');
    $('#discount-value').removeAttr('max');
    $('#discount-value').attr('step', '.01');
  }
  subTotalCalc();
});

function totalAmountCalc(index) {
  let totalAmount = 0.00;
  let taxAmount = 0.00;
  let unit = ($('#unit-'+index).val() == '') ? 0 : parseInt($('#unit-'+index).val());
  let unitPrice = ($('#unit-price-'+index).val() == '') ? 0.00 : parseFloat($('#unit-price-'+index).val());
  let tax = ($('#tax-'+index).val() == '') ? 0 : parseInt($('#tax-'+index).val());
  totalAmount = unit * unitPrice;
  if(tax != 0) {
    taxAmount = (tax/100) * totalAmount;
    totalAmount = taxAmount + totalAmount;
  }
  taxAmount = parseFloat(taxAmount).toFixed(2);
  totalAmount = parseFloat(totalAmount).toFixed(2);
  $('#amount-'+index).val(totalAmount);
  $('#taxAmount-'+index).val(taxAmount);
  subTotalCalc();
}

function subTotalCalc() {
  let discount = $('#discount').val();
  let discountValue = ($('#discount-value').val() == '') ? 0 : parseInt($('#discount-value').val());
  let subTotalWithTax = 0.00;
  let totalTax = 0.00;

  let subTotalWithTaxArray = $("input[name='amount[]']").map(function(){return $(this).val();}).get();
  let totalTaxArray = $("input[name='taxAmount[]']").map(function(){return $(this).val();}).get();
  $.each(subTotalWithTaxArray, function (i) {
    subTotalWithTax = subTotalWithTax + parseFloat(subTotalWithTaxArray[i]);
  });
  $.each(totalTaxArray, function (j) {
    totalTax = totalTax + parseFloat(totalTaxArray[j]);
  });
  let subTotalWithoutTax = subTotalWithTax - totalTax;
  
  if(discount === 'PERCENTAGE') {
    subTotalWithoutTax = subTotalWithoutTax - (subTotalWithoutTax * (discountValue/100));
    subTotalWithTax = subTotalWithTax - (subTotalWithTax * (discountValue/100));
  } else {
    subTotalWithoutTax = subTotalWithoutTax - discountValue;
    subTotalWithTax = subTotalWithTax - discountValue;
  }

  subTotalWithTax = parseFloat(subTotalWithTax).toFixed(2);
  subTotalWithoutTax = parseFloat(subTotalWithoutTax).toFixed(2);

  $('#sub-total-without-tax').val(subTotalWithoutTax);
  $('#sub-total-with-tax').val(subTotalWithTax);
}

function setInvoiceValues() {
  let tableHtml = '';
  let name = $("input[name='name[]']").map(function(){return $(this).val();}).get();
  let unit = $("input[name='unit[]']").map(function(){return $(this).val();}).get();
  let unitPrice = $("input[name='unitPrice[]']").map(function(){return $(this).val();}).get();
  let tax = $("select[name='tax[]']").map(function(){
    return $(this).val();
  }).get();
  let amount = $("input[name='amount[]']").map(function(){return $(this).val();}).get();
  
  $.each(amount, function (i) {
    let j= i+1;
    tableHtml += '<tr class="list-item"><td data-label="no" class="tableitem">'+j+'</td><td data-label="name" class="tableitem">'+name[i]+'</td><td data-label="unit" class="tableitem">'+unit[i]+'</td><td data-label="unitPrice" class="tableitem">$ '+unitPrice[i]+'</td><td data-label="tax" class="tableitem">'+tax[i]+' %</td><td data-label="no" class="tableitem">$ '+amount[i]+'</td></tr>';
  });
  $('#table-main').html(tableHtml);
  $('#invoiceNumber').html($('#invoice-number').val());
  let date = moment($('#invoice-date').val()).format('DD/MM/YYYY');
  $('#invoiceDate').html(date);
  $('#toName').html($('#to-name').val());
  $('#toAddress').html($('#to-address').val());
  $('#fromName').html($('#from-name').val());
  $('#fromAddress').html($('#from-address').val());
  let discount = $('#discount').val();
  if(discount === 'PERCENTAGE') {
    $('#discount-value-print').html($('#discount-value').val()+ ' %');
  } else {
    $('#discount-value-print').html('$ ' +$('#discount-value').val());
  }

  $('#sub-total-without-tax-print').html('$ ' +$('#sub-total-without-tax').val());
  $('#sub-total-with-tax-print').html('$ ' +$('#sub-total-with-tax').val());
}

function setInvoice() {
  setInvoiceValues();
  let contents = $("#invoiceholder").html();
  let frame1 = $('<iframe />');
  frame1[0].name = "frame1";
  frame1.css({ "position": "absolute", "top": "-1000000px" });
  $("body").append(frame1);
  let frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
  frameDoc.document.open();
  frameDoc.document.write('<html><head><title>Invoice</title>');
  frameDoc.document.write('</head><body>');
  frameDoc.document.write('<link rel="stylesheet" href="assets/css/invoice-style.css">');
  frameDoc.document.write(contents);
  frameDoc.document.write('</body></html>');
  frameDoc.document.close();
  setTimeout(function () {
    window.frames["frame1"].focus();
    window.frames["frame1"].print();
    frame1.remove();
  }, 500);
}

