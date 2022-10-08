let i = 0;

$(document).ready(function () {
  const getRandomId = (min = 0, max = 500000) => {
    min = Math.ceil(min);
    max = Math.floor(max);
    const num = Math.floor(Math.random() * (max - min + 1)) + min;
    return num.toString().padStart(6, "0")
  };
  $('#invoice-number').val('IG' + getRandomId());
});

$("#add-row").click(function () {
  let index = i+1;
  let rowHtml = '<tr id="addr-'+index+'"><td><input type="text" name="name[]" id="name-'+index+'" placeholder="Enter the item name" class="form-control"></td><td><input type="number" name="unit[]" id="unit-'+index+'" min="1" value="1" placeholder="Enter unit" class="form-control unit" data-index="'+index+'"></td><td><input type="number" name="unitPrice[]" id="unit-price-'+index+'" min="0.01" value="0.00" step=".01" placeholder="Enter unit price" class="form-control unitPrice" data-index="'+index+'"></td><td><select name="tax[]" id="tax-'+index+'" class="form-control tax" data-index="'+index+'"><option value="">Select Tax</option><option value="0">0%</option><option value="1">1%</option><option value="5">5%</option><option value="10">10%</option></select></td><td><input type="text" name="amount[]" id="amount-'+index+'" placeholder="0.00" class="form-control" disabled="disabled"></td><td><button onclick="deleteRow('+index+')" type="button" class="btn btn-labeled btn-danger"><span class="btn-label"><em class="fa fa-trash"></em></span></button> <button onclick="clearRow('+index+')" type="button" class="btn btn-labeled btn-info"><span class="btn-label"><em class="fas fa-sync"></em></span></button></td></tr>';
  $('#invoice-table-body').append(rowHtml);
  i++;
});

function deleteRow(index) {
  $("#addr-"+index).remove();
}

function clearRow(index) {
  $('#name-'+index).val('');
  $('#unit-'+index).val(1);
  $('#unitPrice-'+index).val(0.00);
  $('#tax-'+index).val('');
  $('#amount-'+index).val('');
}

