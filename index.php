<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice generator</title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link href="assets/font-awesome/css/all.css" rel="stylesheet">
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/jquery.validate.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
</head>
<body>
  <nav class = "navbar navbar-default" role = "navigation">
      <div class = "navbar-header">
        <a class = "navbar-brand">Invoice generator</a>
      </div>
  </nav>

  <div class="container">
    <div class="row clearfix mt-2">
      <div class="col-md-4">
        <table class="table table-bordered table-hover" id="tab_logic_total">
          <tbody>
            <tr>
              <th class="text-center">INVOICE NO</th>
              <td class="text-center">
                <input type="text" name='invoiceNumber' class="form-control" id="invoice-number" disabled/>
              </td>
            </tr>
            <tr>
              <th class="text-center">INVOICE DATE</th>
              <td class="text-center">
                <input type="date" class="form-control" name='invoiceDate' id="invoice-date" max="<?=date('Y-m-d');?>" />
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="col-md-4">
        <table class="table table-bordered table-hover" id="tab_logic_total">
          <tbody>
            <tr>
              <th class="text-center">BILL/SHIP TO</th>
              <td class="text-center">
                <input type="text" name='toName' placeholder='Enter name' class="form-control" id="to-name"/>
              </td>
            </tr>
            <tr>
              <th class="text-center">ADDRESS</th>
              <td class="text-center">
                <textarea name='toAddress' id="to-address" placeholder='Enter address' class="form-control"></textarea>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="col-md-4">
        <table class="table table-bordered table-hover" id="tab_logic_total">
          <tbody>
            <tr>
              <th class="text-center">FROM</th>
              <td class="text-center">
                <input type="text" name='fromName' placeholder='Enter your company name' class="form-control" id="from-name"/>
              </td>
            </tr>
            <tr>
              <th class="text-center">ADDRESS</th>
              <td class="text-center">
                <textarea name='fromAddress' id="from-address" placeholder='Enter your company address' class="form-control"></textarea>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>


    <div class="row clearfix">
      <div class="col-md-12 table-responsive">
        <table class="table table-bordered table-hover m-2" id="tab_logic">
          <thead>
            <tr></tr>
              <th class="text-center"> Name </th>
              <th class="text-center"> Unit </th>
              <th class="text-center"> Unit Price($) </th>
              <th class="text-center"> Tax </th>
              <th class="text-center"> Total Amount </th>
              <th class="text-center"></th>
            </tr>
          </thead>
          <tbody>
            <tr id="addr0">
              <td><input type="text" name='name[]'  placeholder='Enter the item name' class="form-control"/></td>
              <td><input type="number" name='unit[]' min="1" value="1"  placeholder='Enter unit' class="form-control"/></td>
              <td><input type="number" name='unitPrice[]' min="1" value="0.00" step=".01"  placeholder='Enter unit price' class="form-control"/></td>
              <td>
                <select name='tax[]' class="form-control">
                  <option value="">Select Tax</option>
                  <option value="0">0%</option>
                  <option value="1">1%</option>
                  <option value="5">5%</option>
                  <option value="10">10%</option>
                </select>
              </td>
              <td><input type="text" name='amount[]'  placeholder='0.00' class="form-control" disabled/></td>
              <td>
                <button type="button" class="btn btn-labeled btn-danger">
                  <span class="btn-label"><em class="fa fa-trash"></em></span>
                </button>
                <button type="button" class="btn btn-labeled btn-info">
                  <span class="btn-label"><em class="fas fa-sync"></em></span>
                </button>
              </td>
            </tr>
            
          </tbody>
        </table>
      </div>
    </div>
    <div class="row clearfix">
      <div class="col-md-12">
        <button id='delete_row' class="pull-right btn btn-default">
          <span class="btn-label"><em class="fas fa-plus-circle"></em></span> Add Row
        </button>
      </div>
    </div>
    <div class="row clearfix mt-2">
      <div class="pull-right col-md-4">
        <table class="table table-bordered table-hover" id="tab_logic_total">
          <tbody>
            <tr>
              <th class="text-center">
                <span>Discount</span>
                <select id='discount' class="form-control discount">
                  <option value="PERCENTAGE">Percentage(%)</option>
                  <option value="AMOUNT">Amount ($)</option>
                </select>
              </th>
              <td class="text-center">
                <input type="number" name='discountValue' id="discount-value" value='0.00' step=".01" class="form-control"/>
              </td>
            </tr>

            <tr>
              <th class="text-center">Subtotal without tax</th>
              <td class="text-center">
                <input type="number" name='subTotalWithOutTax' value='0.00' step=".01" class="form-control" id="sub-total-without-tax" disabled/>
              </td>
            </tr>
           
            <tr>
              <th class="text-center">Subtotal with tax</th>
              <td class="text-center">
                <input type="number" name='subTotalWithTax' id="sub-total-with-tax" value='0.00' step=".01" class="form-control" disabled/>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="text-center">
      <button type="button" class="btn btn-labeled btn-success">
        <span class="btn-label"><em class="fas fa-print"></em></span> Generate Invoice
      </button>
      <button type="button" class="btn btn-labeled btn-info">
        <span class="btn-label"><em class="fas fa-sync"></em></span> Refresh
      </button>
    </div>
   
  </div>

  <script src="assets/js/main.js"></script>
</body>
</html>
