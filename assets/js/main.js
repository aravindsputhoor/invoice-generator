$(document).ready(function () {
  const getRandomId = (min = 0, max = 500000) => {
    min = Math.ceil(min);
    max = Math.floor(max);
    const num = Math.floor(Math.random() * (max - min + 1)) + min;
    return num.toString().padStart(6, "0")
  };
  $('#invoice-number').val('IG' + getRandomId());

  let i = 1;
  $("#add_row").click(function () {
    b = i - 1;
    $('#addr' + i).html($('#addr' + b).html()).find('td:first-child').html(i + 1);
    $('#tab_logic').append('<tr id="addr' + (i + 1) + '"></tr>');
    i++;
  });
  $("#delete_row").click(function () {
    if (i > 1) {
      $("#addr" + (i - 1)).html('');
      i--;
    }
    calc();
  });

  $('#tab_logic tbody').on('keyup change', function () {
    calc();
  });
  $('#advance_amount').on('keyup change', function () {
    calc_total();
  });

});

function calc() {
  $('#tab_logic tbody tr').each(function (i, element) {
    let html = $(this).html();
    if (html != '') {
      calc_total();
    }
  });
}

function calc_total() {
  let total = 0;
  $('.total').each(function () {
    total += parseInt($(this).val());
  });
  $('#sub_total').val(total.toFixed(2));
  $('#total_amount').val((total - $('#advance_amount').val()).toFixed(2));
}